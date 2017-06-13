<?php
class application extends controller {

	function __construct() {
		parent :: __construct();
	}

	function user_login() {
		if ($_SESSION["login"]!=1) {
			$this->to_path("/quick/login");
		}
	}
	
	function getParentUpdate($url){
		return 	"<script language=javascript> 
						setTimeout(\"parent.location.href='$url';\",0) 
						</script>";
	}
	
	function getIP(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	function kdmail($f) {
		$this->load('lib/phpmailer/class.phpmailer');
		$mail = new PHPMailer();
		//$body             = $mail->getFile(ROOT.'index.php');
		//$body             = eregi_replace("[\]",'',$body);
		$mail->IsSendmail(); // telling the class to use SendMail transport
		$mail->From = $f["from"];
		$mail->FromName = either($f["fromname"], "noticer");
		$mail->Subject = either($f["subject"], "hello");
		//$mail->AltBody = either($f["altbody"], "To view the message, please use an HTML compatible email viewer!"); // optional, comment out and test
		$mail->AltBody = either($f["msg"], "To view the message, please use an HTML compatible email viewer!"); // optional, comment out and test
		if ($f["embedimg"]) {
			foreach ($f["embedimg"] as $i) {
				//$mail->AddEmbeddedImage(ROOT."public/images/logo7.png","logo","logo7.png");
				$mail->AddEmbeddedImage($i[0], $i[1], $i[2]);
			}
		}
		if ($f["msgfile"]) {
			$body = $mail->getFile($f["msgfile"]);
			$body = eregi_replace("[\]", '', $body);
			if($f["type"]=="text"){
				$mail->IsHTML(false);    		
			    $mail->Body=$body;
			}else{
				$mail->MsgHTML($body); //."<br><img src= \"cid:logo\">");
			}
		} else {
			if($f["type"]=="text"){
				$mail->IsHTML(false);    		
				$mail->Body=$f["msg"];
			}else{
				$mail->MsgHTML($f["msg"]); //."<br><img src= \"cid:logo\">");
			}		
		}
		if (preg_match('/\,/', $f["to"])) {
			$emails = explode(",", $f["to"]);
			foreach ($emails as $i) {
				$mail->AddAddress($i, $f["toname"]);
			}
		} else {
			$mail->AddAddress($f["to"], $f["toname"]);
		}
		$mail->AddBCC($this->config["site"]["mail"], "bcc");
		if ($f["files"]) {
			foreach ($f["files"] as $i) {
				$mail->AddAttachment($i); // attachment
			}
		}

		if (!$mail->Send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "Message sent!";
		}
	}

	function do404() {
		header("HTTP/1.0 404 Not Found");
		if (true or !file_exists(ROOT . "../perl/setting.ini")) {
			$this->sf("_share/404");
			$this->sv('error_trace', debug_backtrace());
		} else {
			$this->sf("_share/404user");
			print "friendly alert";
		}
	}

	function default_func($params) {
		$a = array ();
		foreach ($params as $i) {
			$a[] = get_w($i);
		}
		if (file_exists(ROOT . $this->ctl . "/" . join("/", $a))) {
			$this->sf($this->ctl . "/" . join("/", $a));
		} else {
			//return new ControlUnit("redirect_action",array("quick","blog",$params));
		}
	}

	function get_client_info() {
		return "\n\n---from---\n" . $_SERVER[REMOTE_ADDR] . ":" . $_SERVER[REMOTE_PORT] . "\n" . $_SERVER[HTTP_USER_AGENT] . "\n";
	}

	function is_post() {
		return $_SERVER["REQUEST_METHOD"] == "POST";
	}

	function cpa($name, $pass = "yaoming") {
		$loginname = "login_$name";
		if (!$_SESSION[$loginname] && f('passadmin') != $pass) {
			$htmlsrc = "<h2>Pass Check</h2>
								please input password<br>
								<form method=POST>" .
			"<input type=password name=passadmin>" .
			"<input type=submit>" .
			"</form>";
			echo $htmlsrc;
			exit;
		} else {
			$_SESSION[$loginname] = 1;
		}
	}

	protected function get_url_pic($url, $file) {
		$browser = new COM("InternetExplorer.Application");
		$handle = $browser->HWND;

		$browser->Visible = true;
		$browser->FullScreen = true;
		$browser->Navigate($url);

		/* Is it completely loaded? (be aware of frames!)*/
		while ($browser->Busy) {
			com_message_pump(4000);
		}
		$im = imagegrabwindow($handle, 0);
		$browser->Quit();
		imagepng($im, ROOT . $file);
		imagedestroy($im);
	}

	protected function get_url_pic2($url, $file, $scroll = 420) {
		$browser = new COM("InternetExplorer.Application");
		$handle = $browser->HWND;
		$browser->Visible = true;
		$browser->Width = 2900;
		$browser->Height = 9780;
		$browser->Left = 2780;
		$browser->Top = 2780;
		$browser->menubar = 0;
		$browser->AddressBar = 0;
		$browser->StatusBar = 0;
		$browser->Navigate($url);
		$browser->ToolBar = 0;

		/* Still working? */
		while ($browser->Busy) {
			com_message_pump(4000);
		}

		$browser->document->parentWindow->scrollTo(0, $scroll);

		$im = imagegrabwindow($handle, 0);
		$browser->Quit();
		imagepng($im, ROOT . $file);
		imagedestroy($im);
	}

	protected function downloadfile($url, $file = null) {
		if (!$file) {
			$file = preg_replace('/^.*\//i', '', $url);
			$file = preg_replace('/\?.*$/i', '', $file);
		}
		$handle = fopen(ROOT . "data\\other\\$file", 'w');
		fwrite($handle, file_get_contents($url));
		fclose($handle);

	}

	protected function outXML($ra) {
		header("Content-type: text/xml");

		$xml_output = "<?xml version=\"1.0\"?>\n";
		$xml_output .= "<entities>\n";

		foreach ($ra as $one) {
			$xml_output .= "  <entity>\n";
			$xml_output .= "    <date>" . $row['date'] . "</date>\n";

			foreach ($one as $i => $j) {
				$xml_output .= "    <$i>" . trucate(e($j), 5000) . "</$i>\n";
			}

			$xml_output .= "  </entity>\n";
		}

		$xml_output .= "</entities>";

		echo $xml_output;
		exit;
	}

	protected function outPDFTABLE($ra) {
		$xml_output = "";
		foreach ($ra as $one) {
			$xml_output .= "";
			foreach ($one as $i => $j) {
				$xml_output .= "";
				if ($j) {
					$xml_output .= "<h4>$i</h4>" . trucate(e($j), 50);
				} else {
					$xml_output .= "<h4>$i</h4> : -";
				}
				$xml_output .= "";
			}
			$xml_output .= "";
		}

		$xml_output .= "";
		//echo $xml_output;exit;
		$this->html2fpdf($xml_output);
		exit;
	}

	protected function url2strP($url) {
		ini_set('user_agent', $this->getUserAgent());
		$proxy_name = '203.160.001.112';
		$proxy_port = 80;
		$proxy_cont = '';

		$proxy_fp = fsockopen($proxy_name, $proxy_port);
		if (!$proxy_fp) {
			echo "caionimasivbai";exit;
			return false;
		}
		fputs($proxy_fp, "GET $proxy_url HTTP/1.0\r\nHost: $proxy_name\r\n\r\n");
		while (!feof($proxy_fp)) {
			$proxy_cont .= fread($proxy_fp, 4096);
		}
		fclose($proxy_fp);
		$proxy_cont = substr($proxy_cont, strpos($proxy_cont, "\r\n\r\n") + 4);
		return $proxy_cont;
	}

	protected function url2str($url, $return) {
		/*$cache=cacheme($url);
		if($cache){
			return $cache;
		}*/
		ini_set('user_agent', $this->getUserAgent());
		//ini_set('Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/530.5 (KHTML, like Gecko) Chrome/2.0.172.31 Safari/530.5');	
		//ini_set('');
		if ($return) {
			if ($fp = fopen($url, "r")) {
			} else {
				return null;
			}
		} else {
			$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
		}
		while ($fc = fread($fp, 8192)) {
			$str .= $fc;
		}
		fclose($fp);
		//echo $url,"<br>";
		return $str;
	}

	protected function getUserAgent() {
		$ua = array (
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 1.1.4322)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/530.5 (KHTML, like Gecko) Chrome/2.0.172.31 Safari/530.5',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; ja; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/XX (KHTML, like Gecko) Safari/YY',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506; OfficeLiveConnector.1.3; OfficeLivePatch.1.3) Sleipnir/2.8.4',
		'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.8.0.6) Gecko/20060729 SeaMonkey/1.0.4',
			'Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.8.0.6) Gecko/20060729 SeaMonkey/1.0.4',
			'Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.0.5) Gecko/20060805 CentOS/1.0.3-0.el4.1.centos4 SeaMonkey/1.0.3',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en; rv:1.8.0.5) Gecko/20060721 SeaMonkey/1.0.3',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.4) Gecko/20060619 SeaMonkey/1.0.2',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.4) Gecko/20060516 SeaMonkey/1.0.2',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.2) Gecko/20060630 Red Hat/1.0.1-0.1.9.EL3 SeaMonkey/1.0.1',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.2) Gecko/20060404 SeaMonkey/1.0.1',
			'Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.8.0.2) Gecko/20060404 SeaMonkey/1.0.1',
			'Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.1) Gecko/20060316 SUSE/1.0-27 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Win 9x 4.90; en-US; rv:1.8.0.1) Gecko/20060130 SeaMonkey/1.0',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.8) Gecko/20071008 SeaMonkey',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; ja-jp) AppleWebKit/419 (KHTML, like Gecko) Shiira/1.2.3 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en_CA) AppleWebKit/522+ (KHTML, like Gecko) Shiira/1.2.3 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/419 (KHTML, like Gecko) Shiira/1.2.3 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/522.10.1 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/419 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/418.9 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/312.8 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.9.1 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.9 (KHTML, like Gecko) Shiira/1.2.2 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; pl-pl) AppleWebKit/312.8 (KHTML, like Gecko) Shiira/1.2.1 Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/417.9 (KHTML, like Gecko, Safari) Shiira/1.1',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/523.15.1 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/419 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/522.11.1 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/522.10.1 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/419.3 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/419.2.1 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/419 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; fr) AppleWebKit/418.9.1 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-au) AppleWebKit/523.10.3 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/419 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; en) AppleWebKit/528.16 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; en) AppleWebKit/525.18 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; en) AppleWebKit/525.13 (KHTML, like Gecko) Shiira Safari/125',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b5pre) Gecko/20090424 Shiretoko/3.5b5pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b5pre) Gecko/20090519 Shiretoko/3.5b5pre',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b4pre) Gecko/20090404 Shiretoko/3.5b4pre',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b4pre) Gecko/20090401 Ubuntu/9.04 (jaunty) Shiretoko/3.5b4pre',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b4pre) Gecko/20090405 Shiretoko/3.5b4pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1b4pre) Gecko/20090420 Shiretoko/3.5b4pre (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b4pre) Gecko/20090413 Shiretoko/3.5b4pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b4pre) Gecko/20090411 Shiretoko/3.5b4pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b4pre) Gecko/20090323 Shiretoko/3.5b4pre (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b4pre) Gecko/20090311 Ubuntu/9.04 (jaunty) Shiretoko/3.1b4pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b4pre) Gecko/20090311 Shiretoko/3.1b4pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b4pre) Gecko/20090307 Shiretoko/3.1b4pre (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-TW; rv:1.9.1b4pre) Gecko/20090308 Shiretoko/3.1b4pre (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; bg-BG; rv:1.9.1b4pre) Gecko/20090307 Shiretoko/3.1b4pre',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b3pre) Gecko/20090109 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b3pre) Gecko/20081223 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1b3pre) Gecko/20081222 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b3pre) Gecko/20090106 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b3pre) Gecko/20090105 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1b3pre) Gecko/20081203 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.1; pt-BR; rv:1.9.1b3pre) Gecko/20090103 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b3pre) Gecko/20081207 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1b3pre) Gecko/20081204 Shiretoko/3.1b3pre (.NET CLR 3.5.30729)',
			'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.9.1b3pre) Gecko/20090105 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.9.1b3pre) Gecko/20090104 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9.1b3pre) Gecko/20090205 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20090207 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20090121 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20090113 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20090102 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20081228 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20081221 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20081218 Shiretoko/3.1b3pre',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1b3pre) Gecko/20081212 Shiretoko/3.1b3pre',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506; OfficeLiveConnector.1.3; OfficeLivePatch.1.3) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0; MathPlayer 2.10d; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; OfficeLiveConnector.1.3; OfficeLivePatch.1.3; .NET CLR 3.5.30729; .NET CLR 3.0.30618; .NET CLR 1.1.4322) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; WOW64; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1); .NET CLR 2.0.50727; .NET CLR 1.1.4322) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1); .NET CLR 1.0.3705; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; FDM) Sleipnir/2.8.4',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729) Sleipnir/2.8.3',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Sleipnir/2.8.1',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0) Sleipnir/2.8.1',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; GTB5; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.8.0',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.04506.648) Sleipnir/2.8.0',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.8.0',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0) Sleipnir/2.7.2',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.7.2',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30) Sleipnir/2.7.1',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 2.0.50727; InfoPath.1; .NET CLR 3.0.04506.30; .NET CLR 3.0.04506.648) Sleipnir/2.7.0',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506) Sleipnir/2.6.1',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30) Sleipnir/2.6.0',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.6.0',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506; InfoPath.1) Sleipnir/2.5.17',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) Sleipnir/2.5.12',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0) Sleipnir/2.49',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.48',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322) Sleipnir/2.48',
			'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727) Sleipnir/2.41',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; Media Center PC 3.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322) Sleipnir/2.30',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) Sleipnir/2.30',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1) Sleipnir/2.21',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322) Sleipnir/2.21',
			'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Sleipnir 2.8.4)',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; en-us) AppleWebKit/528.16 (KHTML, like Gecko) Stainless/0.5.3 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; es-es) AppleWebKit/525.27.1 (KHTML, like Gecko) Stainless/0.4.5 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; zh-tw) AppleWebKit/525.27.1 (KHTML, like Gecko) Stainless/0.4.5 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; en-us) AppleWebKit/525.27.1 (KHTML, like Gecko) Stainless/0.4.5 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; zh-tw) AppleWebKit/525.27.1 (KHTML, like Gecko) Stainless/0.4 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; en-us) AppleWebKit/525.27.1 (KHTML, like Gecko) Stainless/0.4 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; en-us) AppleWebKit/528.1 (KHTML, like Gecko) Stainless/0.3.5 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; zh-tw) AppleWebKit/525.18 (KHTML, like Gecko) Stainless/0.3 Safari/525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_4; en-us) AppleWebKit/528.1 (KHTML, like Gecko) Version/4.0 Safari/528.1 Stainless/0.1',
			'Mozilla/6.0 (X11; U; Linux x86_64; en-US; rv:2.9.0.3) Gecko/2009022510 FreeBSD/ Sunrise/4.0.1/like Safari',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_5; ja-jp) AppleWebKit/525.18 (KHTML, like Gecko) Sunrise/1.7.5 like Safari/5525.20.1',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_4_11; en) AppleWebKit/525.18 (KHTML, like Gecko) Sunrise/1.7.4 like Safari/4525.22',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_2; en-us) AppleWebKit/525.18 (KHTML, like Gecko) Sunrise/1.7.1 like Safari/5525.18',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.9.1 (KHTML, like Gecko) Sunrise/1.6.5 like Safari/419.3',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; fr) AppleWebKit/523.12.2 (KHTML, like Gecko) Sunrise/1.6.0 like Safari/523.12.2',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/125.5.7 (KHTML, like Gecko) SunriseBrowser/0.895',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/125.5.7 (KHTML, like Gecko) SunriseBrowser/0.853',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/125.5.7 (KHTML, like Gecko) SunriseBrowser/0.84',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/125.5.7 (KHTML, like Gecko) SunriseBrowser/0.833',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.9.1 (KHTML, like Gecko) Safari/419.3 TeaShark/0.8',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9pre) Gecko/2008050715 Thunderbird/3.0a1',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070728 Thunderbird/2.0.0.6',
			'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.8.1.4) Gecko/20070622 Thunderbird/2.0.0.4',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.4) Gecko/20070604 Thunderbird/2.0.0.4',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.21) Gecko/20090318 Thunderbird/2.0.0.21',
			'Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.8.1.21) Gecko/20090302 Thunderbird/2.0.0.21',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1.21) Gecko/20090302 Thunderbird/2.0.0.21',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.21) Gecko/20090302 Thunderbird/2.0.0.21',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.21) Gecko/20090302 Thunderbird/2.0.0.21',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.20) Gecko/20081217 Thunderbird/2.0.0.20',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.19) Gecko/20090105 Thunderbird/2.0.0.19',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-GB; rv:1.8.1.17) Gecko/20080914 Thunderbird/2.0.0.17',
			'Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr-FR; rv:1.7.10) Gecko/20050716 Thunderbird/1.0.6',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.6) Gecko/20050317 Thunderbird/1.0.2',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.7.6) Gecko/20050317 Thunderbird/1.0.2',
			'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr-FR; rv:1.7.5) Gecko/20041206 Thunderbird/1.0'
		);
		$rand_keys = array_rand($ua);
		return $ua[$rand_keys];
	}

	protected function url2str2($url) {
		ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 1.1.4322)');
		$url = 'http://wx.mim1314.com/file/webproxy?pass=fsidl734gjdf9230742o423hlfs890&url=' . urlencode($url);
		$fp = fopen($url, "r") or die("Open url: " . $url . " failed.");
		while ($fc = fread($fp, 8192)) {
			$str .= $fc;
		}
		fclose($fp);
		//echo $url,"<br>";
		return $str;
	}

	protected function get_wiki_source($page) {
		if (!$page) {
			return false;
		}
		//$path = ROOT . "../wiki/" . strtoupper(bin2hex($page)) . '.txt';
		$path = ROOT . "../needtobedelete/" . $page;
		return file($path);
	}
	protected function set_wiki_source($page, $content) {
		if (!$page || !$content) {
			return false;
		}
		//$path = ROOT . "../needtobedelete/" . strtoupper(bin2hex($page)) . '.txt';
		$path = ROOT . "../needtobedelete/" . $page;
		$handle = fopen($path, 'w');
		fwrite($handle, $content);
		fclose($handle);
		$this->touch_wiki_source($page);
		return true;
	}
	protected function add_wiki_source($page, $content) {
		if (!$page || !$content) {
			return false;
		}
		$path = ROOT . "../wiki/" . strtoupper(bin2hex($page)) . '.txt';
		$handle = fopen($path, 'a');
		fwrite($handle, $content);
		fclose($handle);
		$this->touch_wiki_source($page);
		return true;
	}
	private function touch_wiki_source($page) {
		$path = ROOT . "../cache/recent.dat";
		$lines = file($path);
		array_unshift($lines, time() . "\t$page\n");
		$handle = fopen($path, 'w');
		fwrite($handle, join('', $lines));
		fclose($handle);
	}

	protected function output_pdf($head, $foot, $data, $encode = "cn2", $length = 10000) {
		View :: output_pdf($head, $foot, $data, $encode, $length);
	}

	protected function html2fpdf($html) {
		View :: html2pdf($html);
	}

	protected function trackinfo($str) {
		$str = preg_replace('/\n/', '[CRLF]', $str);
		$str = str_replace(array (
			'"',
			"'"
		), '', $str);
		$str = preg_replace('/\r/', '', $str);

		return $str;
	}

	protected function exURL($url, $from, $end, $str) {
		if (!$str) {
			$str = $this->url2str2($url);
		}
		$str = $this->trackinfo($str);
		$i = 1;
		$str = preg_replace_callback('/(<div[^>]*>)/i', create_function(
		// single quotes are essential here,
	// or alternative escape all $ as \$
	'$matches', 'global $globalstr;$globalstr++;return "<".md5($matches[1])."_".$globalstr++.">";'), $str);
		$str = str_replace('</div>', '', $str);

		$str = preg_replace_callback('/(<[^>]*>)/i', create_function(
		// single quotes are essential here,
	// or alternative escape all $ as \$
	'$matches', 'global $globalstr;$globalstr++;return "<".md5($matches[1])."_".$globalstr++.">";'), $str);

		if ($from) {
			$str = preg_replace('/.*' . $from . '/i', '', $str);
		}
		if ($end) {
			$str = preg_replace('/' . $end . '.*/i', '', $str);
		}
		return $str;
	}
	
	function ejbCall($method,$params){
		$paramstr="";
		for($i=0; $i<count($params);$i++){
			$paramstr=$paramstr."&p".$i."=".urlencode($params[$i]);
		}
		echo "http://localhost:8080/hpx/service/ejbCall.jsp?m=$method&n=".count($params).$paramstr."<br>";
		$str = $this->url2str("http://localhost:8080/hpx/service/ejbCall.jsp?m=$method&n=".count($params).$paramstr);
		$str= preg_replace('/\r|\n/i','',$str);
		
		return $str;		
	}
	function logme($var){
		$str=var_export($var, true);
		$this->fmodel('log')->save(array('info'=>$str));
	}
	
	function htmlheader($charset="utf-8"){
		return "<html><head>".
		'<meta http-equiv="Content-Type" content="text/html;charset='.$charset.'" />'.
		"</head><body>";
	}
	function htmlfooter(){
		return "</body></html>";
	}

}
?>