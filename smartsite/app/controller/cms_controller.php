<?php

include(ROOT."app/main/scaffold.php");

class cms_controller extends scaffold {
	
	function __construct($params){
		$this->table_name=$params[0];
		$this->charset='utf8';		
	}
	
	function filter($method){
		$this->show_db_queries=true;
		$this->initdb("utf8");
		$this->cpa("admin",$this->config["site"]["simplepass"]);
			
		$this->ctl=$this->ctl.'/'.$this->table_name;
		parent::filter($method);
		$this->sv("simple",1);
		$tables=$this->model()->table_names();
		$this->sv("tables",$tables);
		$this->sv("cmspath","cms");		
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
			$this->sv("error", "\nclass cms -> $method () not exists");
			$this->do404();
		}		
	}
	
	function table_list(){
		$tables=$this->model()->table_names();
		echo join(",",$tables);
		exit;
	}
	
	function delete_delta(){
		$this->modeldb->peeks_sql("delete from ".$this->table_name." WHERE TO_DAYS(NOW())-TO_DAYS(created)>20");
		$this->jump('/cms/'.$this->table_name);
	}
	
	function sql($params){		
		$db=$this->modeldb;
	
		if(p("do")=="simple"){
			$all=$db->peeks_sql(p("execsql2"),p("param"));
			$this->sv("list",$all);
							
		}
		$this->sf("cms/sql");	
	}
	
	
}

?>