<?php

include(ROOT."app/main/scaffold.php");

class qiyedb_controller extends scaffold {
	var $tableslist;
	
	function __construct($params){
		if(!$params[0]){
			$params[0]="students";
		}
		$this->table_name=$params[0];	
	}
	
	function filter($method){
		$this->initdb("utf8");
		$this->cpa("admin",$this->config["site"]["simplepass"]);
		
			
		$this->ctl=$this->ctl.'/'.$this->table_name;
		parent::filter($method);
		$this->sv("simple",1);
		$this->tableslist=array("qiye","qiyesingle");
		$this->sv("tables",$this->tableslist);
		$this->sv("cmspath","qiyedb");
		$this->show_db_queries=false;
	}
	
	function dispatch($params){
		
		array_shift($params);
		$method=array_shift($params);
		if(!$method){
			$method="index";
		}
		if (method_exists($this, $method)) {
			if(in_array($this->table_name,$this->tableslist)){
				$this->$method($params);
			}else{
				$this->show_db_queries=false;
				$this->do404();
			}
		} else {
			$this->sv("error", "\nclass cms -> $method () not exists");
			$this->do404();
		}		
	}
	

	
}

?>