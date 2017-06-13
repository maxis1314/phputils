<?php

include(ROOT."app/main/scaffoldfile.php");

class filecms_controller extends scaffoldfile {
	
	function __construct($params){
		$this->table_name=$params[0];	
	}
	
	function filter($method){
		$this->cpa("admin",$this->config["site"]["simplepass"]);
			
		$this->ctl=$this->ctl.'/'.$this->table_name;
		parent::filter($method);
		$this->sv("simple",1);
		$tables=$this->fmodel()->table_names();
		$this->sv("tables",$tables);
		$this->sv("cmspath","filecms");
	}
	
	function table_list(){
		$tables=$this->fmodel()->table_names();
		echo join(",",$tables);
		exit;
	}
	
	function dispatch($params){
		array_shift($params);
		$method=array_shift($params);
		if(!$method){
			$method="index";
		}
		if (method_exists($this, $method)) {
			$this->$method($params);
		} else {
			$this->sv("error", "\nclass filecms -> $method () not exists");
			$this->do404();
		}		
	}

	
}

?>