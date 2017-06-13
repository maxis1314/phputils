<?php

define("SAFEPATH", ROOT."data/tables/");#never should be the web accessable

class DBFLAT
{
	var $tablename = null;
	var $lastid=null;

	function __construct($tablename,$force=nil){
		$this->tablename=$tablename;
		if (!$force && ! file_exists(SAFEPATH.$this->tablename)) {
			$this->tablename="wiki";
		}
	}	
	
	function table_names(){
		$tables=array();
		if ($dh = opendir(SAFEPATH)) {
	    	while (($file = readdir($dh)) !== false) {
	       	   if($file == "." || $file==".."){
	       	   		continue;
	       	   }
	       	   if(preg_match('/^[A-Za-z_]+$/',$file)){
	           		$tables[]=$file;
	       	   }
	       }
	       closedir($dh);
		}
		return $tables;
	}
	
	function seconds_after_creat(){
		$created=filectime(SAFEPATH.$this->tablename);
		$a=time()-$created;
		return $a;
	}
	
	function get_lines(){
		$lines = file(SAFEPATH.$this->tablename);
		foreach($lines as &$i){
			$i=chop($i);
		}
		return $lines;
	}
	
	
	function trucate(){
		$lines = $this->get_lines();	
		$head=array_shift($lines);
		$handle = fopen(SAFEPATH.$this->tablename, 'w');
		fwrite($handle, $head."\n"); 
		fclose($handle);
	}
	
	function create($a){
		if(!$a["id"]){
			$a["id"]=random_str();
		}
		$a['created_at']=date("Y/m/d H:i:s");
		//$a['cookie']=@$_COOKIE['cookie'];
		$this->lastid=$a["id"];
		$lines = $this->get_lines();
		$head=explode("\t",array_shift($lines));
		$head_num=count($head);
		
		$b=array();							
		for($i=0;$i<$head_num;$i++){
			if($a[$head[$i]]){
				$b[]=$this->escape($a[$head[$i]]);
			}else{
				$b[]="";
			}			
		}
		$handle = fopen(SAFEPATH.$this->tablename, 'a');
		if (flock($handle, LOCK_EX)) { 
			$line = implode("\t", $b);
			fwrite($handle, $line."\n"); 
			flock($handle, LOCK_UN); // ロックを解放します
		}else{
			fclose($fp);
			return false;
		}
		fclose($fp);
		return $a;		
	}
	
	function get_last_id(){
		return $this->lastid;
	}
	
	function escape($str){
		$temp=preg_replace('/\r\n/',"\n",$str);
		$temp=preg_replace('/\n/',"[CRLF]",$temp);
		$temp=preg_replace('/\t/',"    ",$temp);
		return $temp;
	}
	
	function update($a){
		$this->lastid=$a["id"];
		$a['updated_at']=date("Y/m/d H:i:s");
		$lines = $this->get_lines();		
		$head=explode("\t",array_shift($lines));
		$line_num=count($lines);
		$head_num=count($head);
		
		$b=array();
		
		$return_array=$this->peeks(array('id'=>$a['id']));
		$older=$return_array[0];
			
		for($i=0;$i<$head_num;$i++){
			if(isset($a[$head[$i]])){
				$b[]=$this->escape($a[$head[$i]]);
			}else{
				$b[]=$this->escape($older[$head[$i]]);
			}			
		}
		
		$line = implode("\t", $b);		
		$headstr=implode("\t", $head);
		
		$handle = fopen(SAFEPATH.$this->tablename, 'w');
		if (flock($handle, LOCK_EX)) { 
			fwrite($handle, $headstr."\n"); 
			for($i=0;$i<$line_num;$i++){
				$single=explode("\t",$lines[$i]);
				if($single[0]==$a["id"]){
					 fwrite($handle, $line."\n");
					 //echo $single[0],"-",$a["id"],"-",$line;exit;				 
				}else{				
					 fwrite($handle, $lines[$i]."\n");
				}
			}
			//fclose($handle);
			flock($handle, LOCK_UN); // ロックを解放します
		}else{
			fclose($fp);
			return false;
		}
		fclose($fp);
		return $a;
	}
	
	function save($a){
		if($a["id"]){
			return $this->update($a);			
		}else{
			return $this->create($a);
		}
	}
	
	function peek_del($f){
		$lines = $this->get_lines();
		$head=explode("\t",array_shift($lines));
		$line_num=count($lines);
		$head_num=count($head);
		$save_array=array();
		$dekete_array=array();
		$headstr=implode("\t", $head);

		for ($i = 0; $i < $line_num; $i++) {
			$line = explode("\t", "$lines[$i]");
			$b=array();				
			for($j=0;$j<$head_num;$j++){					
				$b[$head[$j]]=preg_replace('/\[CRLF\]/',"\n",$line[$j]);
			}
			if($f){
				$delete=true;
				for($j=0;$j<$head_num;$j++){
					if($f[$head[$j]] && $f[$head[$j]]!=$b[$head[$j]]){
						$delete=false;
					}
				}
				if($delete){
					$dekete_array[]=$b;					
				}else{
					$save_array[]=$lines[$i];
				}
			}else{
				$save_array[]=$lines[$i];
			}
		}			

		$handle = fopen(SAFEPATH.$this->tablename, 'w');
		if (flock($handle, LOCK_EX)) { 
			fwrite($handle, $headstr."\n"); 
			foreach($save_array as $i){			
				fwrite($handle, $i."\n");		
			}
		}else{
			fclose($handle);
			return false;
		}
		fclose($handle);
		
		return $dekete_array;
	}
	
	function drop(){
		unlink(SAFEPATH.$this->tablename);
	}
	
	function detail(){
		$lines = $this->get_lines();
		$head=explode("\t",array_shift($lines));
		$return_array=array();
		foreach($head as $i){
			$return_array[]=array("name"=>$i,"type"=>"text");
		}
		return $return_array;
	}
	
	function peeks($f){
		$lines = $this->get_lines();	
		$head=explode("\t",array_shift($lines));
		$line_num=count($lines);
		$head_num=count($head);
		$return_array=array();

		for ($i = 0; $i < $line_num; $i++) {
			$line = explode("\t", "$lines[$i]");
			$b=array();				
			for($j=0;$j<$head_num;$j++){					
				$b[$head[$j]]=preg_replace('/\[CRLF\]/',"\n",$line[$j]);
			}
			if($f){
				$add=true;
				for($j=0;$j<$head_num;$j++){
					if($f[$head[$j]] && $f[$head[$j]]!=$b[$head[$j]]){
						$add=false;
					}
				}
				if($add){
					$return_array[]=$b;
				}
			}else{
				$return_array[]=$b;
			}
		}
		return array_reverse($return_array);
	}
	
	function peek_col($f,$col="id"){
		$all=$this->peeks($f);
		$return=array();
		foreach($all as $i){
			$return[]=$i[$col];
		}
		return $return;
	}
	
	
	function peeks_like($f){
		$lines = $this->get_lines();	
		$head=explode("\t",array_shift($lines));
		$line_num=count($lines);
		$head_num=count($head);
		$return_array=array();

		for ($i = 0; $i < $line_num; $i++) {
			$line = explode("\t", "$lines[$i]");
			$b=array();				
			for($j=0;$j<$head_num;$j++){					
				$b[$head[$j]]=preg_replace('/\[CRLF\]/',"\n",$line[$j]);
			}
			if($f){
				
				$add=false;
				for($j=0;$j<$head_num;$j++){
					//echo $b[$head[$j]],":",$f[$head[$j]],":",strpos($b[$head[$j]], $f[$head[$j]]),"<br>";
					if($f[$head[$j]] && false !== strpos($b[$head[$j]], $f[$head[$j]])){
						$add=true;						
					}
				}
				if($add){
					$return_array[]=$b;
				}
			}else{
				$return_array[]=$b;
			}
		}
		return array_reverse($return_array);
	}
	
	function peek($f){
		$return_array=$this->peeks($f);
		if($return_array){
			return $return_array[0];
		}else{
			return false;
		}
	}
	
	function peek_create($f){
		$record=$this->peek($f);
		if(!$record){
			$record=$this->create($f);
		}
		return $record;
	}
	
	
	function size(){
		$bytes=filesize(SAFEPATH.$this->tablename);
        $s = array('B', 'Kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));
        return sprintf('%d '.$s[$e], ($bytes/pow(1024, floor($e))));
	}
	
	function error_detail(){
		return false;
	}
	
	function randoms($num=10){
		srand((double)microtime()*1000000);
		$all=$this->peeks(array());
		$return=array();
		$has=array();
		for($i=0;$i<$num;$i++){
			$ok=rand()%count($all);
			if($has[$ok]==1){
				continue;
			}		
			$has[$ok]=1;			
			$return[]=$all[$ok];
		}
		return $return;		
	}
	
}
?>