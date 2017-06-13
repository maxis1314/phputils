<?php

include(ROOT."app/main/scaffold.php");

class crud_controller extends scaffold {
	
	function __construct($params){
		$this->table_name='crud';	
	}
	
	function filter($method){		
		parent::filter($method);
		$this->sv("simple",1);	
	}	
}

?>