<?php
class record{
	var $model;
	var $id;
	var $data=array();
	
	function Record($model){
		$this->model=$model;		
	}
	
	function findById($id){
		$this->data=$this->model->peek(array("id"=>$id));
		return $this;
	}
	
	function getData(){
		return $this->data;
	}
	
	function get($field){
		return $this->data[$field];		
	}
	
	function set($field,$value){
		$this->data[$field]=$value;
		return $this;
	}
	
	function save(){		
		$this->model->save($this->data);
		return $this;
	}	
	
}


?>