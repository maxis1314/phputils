<?php
require ("app/class/HTMLGenerater.php");
require ("app/class/Validate.php");

class in_controller extends application {

	function filter($method) {
	}

	private function getOption($xml, $name, $option = "") {
		return either($xml-> {
			$name . $option }, $xml-> {
			$name });
	}
	private function getOptionArr($xml, $name, $option = "") {
		return either($xml[$name . $option], $xml[$name]);
	}

	function x2fc($params) {
		$this->x2f($params, true);
	}

	function x2f($params, $confirm = false,$procedure="in_controller__form_mail") {
		$formG = new FormGeneratorList($_POST);
		$file = get_w($params[0]);
		$option = get_w($params[1]);
		if (!$option) {
			$option = "";
		}
		if (!$file or !file_exists(ROOT . "data/xml/$file.xml")) {
			exit;
		}
		$xml = simplexml_load_file(ROOT . "data/xml/$file.xml");

		//setting
		$sendmail = ($xml->sendmail == "yes");
		$mailto = (string) $this->getOption($xml, "mailto", $option);
		$formG->title = (string) $this->getOption($xml, "title", $option);
		$formG->postTo = (string) $this->getOption($xml, "postback", $option);
		$formG->md5seed = (string) $this->getOption($xml, "md5seed", "");
		if ((string) $this->getOption($xml, "confirm", "") == "yes") {
			$confirm = true;
		}

		$form = $xml->form;
		$counti = 1;
		foreach ($form->field as $field) {
			$field = (array) $field;
			$temp = array ();
			$temp["DISPLAY"] = $this->getOptionArr($field, "display", $option);
			$temp["NAME"] = either($field["name"], "formelement_" . $counti++);
			$html = $field["htmlgenerator"];
			$classname = (string) $html->name;

			if ($classname == "HiddenGenerator") {
				$temp["HTML"] = new $classname (either((string) $html->param1, f($temp["NAME"])));
			} else {
				$temp["HTML"] = new $classname ((string) $html->param1, (string) $html->param2, (string) $html->param3);
			}

			$tempvalid = array ();
			foreach ($field["valids"] as $validitem) {
				$classname = (string) $validitem->name;
				$tempvalid[] = new $classname ((string) $validitem->param1, (string) $validitem->param2, (string) $validitem->param3);
			}
			$temp["VALID"] = $tempvalid;
			$temp["ERROR"] = $this->getOptionArr($field, "error", $option);
			;
			$formG->addGenerator($temp);
		}

		$ra_param=array();
		$ra_param["sendmail"]=$sendmail;
		$ra_param["confirm"]=$confirm;
		echo $this->processForm($formG,$procedure,$ra_param);

		echo $this->htmlfooter();
		exit;
	}

	private function processForm($formG, $func, $option) {
		$str = "";
		$strok = "";
		$str .= $this->htmlheader();
		$str .= $this->cool_form_header();
		if ($this->is_post()) {
			if ($formG->check()) {
				if ($option["confirm"]) {
					if (p("auto_submit_md5")) {
						$func ($this,$formG, $option);
						$this->to_path("/in/over");
					} else {
						$strok .= $this->htmlheader();
						$strok .= $this->cool_form_header();
						$strok .= $formG->getConfirmHTML();
					}
				} else {
					if ($formG->postTo) {
						$strok .= $formG->getAutoComitHTML();
					} else {
						$func ($this, $formG,$option);
						$this->to_path("/in/over");
					}
				}
			} else {
				$str .= $formG->getCheckHTML();
			}
		} else {
			$str .= $formG->getHTML();
		}

		if ($strok) {
			return $strok;
		} else {
			return $str;
		}
	}

	function ask(){
		if ($this->is_post()) {
			$this->kdmail(array (
				"from" => $control->config["site"]["mail"],
				"fromname" => "Family",
				"to" => $control->config["site"]["mail"],
				"toname" => "Family",
				"subject" => p("Title"),
				"msg" => p("Name")."\n".p("Email")."\n".p("Content")
			));
		}else{
			echo "-n Name -s 名前/Name -g InputTextGenerator -v NotNullValidate\n";
			echo "-n Email -s メールアドレス/Email -g InputTextGenerator -v EmailValidate\n";
			echo "-n Title -s タイトル/Title -g InputTextGenerator -v NotNullValidate\n";
			echo "-n Content -s 内容/Content -g TextareaGenerator -v NotNullValidate";			
		}
		exit;
	}
	
	function reg() {		
		$formG = new FormGeneratorList($_POST);
		
		$str = $this->htmlheader();
		$str.= $this->cool_form_header();
		$formG->title = "登録/Register";
		$input = array ();

		$input[] = array (
			"DISPLAY" => "メールアドレス/Email",
			"NAME" => "email",
			"HTML" => new InputTextGenerator(),
			"VALID" => new EmailValidate(),
			"ERROR" => ""
		);

		$input[] = array (
			"DISPLAY" => "パスワード/Password",
			"NAME" => "password",
			"HTML" => new PasswordGenerator(),
			"VALID" => new PasswordValidate(),
			"ERROR" => "(must not be empty) comma(,) is not allowed"
		);

		$input[] = array (
			"DISPLAY" => "性別/Gender",
			"NAME" => "sex",
			"HTML" => new RadioboxGenerator(array (
				"Male",
				"Female"
			)),
			"VALID" => new NotNullValidate(),
			"ERROR" => ""
		);

		$input[] = array (
			"DISPLAY" => "生年月日/Birthday",
			"NAME" => "bir",
			"HTML" => new YMDGenerator(),
			"VALID" => new YMDValidate(),
			"ERROR" => ""
		);

		$input[] = array (
			"DISPLAY" => "画像認証/Authentication",
			"NAME" => "authpic",
			"HTML" => new AuthPicGenerator(),
			"VALID" => new AuthPicValidate(),
			"ERROR" => ""
		);

		foreach($input as $item){
			$formG->addGenerator($item);
		}
				
		if ($this->is_post()) {
			if ($formG->check()) {
				$record = $formG->valueS;
				$exist = $this->model("user")->peek(array (
					'email' => $record['email']
				));
				if (!$exist) {
					if(p("auto_submit_md5")){
						$this->model("user")->save(array (
							'name' => $record['email'],
							'pass' => $record['password'][0],
							'email' => $record['email'],
							'gend' => $record['sex'],
							'year' => $record['bir'][0],
							'month' => $record['bir'][1],
							'day' => $record['bir'][2],
							'validflg' => 1
						));
						$this->to_path("/in/over");
					}else{
						$str.= $formG->getConfirmHTML();
					}
				} else {
					$str.= '<font color=red>This email has already been registed</font><br>';
					$str.= $formG->getCheckHTML();
				}
			} else {
				$str.= $formG->getCheckHTML();
			}
		} else {
			$str.= $formG->getHTML();
		}
		echo $str;
		echo $this->htmlfooter();
		exit;		
	}

	function table() {
		$formG = new FormGeneratorList($_POST);
		$t = "test";
		//$db = $this->model($t,"utf8");
		$db = $this->fmodel($t);
		$table_detail = $db->detail();
		$formG->title = "Data Collect";
		$formG->postTo = "";
		$formG->md5seed = "";
	
		$title = "Data Collect";

		foreach ($table_detail as & $i) {
			if (!in_array($i['name'], array (
					"id"
				))) {
				$formG->addGenerator(array (
					"DISPLAY" => $i['name'],
					"NAME" => $i['name'],
					"HTML" => new InputTextGenerator(),
					"VALID" => new LengthValidate(1, 300),
					"ERROR" => ""
				));
			}
		}
		$ra_param=array();
		$ra_param["sendmail"]=true;
		$ra_param["confirm"]=true;
		$ra_param["db"]=$db;
		echo $this->processForm($formG,"in_controller__form_table",$ra_param);

		echo $this->htmlfooter();
		exit;

	}

	private function cool_form_header() {
		return '<link rel="stylesheet" type="text/css" media="all" href="/public/data/form/default-style.css" />';
	}	

	function over() {
		echo $this->cool_form_header();
		echo "<form><fieldset><legend>Procss Result</legend><br><b>Operated successfully, Thank you!</b></fieldset></form>";
		//echo '<input type="button" value="Close Window" onclick="window.close();">';
		exit;
	}
}

function in_controller__form_mail($control, $formG,$option) {
	if($option["sendmail"]){
		$control->kdmail(array (
			"from" => $control->config["site"]["mail"],
			"fromname" => "WEB",
			"to" => either($mailto, $control->config["site"]["mail"]),
			"toname" => "FORM",
			"subject" => "ASK",
			"msg" => $formG->getMailStr() . $control->get_client_info()
		));
	}
}



function in_controller__form_table($control, $formG,$option) {
	$option["db"]->save($formG->valueT);
}

/*
 * $this->kdmail(array(
			"from"=>$this->config["site"]["mail"],
			"fromname"=>"テスト",
			"to"=>$this->config["site"]["mail"],//.",".$this->config["site"]["mailt"],
			"toname"=>"テスト",
			"subject"=>"テスト",
			"msgfile"=>__FILE__,
			"files"=>array(__FILE__)
		));
 */
?>