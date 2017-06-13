<?php
class wiki_controller extends application {	
	function filter($method){
		if($_SERVER[REMOTE_ADDR]!="127.0.0.1"){
			echo "You are fobbiden to access";
			exit;
		}		
	}
	
	
	function show($params){
		echo ROOT . "../wiki/" . strtoupper(bin2hex(join('/',$params))) . '.txt';
		echo "<hr>";
		$lines=$this->get_wiki_source(join('/',$params));
		foreach($lines as &$i){
			$i=e($i);
		}
		echo join("<br>\n",$lines);
		exit;
	}
	
	function test(){
		$this->add_wiki_source("TODO","\n");
		exit;
	}
	
	
	function rss(){
		$url=f('url');
		if(!$url){
			$url='http://java5000.blogspot.com/feeds/posts/default?alt=rss';
		}
		require(ROOT.'lib/rss/lastRSS.php');
		$rss = new lastRSS;
		$str=$this->url2str($url,1);
		if(!$str){
			$data=$this->fmodel('rss')->peek(array('url'=>$url));
			$data['valid']=2;
			$this->fmodel('rss')->save($data);
			$str="";
		}else{
			cacheme($url,$str);
		}
		$result=$rss->ParseStr($str);
		if($result["encoding"] && strcasecmp($result["encoding"], "utf-8") != 0){
			$result=$rss->ParseStr(mb_convert_encoding($str, "UTF-8", $result["encoding"]));
		}
		foreach($result["items"] as &$i){			
			$i["description"]=html_entity_decode($i["description"]);			
			$i["description"]=preg_replace('/< *br *[\/]?>/',"\n",$i["description"]);
			$i["description"]=preg_replace('|href=("?)|i','target=_blank href=${1}/self/out/rd?url=',$i["description"]);
			$i["link"]=preg_replace('/>$/',"",$i["link"]);
			if(!preg_match('/^https?\:/',$i["link"])){
				$i["link"]="http://www.google.com/search?q=".urlencode($i["title"]);
			}			
		}
		$this->sv("rssresult",$result);
		$rsslist=$this->fmodel('rss')->peeks(array('valid'=>1));
		$this->sv("rssfeed",array_reverse($rsslist));
	}
}
?>