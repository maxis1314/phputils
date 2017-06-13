<?php
class flash_controller extends application {

	function filter($method) {
		$this->user_login();
		$this->sv('blog', $this->model('mvc_blog')->peeks(array (
			"delete_flag is null or delete_flag <> ?" => 1
		), 'id desc', 10));
		$this->sv('comment', $this->model('mvc_comment')->peeks(null, 'id desc', 10));

	}

	function index($params) {
		$video=$this->fmodel("flv")->peek(array("id"=>$params[0]));
		$allvideo=$this->fmodel("flv")->peeks();
		if(!$video){
			$video=$allvideo[0];
		}
		$rate=1;
		$this->sv("width",640*$rate);
		$this->sv("height",377*$rate);
		$this->sv("allVideo",$allvideo);
		$this->sv("videoUrl",urlencode($video['url']));
	}
	
	function show($params) {
		$rate=1;
		$this->sv("width",500*$rate);
		$this->sv("height",375*$rate);
		$this->sv("allVideo",$allvideo);
		$this->sv("videoUrl",urlencode($params[0]));
	}
	function flex($params){
		$rate=1.1;
		$this->sv("width",500*$rate);
		$this->sv("height",375*$rate);
		$this->sv("allVideo",$allvideo);
		$this->sv("videoUrl",urlencode($params[0]));
	}
	function auth($params){
		echo 11;exit;
	}

}
?>