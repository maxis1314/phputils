<?php
class quick_controller extends application {
	function filter($method) {
		$this->sv('blog', $this->model('mvc_blog')->peeks(array (
			"delete_flag is null or delete_flag <> ?" => 1
		), 'id desc', 10));
		$this->sv('comment', $this->model('mvc_comment')->peeks(null, 'id desc', 10));
		//$this->show_db_queries=true;		
	}

	function index() {
		$this->blog();
	}

	function ajaxindex() {

	}

	function blog() {
		$blogdb = $this->model("mvc_blog");
		$all = $blogdb->peeks_page(array (
			"delete_flag is null or delete_flag <> ?" => 1
		), "id desc", f("page"), 10);
		$allnum = $blogdb->peek_num(array (
			"delete_flag is null or delete_flag <> ?" => 1
		));

		$foot = pagerfoot2(f("page"), $allnum, '/' . $this->ctl . '/' . $this->action, 10, 11, "<br>");
		$this->sv("blogpage", $all);
		$this->sv("pagefoot", $foot["pagecode"]);
		if ($this->format == "xml") {
			$this->outXML($all);
		}
	}
	
	function myblog() {
		$this->show_db_queries=1;
		$this->user_login();
		echo $_SESSION['user_id'];
		$blogdb = $this->model("mvc_blog");
		$all = $blogdb->peeks_page(array (
			//"delete_flag is null or delete_flag <> ?" => 1,
			"user_id"=>$_SESSION['user_id']
		), "id desc", f("page"), 10);
		$allnum = $blogdb->peek_num(array (
			//"delete_flag is null or delete_flag <> ?" => 1,
			"user_id"=>$_SESSION['user_id']
		));

		$foot = pagerfoot2(f("page"), $allnum, '/' . $this->ctl . '/' . $this->action, 10, 11, "<br>");
		$this->sv("blogpage", $all);
		$this->sv("pagefoot", $foot["pagecode"]);
		$this->sf("quick/blog");
		if ($this->format == "xml") {
			$this->outXML($all);
		}
	}

	function newblog() {
		$this->user_login();
		if ($this->is_post()) {
			if(p("father")){
				$this->model("mvc_comment")->save(array (
					"user_id" =>$_SESSION['user_id'],
					"content_id"=>p("father"),
					"comment"=>p("title")."\n".p("content")				
				));				
				echo $this->getParentUpdate('/quick/blogshow/'.p("father"));
			}else{
				$this->model("mvc_blog")->save(array (
					"user_id" =>$_SESSION['user_id'],
					"title"=>p("title"),
					"content"=>p("content")				
				));
				echo $this->getParentUpdate('/quick/newblog');
			}
			
			exit;
		}
	}

	function wiki() {

	}

	function ajaxshow($params) {
		$this->sv("id", get_i($params[0]));
	}

	function blogshow($params) {
		$detail = $this->model("mvc_blog")->peek(array (
			"id" => $params[0]
		));

		if ($detail) {
			$this->sv("detail", $detail);
		} else {
			$this->do404();
		}

		$re2 = $this->model("mvc_comment")->peeks(array (
			"content_id" => $params[0]
		), "id asc");

		$this->sv("commentblog", $re2);

		srand((double) microtime() * 1000000);
		$this->sv('rand', rand() % 8);

		if ($this->format == "pdf") {
			$this->output_pdf("Blog", "hpx", $detail["title"] . "\n\n" . $detail["content"], "cn2");
			exit;
		}
		if ($this->format == "xml") {
			$this->outXML(array (
				$detail
			));
		}
	}

	function blogdelete($params) {
		//$this->model('mvc_blog')->save(array (
		//	"id" => $params[0],
		//		"delete_flag" => 1
		//));
	}

	function table() {

	}

	function picture($params) {
		$filename = get_w($params[0]) ? get_w($params[0]) : "my";
		$filepath = ROOT . "data/pic-$filename.data";
		if (!file_exists($filepath)) {
			$this->do404();
		}
		$files = file($filepath);

		$foot = pagerfoot2(f("page"), $files, '/' . $this->ctl . '/' . $this->action, 6);
		$files = $foot["data"];

		foreach ($files as & $i) {
			$i = 'http://dl.getdropbox.com/u/637079/album/' . $i;
		}
		$this->sv("piclist", $files);
		$this->sv("foot", $foot["pagecode"]);
	}

	function transfer() {
		$dbconfig = $this->config["dsn"];
		include_once (ROOT . "lib/vip/DBUtil.php");
		include_once (ROOT . "app/main/model.php");
		$data = $this->model('mvc_comment')->peeks();

		$dbconfig['charset'] = 'utf8';
		$dbnew = new DB($dbconfig);
		$modelnew = new model($dbnew, 'mvc_comment2');
		echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />';

		foreach ($data as $i) {
			echo $i[comment], "<br>";
			$i[oldid] = $i[id];
			$i[id] = null;
			$modelnew->save($i);
		}
		exit;
	}
	function roadmap() {
	}
	function contact() {
	}
	function reg() {
	}
	function login() {
		if ($this->is_post()) {
			$user=$this->model('user')->peek(array (
					'email' => p('name'),
					'pass' => p('pass')
				));
			if ($user) {
				$_SESSION['login'] = 1;
				$_SESSION['user_id'] = $user["id"];
				echo $this->getParentUpdate('/quick/');
				exit;
			} else {
				$this->jump("/in/x2f/login", "login fail", 3);
			}
		}
	}
	function logout() {
		$_SESSION['login'] = null;
		$_SESSION['user_id'] = null;
		$this->to_path("/quick/");
	}
}
?>