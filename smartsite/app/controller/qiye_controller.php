<?php

include(ROOT."app/main/scaffold.php");

class qiye_controller extends application {
	function filter($method) {		
		$this->cpa("admin",$this->config["site"]["simplepass"]);
		//$this->show_db_queries=true;
	}	

	function index(){		
		$db = $this->modelu8("qiye");
		$ra=$db->peeks_sql("select distinct name from qiye");
		$this->sv("list",$ra);
	}
	function detail($params){
		$db = $this->modelu8("qiye");
		
		if($this->is_post()){
			$title=p('title');
			$content=p('content');
			$type=p('what');
			
			if(!$db->peeks_sql("select * from qiye where name=? and type=?",array($params[0],$type))){
				$db->save(
					array(
						'name'=>$params[0],
						'title'=>$title,
						'content'=>$content,
						'type'=>$type
					)					
				);
	
			}else{
				$db->execute("update qiye set title=?,content=? where name=? and type=?",
				array($title,$content,$params[0],$type)
				);
		
			}
		}
		
		$ra=$db->peeks_sql("select * from qiye where name=? order by type",array($params[0]));
		$this->sv("list",$ra);
	}
	
	function top($params){
		$db = $this->modelu8("qiye");
		$ra=$db->peeks_sql("select * from qiye where name=? order by ut desc",array($params[0]));
		$this->sv("list",$ra);
		$qiye=$db->peek_table('qiyesingle',array('name'=>$params[0]));
		$this->sv("qiye",$qiye);
		$this->sf('qiye/template/'.$qiye['template'].'/index');		
	}
	
	function other($params){
		$db = $this->modelu8("qiye");
		$ra=$db->peeks_sql("select * from qiye where name=? and type=?",array($params[0],$params[1]));
		$this->sv("article",$ra[0]);
		$qiye=$db->peek_table('qiyesingle',array('name'=>$params[0]));
		$this->sv("qiye",$qiye);
		$this->sf('qiye/template/'.$qiye['template'].'/article');
		
		$ra=$db->peeks_sql("select * from qiye where name=? order by ut desc",array($params[0]));
		$this->sv("list",$ra);
		//var_dump($params);
		//var_dump($ra);
	}
	
	function article($params){	
		$db = $this->modelu8("qiye");
		
		$ra=$db->peeks_sql("select * from qiye where name=? order by ut desc",array($params[1]));
		$this->sv("list",$ra);
		
		$ra=$db->peek(array('id'=>$params[0]));
		$this->sv("article",$ra);

		$qiye=$db->peek_table('qiyesingle',array('name'=>$params[1]));
		$this->sv("qiye",$qiye);
		$this->sf('qiye/template/'.$qiye['template'].'/article');	
	}
	
	function savetohtml($params){
		$db = $this->modelu8("qiye");
		$ra=$db->peeks_sql("select * from qiye where name=? order by type",array($params[0]));
		
			
			
		$view=View::getObj();	    
	    $rtnsrc=$view->fetch_html(array("list"=>$ra),ROOT.'app/view/qiye/template/a.tpl');
	    
	    $this->tocn($params[0],$rtnsrc);
	    
		$this->jump($this->config["qiye"].$params[0].'.html',1);
		exit;
	}
	
	private function tocn($name,$content){
		$fileopen = fopen("../hpx1011.unibeing.net/qiye/$name.html","w");
		fwrite($fileopen,$content);
		fclose($fileopen);
	}
	
}

?>