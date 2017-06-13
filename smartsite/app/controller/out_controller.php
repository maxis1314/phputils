<?php
class out_controller extends application {
	function filter($method) {
	}
	function authpic() {
		$random = random_str(4, "123456789");
		$_SESSION["authcode"] = $random;
		code2pic($random);
		exit;
	}
	function index() {
		echo "helleo";
		exit;
	}
	function dn($params) {
		$file = $params[0];
		if (md5_check($file,$params[1]) && $file && preg_match('/^[\(\) 0-9a-zA-Z\._\-]+$/', $file) && file_exists(ROOT . "../needtobedelete/$file")) {			
			if (f("force") || $this->is_post()) {
				$this->mail_me('FILE DOWNLOAD', "<br>file downloaded:$file" . $this->get_client_info());
				View :: download($file, "../needtobedelete/$file");
			} else {
				$filesize=sprintf("%.1f",filesize(ROOT . "../needtobedelete/$file")/1024);
				echo "<html><head><title>" . e($file) . " download</title></head><body><div align=center><a href=# onclick=\"document.form1.submit();return false;\"><img border=0 src=/public/image/download.png></a><br><h2>" . e($file) . "($filesize k)</h2><hr><form name=form1 method=POST><input type=submit value=download></form></div></body></html>";
			}
		} else {
			echo "<html><head><title>File not found </title></head><body><div align=center><img border=0 src=/public/image/404.jpg><br>File not found on this server. <br>Maybe it has been deleted by administrator.<br>Any question, contact <a href=/in/x2f/contact/>here</a></div></body></html>";
		}
		exit;
	}
	function del($params) {
		$this->cpa("admin", $this->config["site"]["simplepass"]);

		$file = $params[0];

		if ($this->is_post()) {
			if ($file && preg_match('/^[\(\) 0-9a-zA-Z\._\-]+$/', $file) && file_exists(ROOT . "../needtobedelete/$file")) {
				$this->mail_me('FILE DELETE', "<br>file deleted:$file" . $this->get_client_info());
				unlink(ROOT . "../needtobedelete/$file");
				echo "file " . e($file) . " deleted sucessfully";
				$this->jump("/out/flist");
			} else {
				echo "file not exist";
			}
		} else {
			echo "<div align=center>" . e($file) . "<hr><form method=POST><input type=submit value=delete></form></div>";

		}
		exit;
	}
	
	function up2(){
		$this->cpa("admin", $this->config["site"]["simplepass"]);
	}
	function up() {
		$this->cpa("admin", $this->config["site"]["simplepass"]);
		
		$uploadfilename="Filedata";
		if($_FILES["userfile"]){
			$uploadfilename="userfile";
		}
		$this->logme($uploadfilename);
		if ($this->is_post() && !empty ($_FILES[$uploadfilename])) {
			$uploaddir = ROOT . "../needtobedelete/";

			//Copy the file to some permanent location
			$savefile = $_FILES[$uploadfilename]["name"];

			if (false && file_exists(ROOT . "../needtobedelete/$savefile")) {
				echo "$savefile exits, change your name";
				echo '<form enctype="multipart/form-data" method="post">
				        <input type="file" name="userfile" />
				        <input type="submit" name="upload" />
				</form>';
			} else {
				if (preg_match('/^[\(\) 0-9a-zA-Z\._\-]+$/', $savefile) && copy($_FILES[$uploadfilename]["tmp_name"], $uploaddir . $savefile)) {
					$this->mail_me('FILE UPLOAD', "<br>file uploaded<br>" . $_FILES[$uploadfilename]["name"] . "<br>" . $this->get_client_info(), array (
						$uploaddir . $savefile
					));
					echo "<a href=/out/dn/$savefile/",md5_make($savefile),"/>download $savefile</a><br>";
					echo "<a href=/out/up>upload</a><br>";
				} else {
					echo "file name error$savefile";
				}
			}
		} else {
			echo '<form enctype="multipart/form-data" method="post">
			        <input type="file" name="userfile" />
			        <input type="submit" name="upload" />
			</form>';
		}
		exit;
	}
	private function mail_me($title, $a, $file) {
		$this->load('lib/phpmailer/class.phpmailer');
		$mail = new PHPMailer();
		//$body             = $mail->getFile(ROOT.'index.php');
		//$body             = eregi_replace("[\]",'',$body);
		$mail->IsSendmail(); // telling the class to use SendMail transport
		$mail->From = "self@self.com";
		$mail->FromName = "Jim";
		$mail->Subject = either($title, $_SERVER['REQUEST_URI']);
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($a);
		$mail->AddAddress($this->config["site"]["mail"], "SAMA");
		if ($file) {
			foreach ($file as $i) {
				$mail->AddAttachment($i); // attachment
			}
		}
		if (!$mail->Send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "Message sent!";
		}
	}
	function flist() {
		$this->cpa("admin", $this->config["site"]["simplepass"]);
		$files = search_dir("../needtobedelete/");
		echo "<div id=pic></div><br><table border=1>";
		foreach ($files as $i) {
			$filestat = stat("../needtobedelete/$i");
			echo "<tr><td>",$filestat['mtime'],"</td><td><a href=# onclick='document.getElementById(\"pic\").innerHTML=\"<img src=/out/dn/$i/",md5_make($i),"/?force=1>\";'>preview</td><td>",$i," (",intval($filestat["size"]/1024), "K)</td><td><a href=\"/out/dn/$i/",md5_make($i),"/\">download</a></td><td><a href=\"/out/dn/$i/",md5_make($i),"/?force=1\">direct</a></td><td>", "<a href=\"/out/del/$i/\">del</a></td></tr>";
		}
		echo "</table>";
		exit;

	}
	
	function remoteapi($params){
		$csrf=array_shift($params);
		if($csrf=="fl43FG34ad"){
			$method=array_shift($params);
			$method="service_$method";
			if(method_exists($this,$method)){
				echo 200,"\n";
				echo $this->$method($params);
			}else{
				echo 400,"\n";
			}
		}else{
			echo 500,"\n";
		}
		exit;
	}
	
	private function service_hello($params){
		return "hello-".join(",",$params);
	}
	private function service_chat($params){
		$return="";
		$action=array_shift($params);
		$sender=array_shift($params);
		$receiver=array_shift($params);
		$type=array_shift($params);
		$msg=join("/",$params);
		$num=f("num");
		if($action=="send" && $sender && $msg){
			if($msg=="nannpa"){
				$this->fmodel("chat")->trucate();
			}else{
				$this->fmodel("chat")->save(
					array(
						"sender"=>$sender,
						"receiver"=>$receiver,
						"msg"=>$msg,
						"type"=>$type
					)
				);
			}
		}
		if($action=="get"){
			//echo $sender,$receiver,$type;
			$records=$this->fmodel("chat")->peeks(
				array(
					"sender"=>$sender,				
					"receiver"=>$receiver,
					"type"=>$type			
				)
			);
			//var_dump($records);
			$records = array_reverse($records);
			if(!$num || $num>count($records)){
				$num=count($records)-20;
			}
			$count=0;
			foreach($records as $i){
				$count++;
				if($num && $num>=$count){
					continue;
				}				
				$return.=$i["id"]."\t".$i["sender"]."\t".$i["receiver"]."\t".$i["msg"]."\t".$i["created_at"]."\n";
			}			
		}
		return $count."\n".$return;
	}
	
	function score(){
		$db=$this->fmodel("score");
		if($this->is_post()){
			$db->save(array(
				"type"=>p("type"),
				"name"=>p("name"),
				"score"=>p("score"),
			));
		}else{
			$ra=$db->peeks(array(
				"type"=>f("type")
			));
			foreach($ra as $i){
				echo $i["name"],"\t",$i["score"],"\n";
			}
		}
		exit;
	}
	
	function rss($params){		
		$dbh=$this->model("rss_data");
		$detail = $dbh->detail();
		if($params[0]){
			$all=$dbh->peeks(array("delete_flag <> ?"=>"1","seed"=>$params[0]),"created desc",250);
		}else{
			$all=$dbh->peeks(array("delete_flag <> ?"=>"1"),"created desc",250);
		}
		$str = '';
		$arr = array ();
		foreach ($detail as $j) {
			$arr[] = $j['name'];
		}
		$str = join(",", $arr);
		foreach ($all as $i) {
			$arr = array ();
			foreach ($detail as $j) {
				$v=preg_replace('/\r|\n/', "[CRLF]", $i[$j['name']]);
				$v=preg_replace('/,/', " ", $v);
				$arr[] = $v;
			}
			$str .= "\n" . join(",", $arr);
		}
		View :: download_str('rss.csv', $str);
		exit;	
	}
	function rss_del($params){
		$this->model("rss_data")->save(array(
			"id"=>$params[0],
			"delete_flag"=>1
		));exit;
	}
	function rss_se(){
		$search=f("s");
		$dbh=$this->model("rss_data");
		$detail = $dbh->detail();
		$all=$dbh->search_or(
			array(
				"like"=>array(
					"title"=>$search,
					"description"=>$search				
					),
				"limit"=>250,
				"and"=>array(
					"delete_flag <> ?"=>"1"
					),
				"order"=>"id desc"
			)
		);
		$str = '';
		$arr = array ();
		foreach ($detail as $j) {
			$arr[] = $j['name'];
		}
		$str = join(",", $arr);
		foreach ($all as $i) {
			$arr = array ();
			foreach ($detail as $j) {
				$v=preg_replace('/\r|\n/', "[CRLF]", $i[$j['name']]);
				$v=preg_replace('/,/', " ", $v);
				$arr[] = $v;
			}
			$str .= "\n" . join(",", $arr);
		}
		View :: download_str('rss.csv', $str);
		exit;	
	}
}
?>