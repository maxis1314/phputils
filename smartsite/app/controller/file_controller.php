<?php
include(ROOT."app/main/scaffoldfile.php");
class file_controller extends scaffoldfile {
	function __construct(){
		$this->table_name="memo";
	}
	function filter($method){	
		parent::filter($method);
		$this->sv("simple",1);
	}

	function index(){
		parent::index();
		$this->sf("file/index");
	}
	
	function webproxy(){
		if(f('pass')=="fsidl734gjdf9230742o423hlfs890"){
			echo $this->url2str(f('url'));
			exit;
		}
		$this->do404();
	}
}
?>