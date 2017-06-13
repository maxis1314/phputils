<?php
class FormGeneratorList {
	var $list = array ();
	var $valueS = null;
	var $valueT = null;
	var $postTo = null;
	var $title = null;
	var $md5seed = null;

	function __construct($v) {
		$this->valueS = $v;
	}
	function addGenerator($generator) {
		array_push($this->list,$generator);
	}

	function getHTML() {
		$str = "";
		$str .= "<form method=POST class=niceform action=\"{$this->postTo}\">\n";
		$str .= "<fieldset><legend>{$this->title}</legend>";

		foreach ($this->list as $i) {
			if ($i["HTML"] instanceof HiddenGenerator) {
				$str .= $i["HTML"]->getHTML($i["NAME"]);
			} else {
				$str .= "<h3>" . either($i["DISPLAY"], $i["NAME"]) . "</h3>" .
				$i["HTML"]->getHTML($i["NAME"]);
				$str .= "<br>\n";
			}
		}
		$str .= "</fieldset><input class=button type=submit><br></form>";
		return $str;
	}

	function getCheckHTML() {
		$str = "";
		$str .= "<form method=POST class=niceform action=\"{$this->postTo}\">\n";
		$str .= "<fieldset><legend>{$this->title}</legend>";

		foreach ($this->list as $i) {
			$value = $this->valueS[$i["NAME"]];
			if ($i["HTML"] instanceof HiddenGenerator) {
				$str .= $i["HTML"]->getHTML($i["NAME"], $value);
			} else {
				$str .= "<h3>" . either($i["DISPLAY"], $i["NAME"]) . "</h3>" . $i["HTML"]->getHTML($i["NAME"], $value);
			}
			if ($i["VALID"]) {
				if (!is_array($i["VALID"])) {
					$i["VALID"] = array (
						$i["VALID"]
					);
				}
				$first = true;
				foreach ($i["VALID"] as $valid) {
					if (!$valid->check($value)) {
						$allok = false;
						if ($first) {
							$first = false;
						} else {
							$str .= ",";
						}
						$str .= "&nbsp;<font color=red>" . either($i["ERROR"], $valid->msg) . "</font>";
					}
				}
			}
		}
		$str .= "<br>\n";
		$str .= "</fieldset><input class=button type=submit><br></form>";
		return $str;
	}

	function getAutoComitHTML(){
		$str ="";
		$strmd5="";
		$str.= "<script language=javascript> 
		setTimeout(\"document.form1.submit()\",0) 
		</script><form class=niceform name=form1 method=POST action='$postto'>";				
		
		foreach ($this->list as $i) {
			$value = $this->valueS[$i["NAME"]];
			$key = $i["NAME"];
			if(is_array($value)){
				$str.="<input type=hidden name=$key value=\"".e(implode(",",$value))."\">";
				$strmd5.=implode(",",$value);
			}else{
				$strok.="<input type=hidden name=$key value=\"".e($value)."\">";
				$strmd5.=$value;
			}
		}
		$strmd5=md5($strmd5.$this->md5seed);
		$str.= "<input type=hidden name=auto_submit_md5 value=\"$strmd5\"></form>";
		return $str;
	}

	function getConfirmHTML() {
		$strmd5="";
		$str = "";
		$str .= "<form method=POST class=niceform action=\"{$this->postTo}\">\n";
		$str .= "<fieldset><legend>Confirm</legend>";
		foreach ($this->list as $i) {
			$value = $this->valueS[$i["NAME"]];
			$key = $i["NAME"];
			$needtodisplay = true;
			if ($i["HTML"] instanceof HiddenGenerator) {
				$needtodisplay = false;
			}
			if ($i["HTML"] instanceof AuthPicGenerator) {
				$needtodisplay = false;
			}			
			if ($i["HTML"] instanceof PasswordInputGenerator) {
				$needtodisplay = false;
			}

			if (is_array($value)) {
				$value = implode(",", $value);
			}
			if ($needtodisplay) {
				$str .= "<h3>" . either($i["DISPLAY"], $i["NAME"]) . "</h3>" . e($i["HTML"]->getHTMLConfirm($i["NAME"], $value));
			}
			$str .= "<input type=hidden name=$key value=\"" . e($value) . "\">";
			$strmd5 .= $value;
		}
		$strmd5 = md5($strmd5 . $this->md5seed);
		$str .= "<input type=hidden name=auto_submit_md5 value=\"$strmd5\">";
		$str .= "</fieldset><input type=button class=button onclick=\"history.back(); return false;\" value=Back>&nbsp;<input class=button type=submit></form>";
		return $str;
	}

	function check() {
		foreach ($this->list as $i) {
			$value = $this->valueS[$i["NAME"]];
			$this->valueT[$i["NAME"]]=$value;
			if ($i["VALID"]) {
				if (!is_array($i["VALID"])) {
					$i["VALID"] = array (
						$i["VALID"]
					);
				}
				foreach ($i["VALID"] as $valid) {
					if (!$valid->check($value)) {
						return false;
					}
				}
			}
		}
		return true;
	}

	function getMailStr() {
		$mailstr = "";
		foreach ($this->list as $i) {
			$value = $this->valueS[$i["NAME"]];
			$mailstr .= "<h3>" . either($i["DISPLAY"], $i["NAME"]) . "</h3>" . $i["HTML"]->getHTMLConfirm($i["NAME"], $value);
			$mailstr .= "<br>\n";
		}
		return $mailstr;
	}
}

//-------small classes 
class HTMLGenerator {
	function getHTML() {

	}
	function getHTMLConfirm() {

	}
}

class AuthPicGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		return "<a href=# onclick=\"document.getElementById('authpic').setAttribute('src','/out/authpic?'+Math.random());return false;\"><img alt='click to change' width=80 height=30 id=authpic src='/out/authpic'></a><br><input type=text name=\"{$name}\" value=\"\">";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class FileGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		return "<input type=file name=\"{$name}\" value=\"\">";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class InputTextGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		$value = htmlspecialchars($value, ENT_QUOTES);
		return "<input type=text name=\"{$name}\" value=\"{$value}\">";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class HiddenGenerator extends HTMLGenerator {
	var $hiddenvalue;
	function __construct($hiddenvalue) {
		$this->hiddenvalue = $hiddenvalue;
	}
	function getHTML($name, $value) {
		if (!$value) {
			$value = $this->hiddenvalue;
		}
		$value = htmlspecialchars($value, ENT_QUOTES);
		return "<input type=hidden name=\"{$name}\" value=\"{$value}\">";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class PasswordGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		return "<input type=password name=\"{$name}[]\" value=\"\">" .
		"&nbsp;Again:<input type=password name=\"{$name}[]\" value=\"\">";
	}
	function getHTMLConfirm($name, $value) {
		return "******";
	}
}

class PasswordInputGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		return "<input type=password name=\"{$name}\" value=\"\">";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class TextareaGenerator extends HTMLGenerator {
	function __construct() {

	}
	function getHTML($name, $value) {
		$value = htmlspecialchars($value, ENT_QUOTES);
		return "<textarea rows=6 cols=30 name=\"{$name}\">{$value}</textarea>";
	}
	function getHTMLConfirm($name, $value) {
		return $value;
	}
}

class SelectGenerator extends HTMLGenerator {
	var $ra_key_values;
	function __construct($ra_key_values) {
		if (!is_array($ra_key_values)) {
			$ra_key_values = explode(",", $ra_key_values);
		}
		$this->ra_key_values = $ra_key_values;
	}
	function getHTML($name, $value) {
		$str = "<select name=\"{$name}\"><option value=''>--</option>";
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if ($j == $value) {
				$str .= "<option value=\"{$j}\" selected>$i</option>";
			} else {
				$str .= "<option value=\"{$j}\">$i</option>";
			}
		}
		$str .= "</select>";
		return $str;
	}
	function getHTMLConfirm($name, $value) {
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if ($j == $value) {
				return $i;
			}
		}
	}
}

class YMDGenerator extends HTMLGenerator {
	function __construct() {
	}
	function getHTML($name, $value) {
		if (!is_array($value)) {
			$value = explode(",", $value);
		}
		$str = "<select name=\"{$name}[]\"><option value=''>--</option>";
		for ($i = 1900; $i <= 2050; $i++) {
			if ($i == $value[0]) {
				$str .= "<option value=\"{$i}\" selected>$i</option>";
			} else {
				$str .= "<option value=\"{$i}\">$i</option>";
			}
		}
		$str .= "</select>&nbsp;";

		$str .= "<select name=\"{$name}[]\"><option value=''>--</option>";
		for ($i = 1; $i <= 12; $i++) {
			if ($i == $value[1]) {
				$str .= "<option value=\"{$i}\" selected>$i</option>";
			} else {
				$str .= "<option value=\"{$i}\">$i</option>";
			}
		}
		$str .= "</select>&nbsp;";

		$str .= "<select name=\"{$name}[]\"><option value=''>--</option>";
		for ($i = 1; $i <= 31; $i++) {
			if ($i == $value[2]) {
				$str .= "<option value=\"{$i}\" selected>$i</option>";
			} else {
				$str .= "<option value=\"{$i}\">$i</option>";
			}
		}
		$str .= "</select>";
		return $str;
	}
	function getHTMLConfirm($name, $value) {
		if (!is_array($value)) {
			$value = explode(",", $value);
		}
		return join("/", $value);
	}
}

class CheckboxGenerator extends HTMLGenerator {
	var $ra_key_values;
	function __construct($ra_key_values) {
		if (!is_array($ra_key_values)) {
			$ra_key_values = explode(",", $ra_key_values);
		}
		$this->ra_key_values = $ra_key_values;
	}
	function getHTML($name, $value) {
		if (!is_array($value)) {
			$value = explode(",", $value);
		}
		$str = "";
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if (in_array($j, $value)) {
				$str .= "<input type=checkbox name=\"{$name}[]\" value=\"{$j}\" checked>{$i}&nbsp;";
			} else {
				$str .= "<input type=checkbox name=\"{$name}[]\" value=\"{$j}\">{$i}&nbsp;";
			}
		}
		$str .= "";
		return $str;
	}
	function getHTMLConfirm($name, $value) {
		if (!is_array($value)) {
			$value = explode(",", $value);
		}
		$str = "";
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if (in_array($j, $value)) {
				$str .= "$i,";
			}
		}
		return $str;
	}
}

class RadioboxGenerator extends HTMLGenerator {
	var $ra_key_values;
	function __construct($ra_key_values) {
		if (!is_array($ra_key_values)) {
			$ra_key_values = explode(",", $ra_key_values);
		}
		$this->ra_key_values = $ra_key_values;
	}
	function getHTML($name, $value) {
		$str = "";
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if ($j == $value) {
				$str .= "<input type=radio name=\"{$name}\" value=\"{$j}\" checked>{$i}";
			} else {
				$str .= "<input type=radio name=\"{$name}\" value=\"{$j}\">{$i}";
			}
		}
		$str .= "";
		return $str;
	}
	function getHTMLConfirm($name, $value) {
		$j = 0;
		foreach ($this->ra_key_values as $i) {
			$j++;
			if ($j == $value) {
				return $i;
			}
		}
	}
}
?>