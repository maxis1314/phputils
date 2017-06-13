<?php
class controller{
	var $db;
	var $tmplvar;
	var $tmplfile;
	var $ctl;
	var $format;
	var $action;
	var $config;
	var $modelcache=array();
	var $fmodelcache=array();
	var $request=array();
	var $show_db_queries=false;
	
	function set_config(&$a){
		$this->config=$a;
	}
	
	function filter(){
	}
	
	function __construct(){

	}
	
	function initdb($charset){
		if(!$this->db){
			include_once(ROOT."lib/vip/DBUtil.php");
			$dbconfig=$this->config["dsn"];
			$dbconfig['charset']=$charset;
			$this->db=new DB($dbconfig);
		}
	}
	
	function fmodel($table){
		if($this->fmodelcache[$table]){
			return $this->fmodelcache[$table];
		}
		include_once(ROOT."lib/vip/DBFLAT.php");					
		$modelobj = new DBFLAT($table);
		$this->fmodelcache[$table]=$modelobj;
		return $modelobj;	
	}
	
	function record($table,$id){
		include_once(ROOT."app/main/record.php");
		$record = new record($this->model($table));
		$record->findById($id);
		return $record;
	}
	function modelu8($table){
		return $this->model($table,'utf8');
	}
	function model($table,$charset){
		if($this->modelcache[$table]){
			return $this->modelcache[$table];
		}
		$this->initdb($charset);		
		include_once(ROOT."app/main/model.php");
		if(file_exists(ROOT."app/model/{$table}_model.php")){
			include_once(ROOT."app/model/{$table}_model.php");
		}
		$modelobjname=$table.'_model';
		if(class_exists($modelobjname)){			
			$modelobj = new $modelobjname($this->db,$table,$this->config);
			$this->modelcache[$table]=$modelobj;
			return $modelobj;
		}else{
			$modelobj = new model($this->db,$table,$this->config);
			$this->modelcache[$table]=$modelobj;
			return $modelobj;
		}
	}
	
	function jump($path,$mes="",$sec=0,$mes2=""){		
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$sec; URL=$path\">";
		echo htmlspecialchars($mes, ENT_QUOTES);
		echo $mes2;
		exit;
	}
	
	function to_path($a){
		$a=preg_replace('/\n|\r/','',$a);		
		header("Location: $a");		
		//echo('<script>document.location="'.urldecode($a).'";</script>');
		exit;
	}
	
	function jump_cookie($path,$mes="",$sec=0,$mes2=""){
		$newpath=get_cookie('jump');
		if($newpath){
			$path=$newpath;
			set_cookie('jump','',-1);
		}
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$sec; URL=$path\">";
		echo htmlspecialchars($mes, ENT_QUOTES);
		echo $mes2;
		exit;
	}

	function sv($key,$value){
		$this->tmplvar[$key]=$value;
	}

	function sf($a){
		$this->tmplfile=$a;
	}	

	function get_tmplfile(){
		return $this->tmplfile;
	}

	function load($str){
		require_once(ROOT."$str.php");		
	}

	function fetch_html($params){
		if(isset($this->tmplvar["htmlsrc"])){
			return $this->tmplvar["htmlsrc"];
		}
		
		$this->tmplvar["session"]=$_SESSION;
		$this->tmplvar["c"]=$this->config;
		$this->tmplvar["post"]=$_POST;
		$this->tmplvar["get"]=$_GET;
		$this->tmplvar["url"]=$params;
		$this->tmplvar["env"]=$_SERVER;
		$this->tmplvar["v"]=array(
			"control"=>$this->ctl,
			"action"=>$this->action,
			"form_csrf"=>"fdsaGJG343",
			"path"=>"/".$this->ctl."/".$this->action,
			"prefix"=>PREFIXURL
		);
		
		
	    if($tmplfile=$this->get_tmplfile()){
	   	   $tmplfile="app/view/$tmplfile.tpl";
	    }else{
	   	   $tmplfile="app/view/".$this->ctl."/".$this->action.".tpl";
	    }
	    if(!file_exists(ROOT.$tmplfile)){
	    	$oldtmplfile=$tmplfile;
	    	if (DEBUG) {
				$tmplfile="app/view/_share/404.tpl";
			} else {
				$tmplfile="app/view/_share/404user.tpl";
			}
	   
	    	$this->tmplvar["url"]=array("$oldtmplfile not exist.");
	    }
	    $view=View::getObj();
	    
	    $rtnsrc=$view->fetch_html($this->tmplvar,ROOT.$tmplfile);
	    
	    if ($this->show_db_queries) {
	    	$dblogs=$this->db->logs;
	    	if($dblogs){
		    	$rtnsrc.="<br><table border=1><tr><th>DB queries</th><th>Seconds</th></tr>";
		    	foreach($dblogs as $i){
		    		foreach(array('left','join','on','as','desc','by','asc','and','or','count') as $keywordsql){
		    			$i[0]=preg_replace('/\b'.$keywordsql.'\b/',' <font color=green><b>'.$keywordsql.'</b></font> ',$i[0]);
		    		}
		    		foreach(array('select','from','where') as $keywordsql){
		    			$i[0]=preg_replace('/\b'.$keywordsql.'\b/'," <br><font color=red><b>$keywordsql</b></font> <br>",$i[0]);
		    		}
		    		foreach(array('group','order','limit') as $keywordsql){
		    			$i[0]=preg_replace('/\b'.$keywordsql.'\b/'," <br><font color=red><b>$keywordsql</b></font> ",$i[0]);
		    		}
		    		$rtnsrc=$rtnsrc."<tr><td>$i[0]</td><td>$i[1]</td></tr>";
		    	}
		    	$rtnsrc.="</table>";
	    	}  	
	    }
	    
	    if($this->format=="fpdf"){
	    	//View::html2pdf($rtnsrc);
	    }
	    return $rtnsrc;
	}
}
	
	

?>
