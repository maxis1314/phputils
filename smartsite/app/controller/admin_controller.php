<?php


require_once ("lib/class.twitter.php");

class admin_controller extends application {

	function filter($method) {
		if (!preg_match('/tt/',$method) && !preg_match('/ruby/',$method) && !preg_match('/get/',$method) && !preg_match('/jp/',$method) && $_SERVER[REMOTE_ADDR] != "127.0.0.1") {
			$this->cpa("admin",$this->config["site"]["simplepass"]);
		}
	}
	function tts(){
		$twitter=new Twitter("likelevent","test8899");
		var_dump($twitter->getUserTimeline());
		exit;
	}
	
	function tt(){
		echo $this->htmlheader();
		$username=p("u");
		$password = p("pa");
		$post = p("p");
		$reid = p("re");
		$other = p("o");
		$usertimeline = p("ut");
		$count = p("count");
		
		if(!$count){
			$count=20;
		}
		
		$twitter=new twitter($username,$password);
		if ($this->is_post() && $post){
			//$username = "twitter_user";   // Twitter のアカウント
			//$password = "password";       // パスワード
			//$post = "ほげほげ";            // 投稿する内容

			$twitter->update($post);
		}
		echo "<form method=POST>
		<br><textarea name=p id=p rows=3 cols=40></textarea><br><input type=text name=re id=re><br><input type=submit><hr>UT<input type=checkbox name=ut checked=true><input type=text name=u value='$username'><input type=password name=pa value='$password'><br><input type=text name=o value='$other'><input type=text name=count value=$count></form><br>";
		
		if($usertimeline && $username && $password){
			$result = $twitter->userTimeline;
			//$result=preg_replace('/\n|\r/',"",$result);
			var_dump($result);
			/*preg_match_all("/<id>([^<]+)<\/id> *<text>([^<]+)<\/text>/", $result, $matches);
			foreach ($matches[0] as $val) {
			    //echo "matched: " . $val[0] . "\n";
			    echo "" . $val . "<br>";			    
			}*/
			echo "<hr>";
		}
		
		exit;
		
		//$api_url  = "http://tinyurl.com/api-create.php?url=";
		//$url = "http://example.com/";
		//$result = @file_get_contents( $api_url.$url );
	}

	function testMemCache() {
		$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211);
		$pagedata = $this->fmodel("baodu")->peeks(array ());
		$mem->set("key", $pagedata, 0, 60);
		$mem->set("key2", "1", 0, 60);
		$mem->set("key3", "12", 0, 60);
		$val = $mem->get("key");
		var_dump($val);
		exit;
	}

	function getKey() {
		$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211);
		echo $mem->get("key");
		exit;
	}

	function generate() {
		$table_name = "gu";
		$ctl = "gu";

		$tmplvar = array ();
		$tmplvar["ctl"] = $ctl;
		$tmplvar["table_name"] = $table_name;
		$db = $this->fmodel($table_name);
		$tmplvar["table"] = $db->detail();
		$view = View :: getObj();
		$files = array ();

		$dir = dir(ROOT . "data/programetpl/crub/");
		while (($file = $dir->read()) !== false) {
			if (!preg_match("/^\./", $file) && preg_match("/\.tpl$/", $file)) {
				$str = $view->fetch_html($tmplvar, ROOT . "data/programetpl/crub/$file");
				echo "$file<br><textarea cols=300 rows=20>" . e($str) . "</textarea><br>";
				if (f("go")) {
					mkdir(ROOT . "data/programetpl/log/$ctl", 0700);
					$handle = fopen(ROOT . "data/programetpl/log/$ctl/$file", 'w');
					fwrite($handle, $str);
					fclose($handle);
				}
			}
		}
		$dir->close();

		echo "<a href=/admin/generate/?go=1>DO</a>";
		exit;

	}

	function upload() {
		if ($this->is_post() && !empty ($_FILES["userfile"])) {
			$uploaddir = ROOT . "../uploadfile/";

			//Copy the file to some permanent location
			$savefile = $_FILES["userfile"]["name"];

			if (copy($_FILES["userfile"]["tmp_name"], $uploaddir . $savefile)) {
				$this->sv("result", 1);
				$this->sv("download", $savefile);
			} else {
				$this->sv("result", 2);
			}
		}

		$filelist = search_dir(ROOT . "../uploadfile/");
		foreach ($filelist as & $i) {
			$i = mb_convert_encoding($i, "UTF-8", 'SJIS');
		}
		$this->sv('list', $filelist);
	}

	function download($params) {
		$fileget = f('d');
		if ($fileget) {
			View :: download($fileget, "../uploadfile/$fileget");
		}
		exit;
	}

	function print_screen() {
		$im = imagegrabscreen();
		imagepng($im, ROOT . "myscreenshot.png");
		$this->jump("/self/myscreenshot.png");
	}

	function print_ie() {
		if ($this->is_post()) {
			foreach (array (
					'url',
					'url2',
					'url3'
				) as $i) {
				if (f($i)) {
					$this->get_url_pic2(f($i), "iesnap-$i.png", f('scroll$i'));
					$this->sv("pic$i", "/self/iesnap-$i.png");
				}
			}
		}
	}

	function urlinfo($params) {

		if ($this->is_post()) {
			$url = p('url');
			$urlinfo = parse_url($url);
			$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
			while ($fc = fread($fp, 8192)) {
				$str .= $fc;
			}
			fclose($fp);

			preg_match_all('/<img[^>]*src=([^>]*)>/i', $str, $matches);
			$allpic = $matches[1];
			$jpg = array ();
			$gif = array ();
			$png = array ();
			$bmp = array ();
			$other = array ();

			foreach ($allpic as & $i) {
				$i = preg_replace('/ .*/i', '', $i);
				$i = preg_replace('/"/i', '', $i);
				if (!preg_match('/^http/i', $i)) {
					if (preg_match('/^\//i', $i)) {
						$i = $urlinfo['scheme'] . '://' . $urlinfo['host'] . '/' . $i;
					} else {
						$i = $urlinfo['scheme'] . '://' . $urlinfo['host'] . '/' . $i;
					}
				}

				if (preg_match('/\.jpg$/i', $i) || preg_match('/\.jpeg$/i', $i)) {
					$jpg[] = $i;
					if (f('downloadjpg')) {
						$this->downloadfile($i);
					}
				}
				elseif (preg_match('/\.gif$/i', $i)) {
					if (f('downloadgif')) {
						$this->downloadfile($i);
					}
					$gif[] = $i;
				}
				elseif (preg_match('/\.png$/i', $i)) {
					if (f('downloadpng')) {
						$this->downloadfile($i);
					}
					$png[] = $i;
				}
				elseif (preg_match('/\.bmp$/i', $i)) {
					if (f('downloadbmp')) {
						$this->downloadfile($i);
					}
					$bmp[] = $i;
				} else {
					if (f('downloadother')) {
						$this->downloadfile($i);
					}
					$other[] = $i;
				}

			}

			$this->sv('jpg', $jpg);
			$this->sv('gif', $gif);
			$this->sv('bmp', $bmp);
			$this->sv('png', $png);
			$this->sv('other', $other);
		}

	}

	function rubyajax($params) {
		$re = $this->fmodel("blog")->peek(array (
			'id' => $params[0]
		));
		$article = $re['content'];
		$tempstr=$this->ruby_japanese($article, $params[1]);			
		echo preg_replace('/\n/','<br>',$tempstr);
		exit;
	}
	function rubyjp($params) {
		if ($params[0] || $this->is_post()) {
			if ($params[0]) {
				$re = $this->fmodel("blog")->peek(array (
					'id' => $params[0]
				));
			}
			if ($re) {
				$article = $re['content'];
				$last_id = $re['id'];
				$_POST['ok'] = $article;
				$_POST['url'] = $re['url'];
			} else {
				$article = p('ok');
			}
			$lang = f('lang') ? f('lang') : $params[1];
			if (!$lang) {
				$lang = 'jp';
			}
			$_POST['lang'] = $lang;
			if (p('kannji') && p('yomi') && strlen(p('kannji')) > 3) {
				$handle = fopen(ROOT . "data/lang/lang-$lang.txt", 'a');
				$kannji = str_replace(' ', '', p('kannji'));
				$kannji = str_replace(' ', '', $kannji);
				$kannji = str_replace('　', '', $kannji);
				fwrite($handle, ucfirst(str_replace('�]', '', p('yomi'))) . "," . $kannji . "\n");
			}
			$tempstr=$this->ruby_japanese($article, $lang);
			$this->sv("result", preg_replace('/\n/','<br>',$tempstr));
			if (!$re && $article) {
				$re = $this->fmodel("blog")->save(array (
					'content' => $article,
					'url' => p('url'),
					'title' => $lang,
					'ip'=>getIP()
				));
				$last_id = $this->fmodel("blog")->get_last_id();
			}
			$this->sv('last_id', $last_id);
			if (f("simple")) {
				$this->sf("admin/rubyjpsimple");
			}
		}
	}
	private function ruby_japanese($afterbody, $file = "jp") {
		$fileold=$file;
		$file=preg_replace('/\-.*$/','',$file);
		$lines = file(ROOT . "data/lang/lang-$file.txt");
		$jparray = array ();
		$sort = array ();
		foreach ($lines as $i) {
			$i = chop($i);
			$sort[$i] = strlen($i);
		}

		asort($sort);

		foreach ($sort as $key => $val) {
			if(preg_match('/-reverse/',$fileold)){
				$jparray[] = array_reverse(explode(',', $key));
			}else{
				$jparray[] = explode(',', $key);
			}
		}

		$has_replcaed = array ('brown'=>1,'Brown'=>1);
		foreach ($jparray as $i) {
			if ($i[0] && $i[1]) {
				if ($file == "en" || $file == "fr" || $file == "enjp") {
					if (!$has_replcaed[$i[1]]) {
						//if(strlen($i[1])>=5){
						//$afterbody=preg_replace('/'.$i[1].'/i',"<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$i[1]\");return false;'>$i[1]</a></rb><rp>(</rp><rt><font color=red>$i[0]</font></rt><rp>)</rp></ruby>",$afterbody);
						$afterbody = preg_replace('/\b' . $i[1] . '\b/i', "<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$i[1]\");return false;'>$i[1]</a></rb><rp>(</rp><rt><font color=brown>$i[0]</font></rt><rp>)</rp></ruby>", $afterbody);
						//}
						$has_replcaed[$i[1]] = 1;
					}

					if (false && strlen($i[1]) > 4) {
						//1
						if (!preg_match('/y$/i', $i[1])) {
							$new = $i[1] . 's'; //fushu
						} else {
							$new = preg_replace('/y$/i', 'ies', $i[1]); //fushu	
						}
						if (!$has_replcaed[$new]) {
							$afterbody = preg_replace('/\b' . $new . '\b/i', "<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$new\");return false;'>$new</a></rb><rp>(</rp><rt><font color=red>$i[0]</font>(s)</rt><rp>)</rp></ruby>", $afterbody);
							$has_replcaed[$new] = 1;
						}

						//2
						if (preg_match('/e$/i', $i[1])) {
							$new = $i[1] . 'd'; //guoqushi
						}
						elseif (preg_match('/y$/i', $i[1])) {
							$new = preg_replace('/y$/i', 'ied', $i[1]);
						} else {
							$new = $i[1] . 'ed'; //guoqushi	
						}
						if (!$has_replcaed[$new]) {
							$afterbody = preg_replace('/\b' . $new . '\b/i', "<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$new\");return false;'>$new</a></rb><rp>(</rp><rt><font color=red>$i[0]</font>(ed)</rt><rp>)</rp></ruby>", $afterbody);
							$has_replcaed[$new] = 1;
						}

						/*//3
						if(preg_match('/e$/i',$i[1])){
							$new=preg_replace('/e$/i','ing',$i[1]);	   					
						}else{
							$new=$i[1].'ing';//ing	
						}
						if(!$has_replcaed[$new]){
							$afterbody=preg_replace('/\b'.$new.'\b/i',"<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$new\");return false;'>$new</a></rb><rp>(</rp><rt><font color=red>$i[0]</font>(ing)</rt><rp>)</rp></ruby>",$afterbody);
							$has_replcaed[$new]=1;
						}
						
						//4
						if(preg_match('/y$/i',$i[1])){
							$new=preg_replace('/y$/i','ily',$i[1]);	   					
						}else{
							$new=$i[1].'ly';//fuchi	
						}
						if(!$has_replcaed[$new]){
							$afterbody=preg_replace('/\b'.$new.'\b/i',"<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$new\");return false;'>$new</a></rb><rp>(</rp><rt><font color=red>$i[0]</font>(ly)</rt><rp>)</rp></ruby>",$afterbody);
							$has_replcaed[$new]=1;
						}
						
						
						if(preg_match('/e$/i',$i[1])){
							$new=preg_replace('/e$/i','',$i[1]).'ing';//ing
						}else{
							$new=$i[1].'ing';//ing	
						}
						if(!$has_replcaed[$new]){
							$afterbody=preg_replace('/\b'.$new.'\b/i',"<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$new\");return false;'>$new</a></rb><rp>(</rp><rt><font color=red>$i[0]</font></rt><rp>)</rp></ruby>",$afterbody);
							$has_replcaed[$new]=1;
						}*/

					}

				} else {
					if (f('gongsi')) {
						$bookmark = "";
					} else {
						$bookmark = "";//"<a href=# onclick='savejieguo(\"$i[1]\");return false;'><img width=15 heigth=15 src=/image/top-bookmark.jpg></a>";
					}
					if (!$has_replcaed[$i[1]]) {
						$afterbody = str_replace($i[1], "<ruby><rb><a href='#' onclick='javascrit:displayyahoo(\"$i[1]\");return false;'><b>$i[1]</b></a></rb><rp>(</rp><rt>$bookmark<font color=brown><a target=_blank href='/admin/jpallfunc?word=$i[1]'><font color=brown>$i[0]</font></a></font></rt><rp>)</rp></ruby>", $afterbody);
						$has_replcaed[$i[1]] = 1;
					}
				}
				//http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|qq
			}
		}
		return $afterbody;
	}

	function bookmark() {
		$db = $this->fmodel("jptest");
		$one["content"] = f("a");
		$one["user"] = f("b");
		$db->save($one);
		$this->to_path("/filecms/jptest");
	}

	function clearruby() {
		$lines = file(ROOT . "../lang-en.txt");
		$jparray = array ();
		foreach ($lines as $i) {
			$i = chop($i);
			$jparray[] = explode(',', $i);
		}
		$hash = array ();
		foreach ($jparray as $i) {
			if (!$hash[$i[1]] && $i[0] && $i[1] && !$i[2]) {
				$handle = fopen(ROOT . "../lang-en-2.txt", 'a');
				$hash[$i[1]] = 1;
				fwrite($handle, $i[0] . "," . $i[1] . "\n");
			}
		}
		exit;
	}

	function getjapanese($params) {
		if ($params[1] == "en") {
			$faying = $this->getchinese2($params);
		} else if ($params[1] == "fr") {
			$faying = $this->getfrchinese($params);
		} else {
			$url = 'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=' . urlencode($params[0]) . '&stype=1&dtype=0';
			$str = $this->url2str($url);
			$faying = $this->exactYahooDuyin($str, $params[1]);
			if (!$faying) {
				$faying = $this->getWeblio($params[0]);
			}
		}
		echo $faying;
		exit;
	}
	function getjapanese2($params) {
		echo $params[0] . $this->getXiaodi($params[0], "", $params[1]);
		exit;
	}

	private function exactYahooDuyin($str, $lan) {
		$str = preg_replace('/\r|\n/', '', $str);
		$str = str_replace('<br>', '', $str);
		$str = str_replace('</br>', '', $str);
		//$str=str_replace('<small>','',$str);
		//$str=str_replace('</small>','',$str);
		preg_match_all('/<td><b>(.*)<\/b><\/td>/', $str, $matches);

		$faying = $matches[1][0];
		$faying = str_replace("‐", "", $faying);
		//$faying=preg_replace("/\(.*\)/","",$faying);
		$faying = str_replace("・", "", $faying);
		$faying = str_replace("&nbsp;", "", $faying);
		$faying = str_replace(" ", "", $faying);
		$faying = preg_replace("/<sub>.*<\/sub>/i", "", $faying);
		$faying = preg_replace("/<small>.*<\/small>/i", "", $faying);

		if ($lan == "en") {
			$faying = preg_replace('/〔.*/', "", $faying);
			$faying = preg_replace('/【.*/', "", $faying);
			$faying = preg_replace('/［.*/', "", $faying);
		} else {
			if (!preg_match('/【([a-zA-Z0-9 ]+)】/i', $faying)) {
				$faying = preg_replace('/〔.*/', "", $faying);
				$faying = preg_replace('/【.*/', "", $faying);
				$faying = preg_replace('/［.*/', "", $faying);
			} else {
				$faying = preg_replace('/】.*/', "", $faying);
				$faying = preg_replace('/.*【/', "", $faying);
			}
		}

		return $faying;
	}

	function getchinese($params) {
		$url = 'http://fanyi.cn.yahoo.com/translate_txt?ei=UTF-8&fr=&lp=en_zh&trtext=' . $params[0] . '';
		$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
		while ($fc = fread($fp, 8192)) {
			$str .= $fc;
		}
		fclose($fp);
		$str = preg_replace('/\r|\n/', '', $str);
		
		preg_match_all('/<div id="pd" class="pd">([^<]*)<\/div>/', $str, $matches);
		
		$faying = $matches[1][0];
		$faying = preg_replace("/\([^)]*\)/", "", $faying);
		$faying = preg_replace("/\[[^]]*\]/", "", $faying);
		$faying = preg_replace("/【.*】/", "", $faying);
		$faying = preg_replace("/;.*/", "", $faying);
		$faying = preg_replace("/,.*/", "", $faying);
		return $faying;
		//exit;
	}

	function getchinese2($params) {
		$url = 'http://dict.cn/en/search/?q=' . $params[0] . '';		
		$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
		while ($fc = fread($fp, 8192)) {
			$str .= $fc;
		}
		fclose($fp);
		$str = preg_replace('/\r|\n/', '', $str);
		
		preg_match_all('/<td align="left"><big>([^<]*)</', $str, $matches);
		
		
		
		$faying = $matches[1][0];
		$faying = preg_replace("/.* +/", "", $faying);		
		$faying = preg_replace("/\([^)]*\)/", "", $faying);
		$faying = preg_replace("/\[[^]]*\]/", "", $faying);
		$faying = preg_replace("/,.*/", "", $faying);
			
		$faying = mb_convert_encoding($faying,'utf-8','gb2312');
		if($faying == 'found!'){
			$faying="";
		}
		//echo $faying;exit;
		return $faying;
	}
	
	function getfrchinese($params){
		$url = 'http://fr.ohdict.com/plugins/GTrans/Query.php?c=4&q=' . $params[0] . '';		
		$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
		while ($fc = fread($fp, 8192)) {
			$str .= $fc;
		}
		fclose($fp);
		//$str = preg_replace('/\r|\n/', '', $str);
		
		echo $str;exit;
		return $str;
	}


	function rubyinline() {
	}
	function getjapanese3($params) {
		$faying = $this->getYahoo($params[0]);
		if (!$faying) {
			$faying = $this->getWeblio($params[0]);
		}
		echo $faying;
		exit;
	}
	function getjapanese23($params) {
		echo $params[0] . $this->getXiaodi($params[0], "", $params[1]), "<hr>";
		echo $this->getYahoo($params[0]);
		exit;
	}
	function getjapanese232($params) {
		echo $params[0] . $this->getXiaodi($params[0], "", $params[1], false), "<hr>";
		echo $this->getYahoo($params[0]);
		exit;
	}
	function getjapanese234($params, $quick) {
		$params[0] = str_replace("　", " ", $params[0]);
		if (preg_match('/ (.*)$/', $params[0], $matches)) {
			$other = $matches[1];
			$params[0] = preg_replace('/ .*$/', '', $params[0]);
		}
		if (!$params[0] || $params[0] == "help") {
			echo "<font color=brown size=3><a href='' onclick='setrefresh2(\"あ　い\");return false;'>あ　い</a>(含あ不含い)</font><br>\n";
			echo "<font color=brown size=3><a href='' onclick='setrefresh2(\"あ　-y い\");return false;'>あ　-y い</a>(含あ含い)</font><br>\n";
			echo "<font color=brown size=3><a href='' onclick='setrefresh2(\"あ　い　-y う -y え -n　お\");return false;'>あ　い　-y う -y え -n　お</a>(含あうえ不含いお)</font><br>\n";
			exit;
		}
		echo $params[0] . $this->getXiaodi($params[0], "", $params[1]), "<hr>";

		if ($other) {

			if (!preg_match('/^ +\-/i', $other)) {
				$other = "-n " . $other;
			}
			$other = getopt_instr($other);

		} else {
			$other = array ();
		}

		$othersimilar = $this->getWordWith($params[0], $other);

		foreach ($othersimilar as $i) {
			echo "<font color=brown size=3><a href='/admin/jpallfunc?word=$i[1]' onclick='setrefresh2(\"$i[1]\");return false;'>" . str_replace("$params[0]", "<b>$params[0]</b>", $i[1]) . "</a>(" . str_replace("$params[0]", "<b>$params[0]</b>", $i[0]) . ")</font><br>\n";
		}

		if (count($othersimilar) == 0) {
			$url = 'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=' . urlencode($params[0]) . '&stype=1&dtype=0';
			$str = $this->url2str($url);
			$faying = $this->exactYahooDuyin($str, $params[1]);
			echo "<input type=text id=yomi2 size=6 value=$faying><input type=button onclick='save(\"$params[0]\",\"$faying\");this.disabled=true;' value='save:$params[0]'>";
		}
		echo "<hr>";
		$yahootext = $this->getYahoo($params[0], $str);
		echo $yahootext;
		echo "<hr>";
		$pagedata = $this->fmodel("dicxiaodi")->peeks_like(array (
			"setumeyi" => $params[0]
		));
		foreach ($pagedata as $i) {
			$i["setumeyi"] = str_replace($params[0], "<font color=blue>$params[0]</font>", $i["setumeyi"]);
			$i["setumeyi"] = str_replace('<font color=red><b>|</b></font>', '@', $i["setumeyi"]);
			$array = explode("@", $i["setumeyi"]);
			foreach ($array as $j) {
				if (strpos($j, $params[0]) > 0) {
					echo "<br>", $j;
				}
			}
		}
		echo "<hr>";
		$pagedata = $this->fmodel("sentence")->peeks_like(array (
			"jp" => $params[0],
			"cn" => $params[0]
		));
		foreach ($pagedata as $i) {
			$i["jp"] = str_replace($params[0], "<font color=blue>$params[0]</font>", $i["jp"]);
			$i["cn"] = str_replace($params[0], "<font color=blue>$params[0]</font>", $i["cn"]);
			echo "<font color=brown><b>$i[jp]</b></font> $i[cn]<br>";
		}

		/*
		echo "<hr>";
		$pagedata=$this->fmodel("baoduriyu")->peeks_like(array("huida"=>$params[0],'title2'=>$params[0]));
		$yijing=array();
		foreach($pagedata as $i){
			if($yijing[$i[url]]){
				continue;
			}
			$i["huida"]=str_replace($params[0],"<font color=blue>$params[0]</font>",$i["huida"]);
			$i["title"]=str_replace($params[0],"<font color=blue>$params[0]</font>",$i["title"]);
			$i["title2"]=str_replace($params[0],"<font color=blue>$params[0]</font>",$i["title2"]);
			$i["title3"]=str_replace($params[0],"<font color=blue>$params[0]</font>",$i["title3"]);			
			echo "<font color=brown><b>$i[title]/$i[title2]/$i[title3]</b></font><a target=_blank href=/self/error/rd?url=$i[url]>$i[url]</a><br> $i[huida]<br><br>";
			$yijing[$i[url]]=1;			
		}
		*/

		$his = $this->fmodel("accessword")->peeks();
		echo "<hr>";
		$display = array ();
		foreach ($his as $i) {
			if (in_array($i[word], $display)) {
				continue;
			}
			echo "<a href='/admin/jpallfunc?lang=&word=$i[word]'>$i[word]</a>&nbsp;&nbsp;";
			$display[] = $i[word];
			if (count($display) > 100) {
				break;
			}
		}
		exit;
	}
	private function getYahoo($word, $source = null) {
		$word = str_replace(" ", "", $word);
		$word = str_replace("　", "", $word);
		$url = 'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=' . urlencode($word) . '&stype=1&dtype=0';
		$his = $this->fmodel("dicyahoo")->peek(array (
			"word" => $word,
			"type" => "yahoo"
		));
		if ($his) {
			return "<a target=_blank href='$url'>[YAHOO]</a>$yahoo" . $his["setumeyi"];
		}
		if (!$word || strlen($word) <= 3) {
			return "";
		}

		if ($source) {
			$str = $source;
		} else {
			$str = $this->url2str($url);
		}

		$faying = $this->exactYahooDuyin($str, $params[1]);

		$str = preg_replace('/\r|\n/', '', $str);
		$str = str_replace('<br>', '', $str);
		$str = str_replace('</br>', '', $str);
		$str = str_replace('<br/>', '', $str);
		preg_match_all('/<\!\-\- <td class=s130> \-\-><td>(.*)<\/td><\/tr><\/table><\!\-\-\/詳細\-\->/', $str, $matches);
		$yahoo = $matches[1][0];
		$yahoo = preg_replace('/<[^>]+>/', '', $yahoo);

		if ($yahoo) {
			$this->fmodel("dicyahoo")->save(array (
				"type" => "yahoo",
				"word" => $word,
				"setumeyi" => "<font color=brown><b>{$faying}</b></font>/$yahoo"
			));
		}
		return "<a target=_blank href='$url'>[YAHOO]</a><font color=brown><b>{$faying}</b></font>/$yahoo";
	}

	function gethatuonn($params) {
		echo $this->getWeblio($params[0]);
		exit;
	}
	private function getWeblio($word, $source = null) {
		return "";
		$word = str_replace(" ", "", $word);
		$word = str_replace("　", "", $word);
		$url = 'http://ejje.weblio.jp/content/' . urlencode($word);

		if (!$word) {
			return "";
		}

		if ($source) {
			$str = $source;
		} else {
			$str = $this->url2str($url);
		}

		$str = preg_replace('/\r|\n/', '', $str);
		$str = str_replace('<br>', '', $str);
		$str = str_replace('</br>', '', $str);
		$str = str_replace('<br/>', '', $str);
		$str = preg_replace('/<SUP>[^<]*<\/SUP>/i', '', $str);
		preg_match_all('/<h2 class=midashigo[^>]*>([^<]*)<\/h2>/', $str, $matches);
		$weblio = $matches[1][0];
		$weblio = preg_replace('/ .*/', '', $weblio);

		return $weblio;
	}

	function testxiaodi() {
		echo $this->getXiaodi("安値");
		exit;
	}

	private function getXiaodi($word, $source = null, $lang = "jp") {
		$word = str_replace(" ", "", $word);
		$word = str_replace("　", "", $word);

		if ($lang == "en") {
			$url = "http://dict.hjenglish.com/w/" . urlencode($word);
		} else {
			$url = "http://dict.hjenglish.com/jp/w/" . urlencode($word) . "&type=jc";
		}
		if ($lang == "en") {
			$his = $this->fmodel("dicen")->peek(array (
				"word" => $word,
				"type" => "xiaodi"
			));
		} else {
			$his = $this->fmodel("dicxiaodi")->peek(array (
				"word" => $word,
				"type" => "xiaodi"
			));
		}
		if ($his) {
			//$this->fmodel("accessword")->save(array("word"=>$word));
			return "<a target=_blank href='$url'>[XD]</a>$xiaodi" . $his["setumeyi"];
		}

		if (!$word || strlen($word) <= 3) {
			return "";
		}

		if ($source) {
			$str = $source;
		} else {
			$str = $this->url2str2($url);
		}
		$duyingxiaodi = $this->getXiaodi2(null, $str);

		$str = preg_replace('/\r|\n/', '', $str);
		$str = str_replace('<br>', '', $str);
		$str = str_replace('</br>', '', $str);
		$str = str_replace('<br/>', '', $str);
		if ($lang == "en") {
			preg_match_all('/<div id="panel_comment" class="word_text" xmlns:msxsl="urn:schemas-microsoft-com:xslt" xmlns:myscript="urn:myns">(.+)<div>/', $str, $matches);
		} else {
			preg_match_all('/<div id="com_panel_0" style="display:block;" class="jp_explain">(.+)<div>/', $str, $matches);
		}
		$xiaodi = $matches[1][0];
		if ($lang == "en") {
			$xiaodi = preg_replace('/我要补充.*$/', '', $xiaodi);
			$xiaodi = preg_replace('/参考网页.*$/', '', $xiaodi);
			$xiaodi = preg_replace('/<ol[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('</ol>', '', $xiaodi);
			$xiaodi = preg_replace('/<ul[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('</ul>', '', $xiaodi);
			$xiaodi = preg_replace('/<span[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('</span>', '', $xiaodi);
			$xiaodi = preg_replace('/<li[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('</li>', '', $xiaodi);
			$xiaodi = preg_replace('/<div[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('</div>', '', $xiaodi);
			$xiaodi = preg_replace('/<img[^>]*>/i', '', $xiaodi);
			$xiaodi = str_replace('<br />', '', $xiaodi);
			$xiaodi = preg_replace('/<h3>/i', '', $xiaodi);
			$xiaodi = preg_replace('/<\/h3>/i', '', $xiaodi);
			$xiaodi = str_replace('点击查看……', '', $xiaodi);
			$xiaodi = str_replace('参考例句', '', $xiaodi);
			$xiaodi = str_replace('查看全文', '', $xiaodi);
			$xiaodi = "<a target=_blank href=http://www.merriam-webster.com/dictionary/$word>[韦伯]</a>$xiaodi";
			//echo e($xiaodi);exit;
		} else {
			$xiaodi = preg_replace('/<div>.*$/', '', $xiaodi);
		}
		$xiaodi = preg_replace('/<span style=\'color:#AAAAAA;font\-family:Courier New;\'>([^<]*)<\/span>/', '', $xiaodi);
		$xiaodi = str_replace("<span style='color:#AAAAAA;font-family:Courier New;'>　 <img src='http://dict.hjenglish.com/images/icon_star.gif' align='absmiddle' /></span>", "<font color=red><b>|</b></font><font color=brown><b>", $xiaodi);
		$xiaodi = str_replace('／', '</b></font>／', $xiaodi);
		//$xiaodi=preg_replace('/\|\|([^／]*)／/i','<font color=red><b>|</b></font><font color=brown><b>\1</b></font>／',$xiaodi);
		//<font color=red><b>|</b></font>
		$xiaodi = preg_replace('/^ +/', '', $xiaodi);
		$xiaodi = str_replace('[例]', '<br>[example]', $xiaodi);

		if ($xiaodi) {
			$xiaodi = "[$duyingxiaodi]$xiaodi";
			if ($lang == "en") {
				$this->fmodel("dicen")->save(array (
					"type" => "xiaodi",
					"word" => $word,
					"setumeyi" => $xiaodi
				));
			} else {
				$this->fmodel("dicxiaodi")->save(array (
					"type" => "xiaodi",
					"word" => $word,
					"setumeyi" => $xiaodi
				));
			}
			//$this->fmodel("accessword")->save(array("word"=>$word));
		}

		return "<a target=_blank href='$url'>[XD]</a>$xiaodi";
	}

	function test() {
		echo $this->url2strP("http://google.com/");
		exit;
	}
	function test2() {
		$str = $this->url2str('http://www.jptranslate.com/html/27/n-46427.html');
		$str = $this->trackinfo($str);
		preg_match('/<P><STRONG><FONT color=#ff0033>(.*)<\/P>/', $str, $matches);
		echo $matches[1];
		exit;
	}

	function xml() {

		$simple = $this->url2str("http://wx.mim1314.com/crud/index.xml");
		$p = xml_parser_create();
		xml_parse_into_struct($p, $simple, $vals, $index);
		xml_parser_free($p);
		echo "Index array\n";
		print_r($index);
		echo "\nVals array\n";
		print_r($vals);
		exit;
	}

	function webproxy() {
		if (f('url')) {
			$str = $this->url2str2(f("url"));
			if (f("pdf")) {
				$this->html2fpdf($str);
			}
			$str = str_replace('<br>', '', $str);
			$str = preg_replace('/\r/', '', $str);
			$str = preg_replace('/\n/', '<br>', $str);
			$str = preg_replace('/\t/', '', $str);
			if (!preg_match('/bbs/i', f('url'))) {
				$str = str_replace('<br>', '', $str);
			}

			//$str = str_replace('<br>', '', $str);

			$vowels = array (
				"<span>",
				"</span>"
			);
			$str = str_replace($vowels, "", $str);

			//preg_match('/<META[^>]*charset[^>]*>/i',$str,$matches);
			//echo "<html>\n<head>\n$matches[0]\n</head>\n<body>\n";
			//$str=strip_tags($str,"<a>");
			if (f('pre')) {
				$str = preg_replace('/^.*' . f('pre') . '/', '', $str);
			}
			if (f('after')) {
				$str = preg_replace('/' . f('after') . '.*$/', '', $str);
			}
			echo "<br><a href='", f('url'), "'>From</a><br>";
			echo $this->sennyo($str, f("who"));
			echo "<br><a href='", f('url'), "'>From</a><br>";
			exit;
		}
	}

	private function getXiaodi2($word, $source = null, $lang = "jp") {
		$str = $this->exURL($url, "查询结果", "】", $source);
		$str = preg_replace('/.*【/i', '', $str);
		return $str;
	}

	private function sennyo($str, $who) {
		if ($who == "chren") {
			//echo $str;exit;
			$return = "";
			preg_match_all('/<a[^>]*href="\/([0-9]+)\.html"[^>]*>([^<]*)<\/a>/', $str, $matches);
			//var_dump($matches);exit;
			for ($i = 0; $i < count($matches[1]); $i++) {
				$return .= "<a target=_blank href='/admin/webproxy?url=http://club.chinaren.com/" . $matches[1][$i] . ".html'>" . $matches[2][$i] . "</a><br>";
			}
			echo '<meta http-equiv="content-type" content="text/html; charset=gbk">';

			return $return;
		}
		$str = preg_replace('/<img[^>]*>/i', '', $str);
		$str = preg_replace('/<ul[^>]*>/i', '', $str);
		$str = preg_replace('/<\/ul[^>]*>/i', '', $str);
		$str = preg_replace('/<li[^>]*>/i', '', $str);
		$str = preg_replace('/<\/li[^>]*>/i', '', $str);

		$str = preg_replace('/<a[^>]*>[^<]*<\/a>/i', '', $str);

		$str = preg_replace('/<iframe[^>]*>/i', '', $str);
		$str = preg_replace('/<EMBED[^>]*>/i', '', $str);
		$str = preg_replace('/<[^<]*textarea[^>]*>/i', '', $str);
		$str = preg_replace('/<object[^>]*>/i', '', $str);
		$str = preg_replace('/<script[^>]*>[^<]*<\/script>/i', '', $str);

		return $str;
	}

	function do1() {
		$lines = file(ROOT . "../lang-jp.txt");
		$jparray = array ();
		$sort = array ();
		foreach ($lines as $i) {
			$i = chop($i);
			$sort[$i] = strlen($i);
		}

		asort($sort);

		foreach ($sort as $key => $val) {
			$line = explode(',', $key);
			$jparray[] = $line[1];
		}

		$already = $this->fmodel("dicxiaodi")->peek_col(array (), "word");
		$begin = "足利";
		$ok = false;
		foreach ($jparray as $i) {
			if ($i == $begin) {
				$ok = true;
			}
			if (!in_array($i, $already) && $ok) {
				echo "$i<img src='/admin/getjapanese232/" . urlencode($i) . "/jp/'><br>";
			}
		}
		exit;
	}

	function jptest() {
		if (f('type') == "error") {
			$line = f("word");
			$handle = fopen(ROOT . "../lang-error.txt", 'a');
			fwrite($handle, $line . "\n");
			fclose($handle);
			exit;
		}
		if (f("type") == "2th") {
			$lines = file(ROOT . "../lang-error.txt");
		} else {
			$lines = file(ROOT . "../lang-jp.txt");
		}

		$jparray = array ();
		$sort = array ();
		$alreadyin = array ();
		foreach ($lines as $i) {
			$i = chop($i);
			if ($alreadyin[$i] == 1) {
				continue;
			}
			$alreadyin[$i] = 1;
			$sort[$i] = strlen($i);
		}

		asort($sort);

		foreach ($sort as $key => $val) {
			$line = explode(',', $key);
			//if(!preg_match('/[a-zA-Z]+/i',$line[1])){				
			$jparray[] = $line;
			//}			
		}

		$return = array ();
		$has = array ();
		for ($i = 0; $i < 10; $i++) {
			$ok = rand() % count($jparray);
			if ($has[$ok] == 1) {
				continue;
			}
			$has[$ok] = 1;
			$return[] = $jparray[$ok];
		}

		foreach ($return as & $i) {
			$his = $this->fmodel("dicxiaodi")->peek(array (
				"word" => $i[1],
				"type" => "xiaodi"
			));
			$i[2] = $his["setumeyi"];
		}

		$this->sv("list", $return);
		if (f("f")) {
			$this->sf('admin/jptest2');
		}

	}

	private function getWordWith($word, $notword) {
		$lines = file(ROOT . "../lang-jp.txt");
		$jparray = array ();
		$sort = array ();
		foreach ($lines as $i) {
			if (strstr($i, $word)) {
				$countin = true;
				if ($notword['n']) {
					foreach ($notword['n'] as $j) {
						if (strstr($i, $j)) {
							$countin = false;
							break;
						}
					}
				}
				if ($countin) {
					if ($notword['y']) {
						foreach ($notword['y'] as $k) {
							if (!strstr($i, $k)) {
								$countin = false;
								break;
							}
						}
					}
				}
				if ($countin) {
					$i = chop($i);
					$sort[$i] = strlen($i);
				}
			}
		}

		asort($sort);

		foreach ($sort as $key => $val) {
			$line = explode(',', $key);
			//if(!preg_match('/[a-zA-Z]+/i',$line[1])){				
			$jparray[] = $line;
			//}			
		}
		return $jparray;
	}

	function jpallfunc($params) {
		$word = f('word');
		$lang = f('lang');
		if ($word) {
			echo '<html><head><meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />' .
			'<script src="/public/js/jquery.js" type="text/javascript"></script></head><body>';
			echo "<form><input type=hidden name=lang value=$lang><input id='word' type=text name=word value=\"$word\"><input type=submit>&nbsp;&nbsp;&nbsp;<input type=text id=jp size=30><input type=text id=cn size=30><input id=jpcn type=button onclick='save2();' value='save sentence'></form>";

			echo '
												
														<script language="javascript">
												function save(a,b){
													if(!a){
														return;
													}
												   var param={		
														kannji: a,
														yomi: $("#yomi2").val(),
														lang: "jp"
												    };
												
													$.post("/admin/rubyjp/",param,
													  function(data){
													    
													});
												}
												var savetimes=1;
												function save2(){
												   if(!$("#jp").val() || !$("#cn").val()){
														return;
													}
												   var param={
														"data[jp]": $("#jp").val(),
														"data[cn]": $("#cn").val()
												    };
												savetimes++;
													$.post("/filecms/sentence/add",param,
													  function(data){
													    $("#jp").val("");
													    $("#cn").val("");
													    $("#jpcn").val("save sentence "+savetimes);
													});
												}
												
												$(document).ready(
													function()
													{$("#word").focus();
													}
												);
												
												</script>
															';
			$this->fmodel("accessword")->save(array (
				"word" => $word
			));
			$this->getjapanese234(array (
				$word,
				$lang
			));
			exit;
		}

	}

	function passw() {
		$usernamelist = array (
			"lank",
			"lapidary",
			"lapse",
			"larch",
			"lard",
			"largesse",
			"lark",
			"larva",
			"laryngitis",
			"larynx",
			"lascivious",
			"lash",
			"lassitude",
			"lasso",
			"latent",
			"latency",
			"lathe",
			"latitude",
			"lattice",
			"laud",
			"laudable",
			"laudatory",
			"laurel",
			"laurels",
			"lava",
			"lave",
			"lax",
			"laxity",
			"laxative",
			"layman",
			"leach",
			"leaflet",
			"leakage",
			"lean",
			"lease",
			"leaven",
			"lecherous",
			"lechery",
			"ledger",
			"leer",
			"leeward",
			"legacy",
			"legend",
			"legerdemain",
			"legible",
			"legion",
			"legislate",
			"legislature",
			"legitimate",
			"lengthy",
			"lenient",
			"lenience",
			"leonine",
			"leprosy",
			"lesion",
			"lessee",
			"lethal",
			"lethargy",
			"leucocyte",
			"levee",
			"leviathan",
			"levitate",
			"levity",
			"levy",
			"lewd",
			"lexical",
			"lexicographer",
			"lexicon",
			"liability",
			"liable",
			"liaison",
			"libation",
			"libel",
			"libellous",
			"liberality",
			"liberated",
			"libertine",
			"libido",
			"libidinous",
			"libretto",
			"licence",
			"licentious",
			"licit",
			"lido",
			"lien",
			"ligature",
			"ligneous",
			"lilliputian",
			"limb",
			"limber",
			"limbo",
			"limerick",
			"limn",
			"limnetic",
			"limousine",
			"limpid",
			"lineal",
			"linear",
			"linger",
			"lingering",
			"lingual",
			"linguistics",
			"linoleum",
			"lint",
			"lionize",
			"liquefy",
			"liquidate",
			"liquidation",
			"lissom",
			"listless",
			"literal",
			"literati",
			"lithe",
			"litigant",
			"litigious",
			"litter",
			"litterbin",
			"littoral",
			"liturgy",
			"liturgical",
			"livable",
			"lively",
			"liverish",
			"livid",
			"loaf",
			"loam",
			"loathe",
			"loathsome",
			"lobby",
			"lobe",
			"lobster",
			"locale",
			"locomotion",
			"locomotive",
			"locus",
			"locust",
			"locution",
			"lodge",
			"lodger",
			"loft",
			"lofty",
			"log",
			"logistics",
			"logjam",
			"loiter",
			"loll",
			"longevity",
			"longitude",
			"longueur",
			"loom",
			"loon",
			"loop",
			"loot",
			"lope",
			"loquacious",
			"lore",
			"lottery",
			"lounge",
			"lounger",
			"lout",
			"loutish",
			"lowbred",
			"lubricant",
			"lubricious",
			"lucrative",
			"lucre",
			"lucubrate",
			"lucubration",
			"lugubrious",
			"lukewarm",
			"lullaby",
			"lumber",
			"luminary",
			"luminous",
			"lump",
			"lumpish",
			"lunacy",
			"lunatic",
			"lurch",
			"lure",
			"lurk",
			"luscious",
			"lust",
			"lusty",
			"lustre",
			"lustrous",
			"luxuriant",
			"lynch",
			"lyric",
			"macabre",
			"mace",
			"macerate",
			"machination",
			"macrocosm",
			"maddening",
			"madrigal",
			"maelstrom",
			"maestro",
			"magenta",
			"magisterial",
			"magistrate",
			"magistracy",
			"magnanimous",
			"magnate",
			"magnetism",
			"magnify",
			"magnification",
			"magniloquent",
			"magnitude",
			"magpie",
			"maim",
			"makeshift",
			"maladroit",
			"malapropism",
			"malcontent",
			"malcontented",
			"malediction",
			"malevolent",
			"malfunction",
			"malice",
			"malicious",
			"malign",
			"malignant",
			"malignity",
			"malinger",
			"malleable",
			"mallet",
			"malnutrition",
			"malodorous",
			"maltreat",
			"mammal",
			"manacle",
			"mandate",
			"mandatory",
			"maneuver",
			"maneuverable",
			"mangle",
			"mania",
			"maniacal",
			"manifest",
			"manifesto",
			"manifold",
			"manipulative",
			"mannequin",
			"mansion",
			"mantle",
			"manumit",
			"manuscript",
			"maple",
			"mar",
			"maraud",
			"mare",
			"margarine",
			"marginal",
			"marine",
			"mariner",
			"marionette",
			"marital",
			"marrow",
			"marsh",
			"marsupial",
			"martinet",
			"martyr",
			"mash",
			"mask",
			"mason",
			"masonry",
			"masquerade",
			"massacre",
			"massive",
			"mast",
			"masticate",
			"matador",
			"materialize",
			"matriarchy",
			"matrix",
			"mattress",
			"maturity",
			"maudlin",
			"maul",
			"maverick",
			"mawkish",
			"maxim",
			"mayhem",
			"maze",
			"meadow",
			"meager",
			"meander",
			"measles",
			"measured",
			"medal",
			"meddlesome",
			"median",
			"mediate",
			"medieval",
			"mediocre",
			"mediocrity",
			"meditative",
			"medium",
			"medley",
			"megalomania",
			"melancholy",
			"mellifluous",
			"melodrama",
			"melody",
			"melodious",
			"melon",
			"membrane",
			"memento",
			"menace",
			"mendacity",
			"menial",
			"mentor",
			"merchandise",
			"mercurial",
			"mere",
			"meretricious",
			"meritorious",
			"mermaid",
			"mesa",
			"mesmerize",
			"metabolism",
			"metamorphosis",
			"metaphor",
			"metaphorical",
			"metaphysics",
			"meteoric",
			"meticulous",
			"mettle",
			"mettlesome",
			"miasma",
			"microbe",
			"microscopic",
			"midget",
			"mien",
			"migrant",
			"mildew",
			"milieu",
			"militant",
			"miller",
			"millinery",
			"mime",
			"mimic",
			"mimicry",
			"minaret",
			"minatory",
			"mince",
			"miniature",
			"minion",
			"minnow",
			"minuet",
			"minutia",
			"mirage",
			"mire",
			"mirth",
			"misanthrope",
			"miscellany",
			"miscellaneous",
			"mischievous",
			"misconstrue",
			"miscreant",
			"mishap",
			"missile",
			"mistimed",
			"mistral",
			"mists",
			"mite",
			"mitigate",
			"mitten",
			"mnemonics",
			"moan",
			"moat",
			"mock",
			"moderate",
			"moderator",
			"modicum",
			"modify",
			"modification",
			"modish",
			"modulate",
			"mogul",
			"moiety",
			"molar",
			"molest",
			"mollify",
			"mollusk",
			"mollycoddle",
			"momentary",
			"momentous",
			"momentum",
			"monarch",
			"monastery",
			"monasticism",
			"mongrel",
			"monogamy",
			"monograph",
			"monolithic",
			"monologue",
			"monopoly",
			"monotonous",
			"monsoon",
			"monster",
			"monstrous",
			"moor",
			"mope",
			"morale",
			"moralist",
			"moralistic",
			"morass",
			"moratorium",
			"morbid",
			"morbidity",
			"mordant",
			"mores",
			"moribund",
			"moron",
			"morose",
			"morphemics",
			"morsel",
			"mortar",
			"mortgage",
			"mortify",
			"mortification",
			"mortuary",
			"mosaic",
			"mote",
			"motif",
			"motivate",
			"motivation",
			"motley",
			"mottled",
			"motto",
			"mountebank",
			"mourn",
			"mournful",
			"movement",
			"muddle",
			"muffle",
			"muffler",
			"muggy",
			"multifarious",
			"multitude",
			"mundane",
			"munificent",
			"muniments",
			"munitions",
			"murky",
			"murmur",
			"muse",
			"muster",
			"mutation",
			"mute",
			"mutilate",
			"mutineer",
			"mutinous",
			"mutton",
			"muzzy",
			"myopia",
			"myriad",
			"myth",
			"mythology",
			"nadir",
			"nag",
			"naivete",
			"nap",
			"narcissism",
			"nasal",
			"nascent",
			"nativity",
			"natty",
			"nausea",
			"nauseate",
			"nautical",
			"nave",
			"nebula",
			"nebulous",
			"necessitous",
			"necromancy",
			"necropolis",
			"needle",
			"nefarious",
			"negate",
			"negation",
			"negligence",
			"negligible",
			"negotiable",
			"nemesis",
			"neolithic",
			"neologism",
			"neonate",
			"neophyte",
			"nephritis",
			"nepotism",
			"nerveless",
			"nestle",
			"nestling",
			"nethermost",
			"nettle",
			"neurology",
			"neurosis",
			"neurotic",
			"neutral",
			"neutralize",
			"nexus",
			"nib",
			"nibble",
			"niche",
			"nick",
			"nicotine",
			"niggard",
			"niggardly",
			"niggling",
			"nightmare",
			"nihilism",
			"nimble",
			"nippers",
			"nipping",
			"nirvana",
			"nitpick",
			"nocturnal",
			"noisome",
			"nomad",
			"nomadic",
			"nomenclature",
			"nominal",
			"nomination",
			"nonchalance",
			"nonchalant",
			"noncommittal",
			"nonconformist",
			"nonconformity",
			"nondescript",
			"nonentity",
			"nonesuch",
			"nonflammable",
			"nonobservance",
			"nonpareil",
			"nonplus",
			"nonskid",
			"nonviolent",
			"noose",
			"norm",
			"normative",
			"nostalgia",
			"nostrum",
			"notability",
			"notched",
			"notify",
			"notoriety",
			"notorious",
			"novelettish",
			"novelty",
			"novice",
			"novocaine",
			"noxious",
			"nuance",
			"nubile",
			"nude",
			"nudity",
			"nudge",
			"nugatory",
			"nullify",
			"nullity",
			"numb",
			"numerology",
			"numinous",
			"numismatic",
			"numismatist",
			"nunnery",
			"nuptial",
			"nuptials",
			"nymph",
			"oafish",
			"oak",
			"oar",
			"oasis",
			"oath",
			"obdurate",
			"obedient",
			"obeisance",
			"obese",
			"obesity",
			"obfuscate",
			"objection",
			"objectionable",
			"oblation",
			"obligation",
			"obligatory",
			"obliging",
			"oblique",
			"obliterate",
			"oblivion",
			"oblivious",
			"obloquy",
			"obnoxious",
			"obscure",
			"obscurity",
			"obsequies",
			"obsequious",
			"observance",
			"obsession",
			"obsolescent",
			"obsolete",
			"obstacle",
			"obstetrics",
			"obstinate",
			"obstreperous",
			"obstruct",
			"obstruction",
			"obtrude",
			"obtrusive",
			"obtuse",
			"obverse",
			"obviate",
			"occidental",
			"occult",
			"occurrence",
			"octogenarian",
			"ocular",
			"oculist",
			"oddments",
			"ode",
			"odious",
			"odium",
			"odoriferous",
			"oesophagus",
			"offense",
			"offensive",
			"officious",
			"ogle",
			"ointment",
			"olfactory",
			"oligarchy",
			"omen",
			"ominous",
			"omission",
			"omnipotent",
			"omniscient",
			"omnivorous",
			"onerous",
			"onlooker",
			"onslaught",
			"ontology",
			"onus",
			"ooze",
			"opalescent",
			"opaque",
			"opacity",
			"operetta",
			"operative",
			"ophthalmology",
			"opiate",
			"opinionated",
			"opponent",
			"opportune",
			"oppressive",
			"opprobrious",
			"opprobrium",
			"optimism",
			"optimum",
			"optional",
			"opulent",
			"opulence",
			"oracle",
			"oracular",
			"oration",
			"oratorio",
			"orchid",
			"ordain",
			"ordeal",
			"ordinance",
			"ordination",
			"ordnance",
			"ore",
			"organism",
			"orient",
			"orientation",
			"orifice",
			"originality",
			"ornate",
			"ornithology",
			"orotund",
			"orthodontics",
			"orthodox",
			"orthodoxy",
			"orthopedics",
			"oscillate",
			"oscillation",
			"osmosis",
			"osseous",
			"ossify",
			"ostensible",
			"ostentation",
			"ostracize",
			"ostrich",
			"otiose",
			"outbid",
			"outfox",
			"outgoing",
			"outlandish",
			"outmoded",
			"outrage",
			"outrageous",
			"outset",
			"outskirts",
			"outstrip",
			"outwit",
			"ovation",
			"overact",
			"overbearing",
			"overdose",
			"overhaul",
			"overlap",
			"overreach",
			"override",
			"overriding",
			"overrule",
			"overshadow",
			"overt",
			"overture",
			"overweening",
			"overwhelm",
			"overwhelming",
			"overwrought",
			"owl",
			"oxidize",
			"oyster",
			"pabulum",
			"pachyderm",
			"pacifier",
			"packed",
			"pact",
			"paean",
			"pagan",
			"paganism",
			"pageant",
			"painkiller",
			"pal",
			"palatable",
			"palate",
			"palatial",
			"palaver",
			"paleography",
			"paleolithic",
			"palette",
			"palings",
			"palliate",
			"palliation",
			"pallid",
			"palpable",
			"palpitate",
			"paltry",
			"pamper",
			"pamphlet",
			"pan",
			"panacea",
			"pancreas",
			"pandemic",
			"pandemonium",
			"panegyric",
			"panel",
			"panic",
			"panoply",
			"panorama",
			"pantheon",
			"pantomime",
			"pantry",
			"papyrus",
			"par",
			"parable",
			"paradigm",
			"paradigmatic",
			"paradox",
			"paragon",
			"paralyze",
			"paralysis",
			"paramount",
			"paranoia",
			"paranoid",
			"parasite",
			"parasitic",
			"parch",
			"parchment",
			"parenthesis",
			"pariah",
			"parley",
			"parlous",
			"parochial",
			"parody",
			"paroxysm",
			"parquet",
			"parquetry",
			"parry"
		);
		$username = $usernamelist[array_rand($usernamelist)] . random_str(2);
		$password = random_str(12);
		$lines = $this->get_wiki_source("password");
		$find = false;
		foreach ($lines as & $i) {
			$i = str_replace(" ", "", $i);
			$i = str_replace("　", "", $i);
			$i = explode('|', chop($i));
			if (strstr(f('url'), $i[1])) {
				$singleline = $i;
				$find = true;
			}
		}

		//var_dump($lines);exit;
		$this->sv("list", array (
			$singleline
		));
		$this->sv("username", $username);
		$this->sv("password", $password);
		if (!$find) {
			$this->fmodel("password")->save(array (
				"url" => "",
				'name' => $username,
				'pass' => $password
			));
		}
	}

	function data() {
		$mysqltables = $this->model("crud")->table_names();
		$filetables = $this->fmodel("crud")->table_names();

		$this->sv("mysqltables", $mysqltables);
		$this->sv("filetables", $filetables);
	}

	function baodu() {
		$db = $this->fmodel("baodujava");
		$data = $db->peek(array (
			'flag' => 1
		));
		$str = $this->url2str2($data['url']);
		$str = $this->trackinfo($str);

		preg_match('/target=_blank >([^<]*)<\/a>/', $str, $matches);
		$data['asker'] = mb_convert_encoding($matches[1], 'UTF-8', 'gbk');
		preg_match_all('/target=_blank>([^<]*)<\/a>/', $str, $matches);

		$data['answer'] = mb_convert_encoding($matches[1][3], 'UTF-8', 'gbk');

		preg_match('/<cd><pre>(.*)<\/pre><\/cd>/', $str, $matches);
		$data['title2'] = mb_convert_encoding($matches[1], 'UTF-8', 'gbk');
		preg_match('/<\/b><pre>(.*)<\/pre><\/div><\/div>/', $str, $matches);
		$data['title3'] = mb_convert_encoding($matches[1], 'UTF-8', 'gbk');
		preg_match('/<ca><pre>(.*)<\/pre><\/ca>/', $str, $matches);
		$data['huida'] = mb_convert_encoding($matches[1], 'UTF-8', 'gbk');
		$data['flag'] = 2;
		$db->save($data);

		return new ControlUnit("redirect_url", array (
			"/filecms/baodujava/show/" . $data['id']
		));
	}

	function tool() {
		$word = f("word");
		$this->sv("md5", md5($word));
		$this->sv("urlencode", urlencode($word));
		$this->sv("urldecode", urldecode($word));
		$this->sv("escape", e($word));
	}

	function ejb() {
		$params = array ();
		for ($i = 0; $i < 100; $i++) {
			if (f("p" . $i)) {
				$params[] = f("p" . $i);
			} else {
				break;
			}
		}
		$str = $this->ejbCall(f("m"), $params);
		$str = preg_replace('/^[\r|\n]+/i', '', $str);
		$str = preg_replace('/\r|\n/i', '<br>', $str);

		$hash = json_decode($str);

		echo "<a href=ejb?m=fileRecord&p0=dicxiaodi&p1=NG9c3aP>fileRecord</a>, ";
		echo "<a href=ejb?m=mysqlRecord&p0=crud&p1=3>mysqlRecord</a>, ";
		echo "<a href=ejb?m=getArticle&p0=618>mysqlRecord</a>, ";
		echo "<a href=ejb?m=getWiki&p0=零时>getWiki</a>, ";

		echo "<hr>";
		echo $str;
		echo "<hr>";
		var_dump($hash);
		exit;

	}

	function seesource() {
		$data = file(f("file"));
		$j = 0;
		$output = "";
		foreach ($data as $i) {
			$j++;
			$output .= "<a name=p$j></a>";
			if (f("line") == $j) {
				$output .= "<font color=red>$j</font>";
				$i = str_replace(f("word"), "<font color=red size=5>" . f("word") . "</font>", e($i));
			} else {
				$output .= $j;
				$i = e($i);
			}

			$i = preg_replace('/\t/', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $i);

			$output .= ":" . $i . "<br>";

		}
		$phpfunc = array (
			"Phar",
			"PharData",
			"PharException",
			"PharFileInfo",
			"abs",
			"acos",
			"acosh",
			"addcslashes",
			"addslashes",
			"aggregate",
			"aggregate_info",
			"aggregate_methods",
			"aggregate_methods_by_list",
			"aggregate_methods_by_regexp",
			"aggregate_properties",
			"aggregate_properties_by_list",
			"aggregate_properties_by_regexp",
			"aggregation_info",
			"apache_child_terminate",
			"apache_get_modules",
			"apache_get_version",
			"apache_getenv",
			"apache_lookup_uri",
			"apache_note",
			"apache_request_headers",
			"apache_reset_timeout",
			"apache_response_headers",
			"apache_setenv",
			"apc_add",
			"apc_cache_info",
			"apc_clear_cache",
			"apc_compile_file",
			"apc_define_constants",
			"apc_delete",
			"apc_fetch",
			"apc_load_constants",
			"apc_sma_info",
			"apc_store",
			"apd_breakpoint",
			"apd_callstack",
			"apd_clunk",
			"apd_continue",
			"apd_croak",
			"apd_dump_function_table",
			"apd_dump_persistent_resources",
			"apd_dump_regular_resources",
			"apd_echo",
			"apd_get_active_symbols",
			"apd_set_pprof_trace",
			"apd_set_session",
			"apd_set_session_trace",
			"apd_set_session_trace_socket",
			"appenditerator",
			"array",
			"array_change_key_case",
			"array_chunk",
			"array_combine",
			"array_count_values",
			"array_diff",
			"array_diff_assoc",
			"array_diff_key",
			"array_diff_uassoc",
			"array_diff_ukey",
			"array_fill",
			"array_fill_keys",
			"array_filter",
			"array_flip",
			"array_intersect",
			"array_intersect_assoc",
			"array_intersect_key",
			"array_intersect_uassoc",
			"array_intersect_ukey",
			"array_key_exists",
			"array_keys",
			"array_map",
			"array_merge",
			"array_merge_recursive",
			"array_multisort",
			"array_pad",
			"array_pop",
			"array_product",
			"array_push",
			"array_rand",
			"array_reduce",
			"array_replace",
			"array_replace_recursive",
			"array_reverse",
			"array_search",
			"array_shift",
			"array_slice",
			"array_splice",
			"array_sum",
			"array_udiff",
			"array_udiff_assoc",
			"array_udiff_uassoc",
			"array_uintersect",
			"array_uintersect_assoc",
			"array_uintersect_uassoc",
			"array_unique",
			"array_unshift",
			"array_values",
			"array_walk",
			"array_walk_recursive",
			"arrayaccess",
			"arrayiterator",
			"arrayobject",
			"arsort",
			"ascii2ebcdic",
			"asin",
			"asinh",
			"asort",
			"assert",
			"assert_options",
			"atan",
			"atan2",
			"atanh",

			"base64_decode",
			"base64_encode",
			"base_convert",
			"basename",
			"bbcode_add_element",
			"bbcode_add_smiley",
			"bbcode_create",
			"bbcode_destroy",
			"bbcode_parse",
			"bbcode_set_arg_parser",
			"bbcode_set_flags",
			"bcadd",
			"bccomp",
			"bcdiv",
			"bcmod",
			"bcmul",

			"bcpow",
			"bcpowmod",
			"bcscale",
			"bcsqrt",
			"bcsub",
			"bin2hex",
			"bind_textdomain_codeset",
			"bindec",
			"bindtextdomain",
			"bumpValue",
			"bzclose",
			"bzcompress",
			"bzdecompress",
			"bzerrno",
			"bzerror",
			"bzerrstr",
			"bzflush",
			"bzopen",
			"bzread",
			"bzwrite",
			"cachingiterator",
			"cal_days_in_month",
			"cal_from_jd",
			"cal_info",
			"cal_to_jd",
			"calcul_hmac",
			"calculhmac",
			"call_user_func",
			"call_user_func_array",
			"call_user_method",
			"call_user_method_array",
			"ceil",
			"chdir",
			"checkdate",
			"checkdnsrr",
			"chgrp",
			"chmod",
			"chop",
			"chown",
			"chr",
			"chroot",
			"chunk_split",
			"class_alias",
			"class_exists",
			"class_implements",
			"class_parents",
			"classkit_import",
			"classkit_method_add",
			"classkit_method_copy",
			"classkit_method_redefine",
			"classkit_method_remove",
			"classkit_method_rename",
			"clearstatcache",
			"closedir",
			"closelog",
			"collator",
			"com",
			"com_addref",
			"com_create_guid",
			"com_event_sink",
			"com_get",
			"com_get_active_object",
			"com_invoke",
			"com_isenum",
			"com_load",
			"com_load_typelib",
			"com_message_pump",
			"com_print_typeinfo",
			"com_propget",
			"com_propput",
			"com_propset",
			"com_release",
			"com_set",
			"compact",
			"connection_aborted",
			"connection_status",
			"connection_timeout",
			"constant",
			"construct",
			"convert_cyr_string",
			"convert_uudecode",
			"convert_uuencode",
			"copy",
			"cos",
			"cosh",
			"count",
			"count_chars",
			"countable",
			"counter_bump",
			"counter_bump_value",
			"counter_create",
			"counter_get",
			"counter_get_meta",
			"counter_get_named",
			"counter_get_value",
			"counter_reset",
			"counter_reset_value",
			"crack_check",
			"crack_closedict",
			"crack_getlastmessage",
			"crack_opendict",
			"crc32",
			"create_function",
			"crypt",
			"ctype_alnum",
			"ctype_alpha",
			"ctype_cntrl",
			"ctype_digit",
			"ctype_graph",
			"ctype_lower",
			"ctype_print",
			"ctype_punct",
			"ctype_space",
			"ctype_upper",
			"ctype_xdigit",
			"curl_close",
			"curl_copy_handle",
			"curl_errno",
			"curl_error",
			"curl_exec",
			"curl_getinfo",
			"curl_init",
			"curl_multi_add_handle",
			"curl_multi_close",
			"curl_multi_exec",
			"curl_multi_getcontent",
			"curl_multi_info_read",
			"curl_multi_init",
			"curl_multi_remove_handle",
			"curl_multi_select",
			"curl_setopt",
			"curl_setopt_array",
			"curl_version",
			"current",
			"cyrus_authenticate",
			"cyrus_bind",
			"cyrus_close",
			"cyrus_connect",
			"cyrus_query",
			"cyrus_unbind",
			"date",
			"date_add",
			"date_create",
			"date_create_from_format",
			"date_date_set",
			"date_default_timezone_get",
			"date_default_timezone_set",
			"date_diff",
			"date_format",
			"date_get_last_errors",
			"date_interval_create_from_date_string",
			"date_interval_format",
			"date_isodate_set",
			"date_modify",
			"date_offset_get",
			"date_parse",
			"date_parse_from_format",
			"date_sub",
			"date_sun_info",
			"date_sunrise",
			"date_sunset",
			"date_time_set",
			"date_timestamp_get",
			"date_timestamp_set",
			"date_timezone_get",
			"date_timezone_set",
			"dateinterval",
			"dateperiod",
			"datetime",
			"datetimezone",

			"dbx_close",
			"dbx_compare",
			"dbx_connect",
			"dbx_error",
			"dbx_escape_string",
			"dbx_fetch_row",
			"dbx_query",
			"dbx_sort",
			"dcgettext",
			"dcngettext",
			"deaggregate",
			"debug_backtrace",
			"debug_print_backtrace",
			"debug_zval_dump",
			"decbin",
			"dechex",
			"decoct",
			"define",
			"define_syslog_variables",
			"defined",
			"deg2rad",
			"delete",
			"dgettext",
			"die",
			"dio_close",
			"dio_fcntl",
			"dio_open",
			"dio_read",
			"dio_seek",
			"dio_stat",
			"dio_tcsetattr",
			"dio_truncate",
			"dio_write",
			"dir",
			"directoryiterator",
			"dirname",
			"disk_free_space",
			"disk_total_space",
			"diskfreespace",
			"dl",
			"dngettext",
			"dns_check_record",
			"dns_get_mx",
			"dns_get_record",
			"dom_import_simplexml",
			"domainexception",
			"domattr",
			"domattribute_name",
			"domattribute_set_value",
			"domattribute_specified",
			"domattribute_value",
			"domcharacterdata",

			"dotnet",
			"dotnet_load",
			"doubleval",
			"each",
			"easter_date",
			"easter_days",
			"ebcdic2ascii",
			"echo",
			"empty",
			"emptyiterator",

			"end",
			"ereg",
			"ereg_replace",
			"eregi",
			"eregi_replace",
			"error_get_last",
			"error_log",
			"error_reporting",
			"errorexception",
			"escapeshellarg",
			"escapeshellcmd",
			"eval",
			"exception",
			"exec",
			"exif_imagetype",
			"exif_read_data",
			"exif_tagname",
			"exif_thumbnail",
			"exit",
			"exp",
			"expect_expectl",
			"expect_popen",
			"explode",
			"expm1",
			"extension_loaded",
			"extract",
			"ezmlm_hash",
			"fam_cancel_monitor",
			"fam_close",
			"fam_monitor_collection",
			"fam_monitor_directory",
			"fam_monitor_file",
			"fam_next_event",
			"fam_open",
			"fam_pending",
			"fam_resume_monitor",
			"fam_suspend_monitor",

			"fclose",
			"fdf_add_doc_javascript",
			"fdf_add_template",
			"fdf_close",
			"fdf_create",
			"fdf_enum_values",
			"fdf_errno",
			"fdf_error",
			"fdf_get_ap",
			"fdf_get_attachment",
			"fdf_get_encoding",
			"fdf_get_file",
			"fdf_get_flags",
			"fdf_get_opt",
			"fdf_get_status",
			"fdf_get_value",
			"fdf_get_version",
			"fdf_header",
			"fdf_next_field_name",
			"fdf_open",
			"fdf_open_string",
			"fdf_remove_item",
			"fdf_save",
			"fdf_save_string",
			"fdf_set_ap",
			"fdf_set_encoding",
			"fdf_set_file",
			"fdf_set_flags",
			"fdf_set_javascript_action",
			"fdf_set_on_import_javascript",
			"fdf_set_opt",
			"fdf_set_status",
			"fdf_set_submit_form_action",
			"fdf_set_target_frame",
			"fdf_set_value",
			"fdf_set_version",
			"feof",
			"fflush",
			"fgetc",
			"fgetcsv",
			"fgets",
			"fgetss",
			"file",
			"file_exists",
			"file_get_contents",
			"file_put_contents",
			"fileatime",
			"filectime",
			"filegroup",
			"fileinode",
			"filemtime",
			"fileowner",
			"fileperms",
			"filepro",
			"filepro_fieldcount",
			"filepro_fieldname",
			"filepro_fieldtype",
			"filepro_fieldwidth",
			"filepro_retrieve",
			"filepro_rowcount",
			"filesize",
			"filesystemiterator",
			"filetype",
			"filter_has_var",
			"filter_id",
			"filter_input",
			"filter_input_array",
			"filter_list",
			"filter_var",
			"filter_var_array",
			"filteriterator",
			"finfo_buffer",
			"finfo_close",
			"finfo_file",
			"finfo_open",
			"finfo_set_flags",
			"floatval",
			"flock",
			"floor",
			"flush",
			"fmod",
			"fnmatch",
			"fopen",
			"forward_static_call",
			"forward_static_call_array",
			"fpassthru",
			"fprintf",
			"fputcsv",
			"fputs",
			"fread",
			"frenchtojd",
			"fribidi_log2vis",
			"fscanf",
			"fseek",
			"fsockopen",
			"fstat",
			"ftell",
			"ftok",

			"ftp_systype",
			"ftruncate",
			"func_get_arg",
			"func_get_args",
			"func_num_args",
			"function_exists",
			"fwrite",
			"gc_collect_cycles",
			"gc_disable",
			"gc_enable",
			"gc_enabled",
			"gd_info",
			"geoip_continent_code_by_name",
			"geoip_country_code3_by_name",
			"geoip_country_code_by_name",
			"geoip_country_name_by_name",
			"geoip_database_info",
			"geoip_db_avail",
			"geoip_db_filename",
			"geoip_db_get_all_info",
			"geoip_id_by_name",
			"geoip_isp_by_name",
			"geoip_org_by_name",
			"geoip_record_by_name",
			"geoip_region_by_name",
			"geoip_region_name_by_code",
			"geoip_time_zone_by_country_and_region",
			"getMeta",
			"getNamed",
			"getValue",
			"get_browser",
			"get_called_class",
			"get_cfg_var",
			"get_class",
			"get_class_methods",
			"get_class_vars",
			"get_current_user",
			"get_declared_classes",
			"get_declared_interfaces",
			"get_defined_constants",
			"get_defined_functions",
			"get_defined_vars",
			"get_extension_funcs",
			"get_headers",
			"get_html_translation_table",
			"get_include_path",
			"get_included_files",
			"get_loaded_extensions",
			"get_magic_quotes_gpc",
			"get_magic_quotes_runtime",
			"get_meta_tags",
			"get_object_vars",
			"get_parent_class",
			"get_required_files",
			"get_resource_type",
			"getallheaders",
			"getcwd",
			"getdate",
			"getenv",
			"gethostbyaddr",
			"gethostbyname",
			"gethostbynamel",
			"gethostname",
			"getimagesize",
			"getlastmod",
			"getmxrr",
			"getmygid",
			"getmyinode",
			"getmypid",
			"getmyuid",
			"getopt",
			"getprotobyname",
			"getprotobynumber",
			"getrandmax",
			"getrusage",
			"getservbyname",
			"getservbyport",
			"gettext",
			"gettimeofday",
			"gettype",
			"glob",
			"globiterator",
			"gmdate",
			"gmmktime",

			"gmstrftime",
			"gnupg_adddecryptkey",
			"gnupg_addencryptkey",
			"gnupg_addsignkey",
			"gnupg_cleardecryptkeys",
			"gnupg_clearencryptkeys",
			"gnupg_clearsignkeys",
			"gnupg_decrypt",
			"gnupg_decryptverify",
			"gnupg_encrypt",
			"gnupg_encryptsign",
			"gnupg_export",
			"gnupg_geterror",
			"gnupg_getprotocol",
			"gnupg_import",
			"gnupg_init",
			"gnupg_keyinfo",
			"gnupg_setarmor",
			"gnupg_seterrormode",
			"gnupg_setsignmode",
			"gnupg_sign",
			"gnupg_verify",
			"gopher_parsedir",
			"grapheme_extract",
			"grapheme_stripos",
			"grapheme_stristr",
			"grapheme_strlen",
			"grapheme_strpos",
			"grapheme_strripos",
			"grapheme_strrpos",
			"grapheme_strstr",
			"grapheme_substr",
			"gregoriantojd",
			"gzclose",
			"gzcompress",
			"gzdecode",
			"gzdeflate",
			"gzencode",
			"gzeof",
			"gzfile",
			"gzgetc",
			"gzgets",
			"gzgetss",
			"gzinflate",
			"gzopen",
			"gzpassthru",
			"gzputs",
			"gzread",
			"gzrewind",
			"gzseek",
			"gztell",
			"gzuncompress",
			"gzwrite",
			"halt_compiler",
			"haruannotation",
			"haruannotation_setborderstyle",
			"haruannotation_sethighlightmode",
			"haruannotation_seticon",
			"haruannotation_setopened",
			"harudestination",

			"hypot",
			"ibase_add_user",
			"ibase_affected_rows",
			"ibase_backup",
			"ibase_blob_add",
			"ibase_blob_cancel",
			"ibase_blob_close",
			"ibase_blob_create",
			"ibase_blob_echo",
			"ibase_blob_get",
			"ibase_blob_import",
			"ibase_blob_info",
			"ibase_blob_open",
			"ibase_close",
			"ibase_commit",
			"ibase_commit_ret",
			"ibase_connect",
			"ibase_db_info",
			"ibase_delete_user",
			"ibase_drop_db",
			"ibase_errcode",
			"ibase_errmsg",
			"ibase_execute",
			"ibase_fetch_assoc",
			"ibase_fetch_object",
			"ibase_fetch_row",
			"ibase_field_info",
			"ibase_free_event_handler",
			"ibase_free_query",
			"ibase_free_result",
			"ibase_gen_id",
			"ibase_maintain_db",
			"ibase_modify_user",
			"ibase_name_result",
			"ibase_num_fields",
			"ibase_num_params",
			"ibase_param_info",
			"ibase_pconnect",
			"ibase_prepare",
			"ibase_query",
			"ibase_restore",
			"ibase_rollback",
			"ibase_rollback_ret",
			"ibase_server_info",
			"ibase_service_attach",
			"ibase_service_detach",
			"ibase_set_event_handler",
			"ibase_timefmt",
			"ibase_trans",
			"ibase_wait_event",
			"iconv",
			"iconv_get_encoding",
			"iconv_mime_decode",
			"iconv_mime_decode_headers",
			"iconv_mime_encode",
			"iconv_set_encoding",
			"iconv_strlen",
			"iconv_strpos",
			"iconv_strrpos",
			"iconv_substr",
			"id3_get_frame_long_name",
			"id3_get_frame_short_name",
			"id3_get_genre_id",
			"id3_get_genre_list",
			"id3_get_genre_name",
			"id3_get_tag",
			"id3_get_version",
			"id3_remove_tag",
			"id3_set_tag",
			"id3v2attachedpictureframe",
			"id3v2frame",
			"id3v2tag",
			"idate",

			"ignore_user_abort",

			"image2wbmp",

			"imap_8bit",
			"imap_alerts",
			"imap_append",
			"imap_base64",
			"imap_binary",
			"imap_body",
			"imap_bodystruct",
			"imap_check",
			"imap_clearflag_full",
			"imap_close",
			"imap_createmailbox",
			"imap_delete",
			"imap_deletemailbox",
			"imap_errors",
			"imap_expunge",
			"imap_fetch_overview",
			"imap_fetchbody",
			"imap_fetchheader",
			"imap_fetchstructure",
			"imap_gc",
			"imap_get_quota",
			"imap_get_quotaroot",
			"imap_getacl",
			"imap_getmailboxes",
			"imap_getsubscribed",
			"imap_header",
			"imap_headerinfo",
			"imap_headers",
			"imap_last_error",
			"imap_list",
			"imap_listmailbox",
			"imap_listscan",
			"imap_listsubscribed",
			"imap_lsub",
			"imap_mail",
			"imap_mail_compose",
			"imap_mail_copy",
			"imap_mail_move",
			"imap_mailboxmsginfo",
			"imap_mime_header_decode",
			"imap_msgno",
			"imap_num_msg",
			"imap_num_recent",
			"imap_open",
			"imap_ping",
			"imap_qprint",
			"imap_renamemailbox",
			"imap_reopen",
			"imap_rfc822_parse_adrlist",
			"imap_rfc822_parse_headers",
			"imap_rfc822_write_address",
			"imap_savebody",
			"imap_scanmailbox",
			"imap_search",
			"imap_set_quota",
			"imap_setacl",
			"imap_setflag_full",
			"imap_sort",
			"imap_status",
			"imap_subscribe",
			"imap_thread",
			"imap_timeout",
			"imap_uid",
			"imap_undelete",
			"imap_unsubscribe",
			"imap_utf7_decode",
			"imap_utf7_encode",
			"imap_utf8",
			"implode",
			"import_request_variables",
			"in_array",
			"include",
			"include_once",
			"inclued_get_data",
			"inet_ntop",
			"inet_pton",
			"infiniteiterator",
			"ingres_autocommit",
			"ingres_autocommit_state",
			"ingres_charset",
			"ingres_close",
			"ingres_commit",
			"ingres_connect",
			"ingres_cursor",
			"ingres_errno",
			"ingres_error",
			"ingres_errsqlstate",
			"ingres_escape_string",
			"ingres_execute",
			"ingres_fetch_array",
			"ingres_fetch_object",
			"ingres_fetch_proc_return",
			"ingres_fetch_row",
			"ingres_field_length",
			"ingres_field_name",
			"ingres_field_nullable",
			"ingres_field_precision",
			"ingres_field_scale",
			"ingres_field_type",
			"ingres_free_result",
			"ingres_next_error",
			"ingres_num_fields",
			"ingres_num_rows",
			"ingres_pconnect",
			"ingres_prepare",
			"ingres_query",
			"ingres_result_seek",
			"ingres_rollback",
			"ingres_set_environment",
			"ingres_unbuffered_query",
			"ini_alter",
			"ini_get",
			"ini_get_all",
			"ini_restore",
			"ini_set",
			"inotify_add_watch",
			"inotify_init",
			"inotify_queue_len",
			"inotify_read",
			"inotify_rm_watch",
			"interface_exists",
			"intl_error_name",
			"intl_get_error_code",
			"intl_get_error_message",
			"intl_is_failure",
			"intldateformatter",
			"intval",
			"invalidargumentexception",
			"ip2long",
			"iptcembed",
			"iptcparse",
			"is_a",
			"is_array",
			"is_binary",
			"is_bool",
			"is_buffer",
			"is_callable",
			"is_dir",
			"is_double",
			"is_executable",
			"is_file",
			"is_finite",
			"is_float",
			"is_infinite",
			"is_int",
			"is_integer",
			"is_link",
			"is_long",
			"is_nan",
			"is_null",
			"is_numeric",
			"is_object",
			"is_readable",
			"is_real",
			"is_resource",
			"is_scalar",
			"is_soap_fault",
			"is_string",
			"is_subclass_of",
			"is_unicode",
			"is_uploaded_file",
			"is_writable",
			"is_writeable",
			"isset",
			"iterator",
			"iterator_apply",
			"iterator_count",
			"iterator_to_array",
			"iteratoraggregate",
			"iteratoriterator",
			"java_last_exception_clear",
			"java_last_exception_get",
			"jddayofweek",
			"jdmonthname",
			"jdtofrench",
			"jdtogregorian",
			"jdtojewish",
			"jdtojulian",
			"jdtounix",
			"jewishtojd",
			"join",
			"jpeg2wbmp",
			"json_decode",
			"json_encode",
			"json_last_error",
			"juliantojd",

			"key",
			"krsort",
			"ksort",
			"lcfirst",
			"lcg_value",
			"lchgrp",
			"lchown",

			"lengthexception",
			"levenshtein",
			"libxml_clear_errors",
			"libxml_disable_entity_loader",
			"libxml_get_errors",
			"libxml_get_last_error",
			"libxml_set_streams_context",
			"libxml_use_internal_errors",
			"libxmlerror",
			"limititerator",
			"link",
			"linkinfo",
			"list",
			"locale",
			"locale_get_default",
			"locale_set_default",
			"localeconv",
			"localtime",
			"log",
			"log10",
			"log1p",
			"logicexception",
			"long2ip",
			"lstat",
			"ltrim",
			"lzf_compress",
			"lzf_decompress",
			"lzf_optimized_for",
			"m_checkstatus",
			"m_completeauthorizations",
			"m_connect",
			"m_connectionerror",
			"m_deletetrans",
			"m_destroyconn",
			"m_destroyengine",
			"m_getcell",
			"m_getcellbynum",
			"m_getcommadelimited",
			"m_getheader",
			"m_initconn",
			"m_initengine",
			"m_iscommadelimited",
			"m_maxconntimeout",
			"m_monitor",
			"m_numcolumns",
			"m_numrows",
			"m_parsecommadelimited",
			"m_responsekeys",
			"m_responseparam",
			"m_returnstatus",
			"m_setblocking",
			"m_setdropfile",
			"m_setip",
			"m_setssl",
			"m_setssl_cafile",
			"m_setssl_files",
			"m_settimeout",
			"m_sslcert_gen_hash",
			"m_transactionssent",
			"m_transinqueue",
			"m_transkeyval",
			"m_transnew",
			"m_transsend",
			"m_uwait",
			"m_validateidentifier",
			"m_verifyconnection",
			"m_verifysslcert",
			"magic_quotes_runtime",
			"mail",
			"mailparse_determine_best_xfer_encoding",
			"mailparse_msg_create",
			"mailparse_msg_extract_part",
			"mailparse_msg_extract_part_file",
			"mailparse_msg_extract_whole_part_file",
			"mailparse_msg_free",
			"mailparse_msg_get_part",
			"mailparse_msg_get_part_data",
			"mailparse_msg_get_structure",
			"mailparse_msg_parse",
			"mailparse_msg_parse_file",
			"mailparse_rfc822_parse_addresses",
			"mailparse_stream_encode",
			"mailparse_uudecode_all",
			"main",
			"max",

			"mb_check_encoding",
			"mb_convert_case",
			"mb_convert_encoding",
			"mb_convert_kana",
			"mb_convert_variables",
			"mb_decode_mimeheader",
			"mb_decode_numericentity",
			"mb_detect_encoding",
			"mb_detect_order",
			"mb_encode_mimeheader",
			"mb_encode_numericentity",
			"mb_ereg",
			"mb_ereg_match",
			"mb_ereg_replace",
			"mb_ereg_search",
			"mb_ereg_search_getpos",
			"mb_ereg_search_getregs",
			"mb_ereg_search_init",
			"mb_ereg_search_pos",
			"mb_ereg_search_regs",
			"mb_ereg_search_setpos",
			"mb_eregi",
			"mb_eregi_replace",
			"mb_get_info",
			"mb_http_input",
			"mb_http_output",
			"mb_internal_encoding",
			"mb_language",
			"mb_list_encodings",
			"mb_output_handler",
			"mb_parse_str",
			"mb_preferred_mime_name",
			"mb_regex_encoding",
			"mb_regex_set_options",
			"mb_send_mail",
			"mb_split",
			"mb_strcut",
			"mb_strimwidth",
			"mb_stripos",
			"mb_stristr",
			"mb_strlen",
			"mb_strpos",
			"mb_strrchr",
			"mb_strrichr",
			"mb_strripos",
			"mb_strrpos",
			"mb_strstr",
			"mb_strtolower",
			"mb_strtoupper",
			"mb_strwidth",
			"mb_substitute_character",
			"mb_substr",
			"mb_substr_count",
			"mcrypt_cbc",
			"mcrypt_cfb",
			"mcrypt_create_iv",
			"mcrypt_decrypt",
			"mcrypt_ecb",
			"mcrypt_enc_get_algorithms_name",
			"mcrypt_enc_get_block_size",
			"mcrypt_enc_get_iv_size",
			"mcrypt_enc_get_key_size",
			"mcrypt_enc_get_modes_name",
			"mcrypt_enc_get_supported_key_sizes",
			"mcrypt_enc_is_block_algorithm",
			"mcrypt_enc_is_block_algorithm_mode",
			"mcrypt_enc_is_block_mode",
			"mcrypt_enc_self_test",
			"mcrypt_encrypt",
			"mcrypt_generic",
			"mcrypt_generic_deinit",
			"mcrypt_generic_end",
			"mcrypt_generic_init",
			"mcrypt_get_block_size",
			"mcrypt_get_cipher_name",
			"mcrypt_get_iv_size",
			"mcrypt_get_key_size",
			"mcrypt_list_algorithms",
			"mcrypt_list_modes",
			"mcrypt_module_close",
			"mcrypt_module_get_algo_block_size",
			"mcrypt_module_get_algo_key_size",
			"mcrypt_module_get_supported_key_sizes",
			"mcrypt_module_is_block_algorithm",
			"mcrypt_module_is_block_algorithm_mode",
			"mcrypt_module_is_block_mode",
			"mcrypt_module_open",
			"mcrypt_module_self_test",
			"mcrypt_ofb",
			"md5",
			"md5_file",
			"mdecrypt_generic",
			"memcache_add",
			"memcache_addserver",
			"memcache_close",
			"memcache_connect",
			"memcache_debug",
			"memcache_decrement",
			"memcache_delete",
			"memcache_flush",
			"memcache_get",
			"memcache_getextendedstats",
			"memcache_getserverstatus",
			"memcache_getstats",
			"memcache_getversion",
			"memcache_increment",
			"memcache_pconnect",
			"memcache_replace",
			"memcache_set",
			"memcache_setcompressthreshold",
			"memcache_setserverparams",
			"memcached",
			"memory_get_peak_usage",
			"memory_get_usage",
			"messageformatter",
			"metaphone",
			"method_exists",
			"mhash",
			"mhash_count",
			"mhash_get_block_size",
			"mhash_get_hash_name",
			"mhash_keygen_s2k",
			"microtime",
			"mime_content_type",
			"min",
			"ming_keypress",
			"ming_setcubicthreshold",
			"ming_setscale",
			"ming_setswfcompression",
			"ming_useconstants",
			"ming_useswfversion",
			"mkdir",
			"mktime",
			"money_format",
			"mongo",
			"mongobindata",
			"mongocode",
			"mongocollection",
			"mongocursor",
			"mongodate",
			"mongodb",
			"mongodbref",
			"mongogridfs",
			"mongogridfscursor",
			"mongogridfsfile",
			"mongoid",
			"mongoregex",
			"move_uploaded_file",
			"mpegfile",
			"mqseries_back",
			"mqseries_begin",
			"mqseries_close",
			"mqseries_cmit",
			"mqseries_conn",
			"mqseries_connx",
			"mqseries_disc",
			"mqseries_get",
			"mqseries_inq",
			"mqseries_open",
			"mqseries_put",
			"mqseries_put1",
			"mqseries_set",
			"mqseries_strerror",
			"msession_connect",
			"msession_count",
			"msession_create",
			"msession_destroy",
			"msession_disconnect",
			"msession_find",
			"msession_get",
			"msession_get_array",
			"msession_get_data",
			"msession_inc",
			"msession_list",
			"msession_listvar",
			"msession_lock",
			"msession_plugin",
			"msession_randstr",
			"msession_set",
			"msession_set_array",
			"msession_set_data",
			"msession_timeout",
			"msession_uniq",
			"msession_unlock",
			"msg_get_queue",
			"msg_queue_exists",
			"msg_receive",
			"msg_remove_queue",
			"msg_send",
			"msg_set_queue",
			"msg_stat_queue",
			"msql",
			"msql_affected_rows",
			"msql_close",
			"msql_connect",
			"msql_create_db",
			"msql_createdb",
			"msql_data_seek",
			"msql_db_query",
			"msql_dbname",
			"msql_drop_db",
			"msql_error",
			"msql_fetch_array",
			"msql_fetch_field",
			"msql_fetch_object",
			"msql_fetch_row",
			"msql_field_flags",
			"msql_field_len",
			"msql_field_name",
			"msql_field_seek",
			"msql_field_table",
			"msql_field_type",
			"msql_fieldflags",
			"msql_fieldlen",
			"msql_fieldname",
			"msql_fieldtable",
			"msql_fieldtype",
			"msql_free_result",
			"msql_list_dbs",
			"msql_list_fields",
			"msql_list_tables",
			"msql_num_fields",
			"msql_num_rows",
			"msql_numfields",
			"msql_numrows",
			"msql_pconnect",
			"msql_query",
			"msql_regcase",
			"msql_result",
			"msql_select_db",
			"msql_tablename",
			"mssql_bind",
			"mssql_close",
			"mssql_connect",
			"mssql_data_seek",
			"mssql_execute",
			"mssql_fetch_array",
			"mssql_fetch_assoc",
			"mssql_fetch_batch",
			"mssql_fetch_field",
			"mssql_fetch_object",
			"mssql_fetch_row",
			"mssql_field_length",
			"mssql_field_name",
			"mssql_field_seek",
			"mssql_field_type",
			"mssql_free_result",
			"mssql_free_statement",
			"mssql_get_last_message",
			"mssql_guid_string",
			"mssql_init",
			"mssql_min_error_severity",
			"mssql_min_message_severity",
			"mssql_next_result",
			"mssql_num_fields",
			"mssql_num_rows",
			"mssql_pconnect",
			"mssql_query",
			"mssql_result",
			"mssql_rows_affected",
			"mssql_select_db",
			"mt_getrandmax",
			"mt_rand",
			"mt_srand",
			"multipleiterator",
			"mysql_affected_rows",
			"mysql_change_user",
			"mysql_client_encoding",
			"mysql_close",
			"mysql_connect",
			"mysql_create_db",
			"mysql_data_seek",
			"mysql_db_name",
			"mysql_db_query",
			"mysql_drop_db",
			"mysql_errno",
			"mysql_error",
			"mysql_escape_string",
			"mysql_fetch_array",
			"mysql_fetch_assoc",
			"mysql_fetch_field",
			"mysql_fetch_lengths",
			"mysql_fetch_object",
			"mysql_fetch_row",
			"mysql_field_flags",
			"mysql_field_len",
			"mysql_field_name",
			"mysql_field_seek",
			"mysql_field_table",
			"mysql_field_type",
			"mysql_free_result",
			"mysql_get_client_info",
			"mysql_get_host_info",
			"mysql_get_proto_info",
			"mysql_get_server_info",
			"mysql_info",
			"mysql_insert_id",
			"mysql_list_dbs",
			"mysql_list_fields",
			"mysql_list_processes",
			"mysql_list_tables",
			"mysql_num_fields",
			"mysql_num_rows",
			"mysql_pconnect",
			"mysql_ping",
			"mysql_query",
			"mysql_real_escape_string",
			"mysql_result",
			"mysql_select_db",
			"mysql_set_charset",
			"mysql_stat",
			"mysql_tablename",
			"mysql_thread_id",
			"mysql_unbuffered_query",
			"mysqli",
			"mysqli_bind_param",
			"mysqli_bind_result",
			"mysqli_client_encoding",
			"mysqli_disable_reads_from_master",
			"mysqli_disable_rpl_parse",
			"mysqli_driver",
			"mysqli_enable_reads_from_master",
			"mysqli_enable_rpl_parse",
			"mysqli_escape_string",
			"mysqli_execute",
			"mysqli_fetch",
			"mysqli_get_metadata",
			"mysqli_master_query",
			"mysqli_param_count",
			"mysqli_report",
			"mysqli_result",
			"mysqli_rpl_parse_enabled",
			"mysqli_rpl_probe",
			"mysqli_rpl_query_type",
			"mysqli_send_long_data",
			"mysqli_send_query",
			"mysqli_set_opt",
			"mysqli_slave_query",
			"mysqli_stmt",
			"natcasesort",
			"natsort",

			"next",
			"ngettext",
			"nl2br",
			"nl_langinfo",
			"normalizer",

			"nsapi_request_headers",
			"nsapi_response_headers",
			"nsapi_virtual",
			"nthmac",
			"number_format",
			"numberformatter",
			"oauth",
			"oauth_get_sbs",
			"oauth_urlencode",
			"oauthexception",
			"ob_clean",
			"ob_deflatehandler",
			"ob_end_clean",
			"ob_end_flush",
			"ob_etaghandler",
			"ob_flush",
			"ob_get_clean",
			"ob_get_contents",
			"ob_get_flush",
			"ob_get_length",
			"ob_get_level",
			"ob_get_status",
			"ob_gzhandler",
			"ob_iconv_handler",
			"ob_implicit_flush",
			"ob_inflatehandler",
			"ob_list_handlers",
			"ob_start",
			"ob_tidyhandler",

			"ord",
			"outofboundsexception",
			"outofrangeexception",
			"output_add_rewrite_var",
			"output_reset_rewrite_vars",
			"overflowexception",
			"overload",
			"override_function",

			"pack",
			"parentiterator",
			"parse_ini_file",
			"parse_ini_string",
			"parse_str",
			"parse_url",
			"parsekit_compile_file",
			"parsekit_compile_string",
			"parsekit_func_arginfo",
			"passthru",
			"pathinfo",
			"pclose",

			"pdostatement",
			"pfsockopen",

			"php_check_syntax",
			"php_ini_loaded_file",
			"php_ini_scanned_files",
			"php_logo_guid",
			"php_sapi_name",
			"php_strip_whitespace",
			"php_uname",
			"phpcredits",
			"phpinfo",
			"phpversion",
			"pi",
			"png2wbmp",
			"popen",
			"pos",

			"pow",
			"preg_filter",
			"preg_grep",
			"preg_last_error",
			"preg_match",
			"preg_match_all",
			"preg_quote",
			"preg_replace",
			"preg_replace_callback",
			"preg_split",
			"prev",
			"print",
			"print_r",

			"printf",
			"proc_close",
			"proc_get_status",
			"proc_nice",
			"proc_open",
			"proc_terminate",
			"property_exists",

			"putenv",

			"qdom_error",
			"qdom_tree",
			"quoted_printable_decode",
			"quoted_printable_encode",
			"quotemeta",
			"rad2deg",

			"rand",
			"range",
			"rangeexception",
			"rar_close",
			"rar_entry_get",
			"rar_extract",
			"rar_getattr",
			"rar_getcrc",
			"rar_getfiletime",
			"rar_gethostos",
			"rar_getmethod",
			"rar_getname",
			"rar_getpackedsize",
			"rar_getunpackedsize",
			"rar_getversion",
			"rar_list",
			"rar_open",
			"rawurldecode",
			"rawurlencode",
			"read_exif_data",
			"readdir",
			"readfile",
			"readgzfile",
			"readline",

			"readline_write_history",
			"readlink",
			"realpath",
			"recode",
			"recode_file",
			"recode_string",
			"recursivecachingiterator",
			"recursivedirectoryiterator",
			"recursiveiteratoriterator",
			"register_shutdown_function",
			"register_tick_function",
			"rename",
			"rename_function",
			"require",
			"require_once",
			"reset",
			"resetValue",
			"restore_error_handler",
			"restore_exception_handler",
			"restore_include_path",
			"return",
			"rewind",
			"rewinddir",
			"rmdir",
			"round",
			"rpm_close",
			"rpm_get_tag",
			"rpm_is_valid",
			"rpm_open",
			"rpm_version",
			"rsort",
			"rtrim",

			"sammessage_body",
			"sammessage_constructor",
			"sammessage_header",
			"sca_createdataobject",
			"sca_getservice",
			"sca_localproxy_createdataobject",
			"sca_soapproxy_createdataobject",
			"scandir",

			"seekableiterator",
			"sem_acquire",
			"sem_get",
			"sem_release",
			"sem_remove",
			"serializable",
			"serialize",
			"session_cache_expire",
			"session_cache_limiter",
			"session_commit",
			"session_decode",
			"session_destroy",
			"session_encode",
			"session_get_cookie_params",
			"session_id",
			"session_is_registered",
			"session_module_name",
			"session_name",
			"session_pgsql_add_error",
			"session_pgsql_get_error",
			"session_pgsql_get_field",
			"session_pgsql_reset",
			"session_pgsql_set_field",
			"session_pgsql_status",
			"session_regenerate_id",
			"session_register",
			"session_save_path",
			"session_set_cookie_params",
			"session_set_save_handler",
			"session_start",
			"session_unregister",
			"session_unset",
			"session_write_close",
			"setCounterClass",
			"set_error_handler",
			"set_exception_handler",
			"set_file_buffer",
			"set_include_path",
			"set_magic_quotes_runtime",
			"set_socket_blocking",
			"set_time_limit",
			"setcookie",
			"setlocale",
			"setrawcookie",
			"settype",
			"sha1",
			"sha1_file",
			"shell_exec",
			"shm_attach",
			"shm_detach",
			"shm_get_var",
			"shm_has_var",
			"shm_put_var",
			"shm_remove",
			"shm_remove_var",
			"shmop_close",
			"shmop_delete",
			"shmop_open",
			"shmop_read",
			"shmop_size",
			"shmop_write",
			"show_source",
			"shuffle",
			"signeurlpaiement",

			"sin",
			"sinh",
			"sizeof",
			"sleep",

			"snmpget",
			"snmpgetnext",
			"snmprealwalk",
			"snmpset",
			"snmpwalk",
			"snmpwalkoid",
			"soapclient",
			"soapfault",
			"soapheader",
			"soapparam",
			"soapserver",
			"soapvar",
			"socket_accept",
			"socket_bind",
			"socket_clear_error",
			"socket_close",
			"socket_connect",
			"socket_create",
			"socket_create_listen",
			"socket_create_pair",
			"socket_get_option",
			"socket_get_status",
			"socket_getpeername",
			"socket_getsockname",
			"socket_last_error",
			"socket_listen",
			"socket_read",
			"socket_recv",
			"socket_recvfrom",
			"socket_select",
			"socket_send",
			"socket_sendto",
			"socket_set_block",
			"socket_set_blocking",
			"socket_set_nonblock",
			"socket_set_option",
			"socket_set_timeout",
			"socket_shutdown",
			"socket_strerror",
			"socket_write",
			"sort",
			"soundex",
			"sphinxclient",
			"spl_autoload",
			"spl_autoload_call",
			"spl_autoload_extensions",
			"spl_autoload_functions",
			"spl_autoload_register",
			"spl_autoload_unregister",
			"spl_classes",
			"spl_object_hash",
			"splbool",
			"spldoublylinkedlist",
			"splenum",
			"splfileinfo",
			"splfixedarray",
			"splfloat",
			"splheap",
			"splint",
			"split",
			"spliti",
			"splmaxheap",
			"splminheap",
			"splobjectstorage",
			"splpriorityqueue",
			"splqueue",
			"splstack",
			"splstring",
			"sprintf",
			"sql_regcase",

			"sqrt",
			"srand",
			"sscanf",

			"stat",

			"str_getcsv",
			"str_ireplace",
			"str_pad",
			"str_repeat",
			"str_replace",
			"str_rot13",
			"str_shuffle",
			"str_split",
			"str_word_count",
			"strcasecmp",
			"strchr",
			"strcmp",
			"strcoll",
			"strcspn",

			"streamwrapper",
			"strftime",
			"strip_tags",
			"stripcslashes",
			"stripos",
			"stripslashes",
			"stristr",
			"strlen",
			"strnatcasecmp",
			"strnatcmp",
			"strncasecmp",
			"strncmp",
			"strpbrk",
			"strpos",
			"strptime",
			"strrchr",
			"strrev",
			"strripos",
			"strrpos",
			"strspn",
			"strstr",
			"strtok",
			"strtolower",
			"strtotime",
			"strtoupper",
			"strtr",
			"strval",
			"substr",
			"substr_compare",
			"substr_count",
			"substr_replace",
			"symlink",
			"sys_get_temp_dir",
			"sys_getloadavg",
			"syslog",
			"system",
			"tag",
			"tan",
			"tanh",
			"tcpwrap_check",
			"tempnam",
			"textdomain",
			"tidy",
			"time",
			"time_nanosleep",
			"time_sleep_until",
			"timezone_abbreviations_list",
			"timezone_identifiers_list",
			"timezone_location_get",
			"timezone_name_from_abbr",
			"timezone_name_get",
			"timezone_offset_get",
			"timezone_open",
			"timezone_transitions_get",
			"timezone_version_get",
			"tmpfile",
			"token_get_all",
			"token_name",
			"touch",
			"traversable",
			"trigger_error",
			"trim",
			"uasort",
			"ucfirst",
			"ucwords",
			"uksort",
			"umask",
			"underflowexception",
			"unexpectedvalueexception",
			"unicode_decode",
			"unicode_encode",
			"unicode_get_error_mode",
			"unicode_get_subst_char",
			"unicode_set_error_mode",
			"unicode_set_subst_char",
			"uniqid",
			"unixtojd",
			"unlink",
			"unpack",
			"unregister_tick_function",
			"unserialize",
			"unset",
			"urldecode",
			"urlencode",
			"use_soap_error_handler",
			"user_error",
			"usleep",
			"usort",
			"utf8_decode",
			"utf8_encode",
			"var_dump",
			"var_export",
			"variant",
			"variant_abs",
			"variant_add",
			"variant_and",
			"variant_cast",
			"variant_cat",
			"variant_cmp",
			"variant_date_from_timestamp",
			"variant_date_to_timestamp",
			"variant_div",
			"variant_eqv",
			"variant_fix",
			"variant_get_type",
			"variant_idiv",
			"variant_imp",
			"variant_int",
			"variant_mod",
			"variant_mul",
			"variant_neg",
			"variant_not",
			"variant_or",
			"variant_pow",
			"variant_round",
			"variant_set",
			"variant_set_type",
			"variant_sub",
			"variant_xor",
			"version_compare",
			"vfprintf",
			"virtual",
			"vprintf",
			"vsprintf",
			"wordwrap",

			
		);
		foreach ($phpfunc as $k) {
			$output = preg_replace('/\b' . $k . '\b/i', "<font color=green><b><a target=_blank href=http://jp.php.net/manual-lookup.php?pattern=$k>$k</a></b></font>", $output);
		}
		echo $output;
		exit;
	}
	
	function google(){	
		if(f('google')){			
			$this->fmodel("google")->save(array('word'=>f('google')));
			$this->jump("http://www.google.com/search?hl=zh-CN&q=".urlencode(f('google')).'&lr=');
			exit;
		}else{
			echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';
			echo "<center><br><br><br><br><img src=http://www.google.com/intl/zh-CN_ALL/images/logo.gif><br>";
			echo "<form><input type=text size=100 name=google value='".f('google')."'>&nbsp;<br>&nbsp;<a href=/filecms/google target=_blank>History</a></form>";
			echo "</center>";
		}
		exit;
	}
	
	function getjs(){
		//exit;
		$raname=$this->fmodel('js')->peek_col(array(),'name');
		echo '' .
			'var s=document.createElement("scr"+"ipt");' .
			'var d=new Date();' .
			'var name=prompt("name('.join(',',$raname).')","'.get_cookie('getjsname').'");' .
			's.charset="UTF-8";' .
			's.language="javascr"+"ipt";' .
			's.type="text/javascr"+"ipt";' .
			's.src="http://'.$this->config['site']['wx'].'/admin/getjs2/"+name+"?d="+d.getMilliseconds();' .
			'document.body.appendChild(s);';
		
		exit;
	}
	
	function getjs2($params){
		$db=$this->fmodel('js');
		$record=$db->peek(array('name'=>$params[0]));
		if($record&&$params[0]){
			set_cookie('getjsname',$params[0]);		
			echo $record['src'];
			echo 'var now=new Date();document.title=now.getHours()+":"+now.getMinutes()+":"+now.getSeconds()+" over";';			
		}else{
			echo 'alert("no script found")';
		}		
		exit;
	}
	
	function rss(){
		$filename=ROOT."../fr/data/selfwiki-rssurllist";
		$content=p("rss");
		if($content && $this->is_post()){
			
			if (!$handle = fopen($filename, 'w')) {
		         echo "Cannot open file ($filename)";
		         exit;
		    }
		
		    // Write $somecontent to our opened file.
		    if (fwrite($handle, $content) === FALSE) {
		        echo "Cannot write to file ($filename)";
		        exit;
		    }
		    fclose($handle);
		}
		echo $this->htmlheader();

		
		$content=file_get_contents($filename);

		echo "<form method=POST><textarea rows=10 cols=100 name=rss>",e($content),"</textarea><br><input type=submit></form>";
		echo $this->htmlfooter();
		exit;
	}

}
?>