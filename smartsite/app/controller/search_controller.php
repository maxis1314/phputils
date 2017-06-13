<?php
class search_controller extends application {

	function filter(){
		$this->sv('blog',$this->model('mvc_blog')->peeks(array("delete_flag is null or delete_flag <> ?"=>1),'id desc',10));
		$this->sv('comment',$this->model('mvc_comment')->peeks(null,'id desc',10));		
	}
	
		
	function jp($params,$type=""){
		$startTime=microtime_float();
		$db=$this->model("mvc_dog");
		$page=intval(f('page'));
		$from=$page*10;
		$keyw=f("key")?f("key"):$params[0];
		$this->sv('keyw',$keyw);
		if($keyw){
			$table="word_urljp_rich";
			if($type == "cn"){
				$table="se_word_url";
			}
			$key=get_search_keyword($keyw);
			$ra_key=explode(',',$key);
			$all=$db->rows("select url as link,sum(link_num)*(pow(count(*),3)+1) as num  
			from  $table 
			where word in(".$key.") 
			group by url order by num desc limit $from,11");
			foreach($all as &$one){
				if($type=="cn"){
					$url_info=$db->rows("select distinct(word) as aword from se_word_url where url=? limit 10",array($one["link"]));
					$one["title"]=$keyw;
					$ke=array();
					foreach($url_info as $j){
						$ke[]=$j["aword"];
					}
					$one["description"]=join(",",$ke);
				}else{			
					$url_info=$db->row("select * from url_info where url=? limit 1",array($one["link"]));
					$one["title"]=$keyw;
					$one["description"]="$url_info[keyw]\n$url_info[chaset]";
				}
				$rhurl=parse_url($one['link']);
				$one['host']=$rhurl['host'];			
			}
			if(count($all)>10){
				$this->sv('has_next',1);
				array_pop($all);
			}
			$this->sv("result",$all);
			$this->sv("page",$page);					
		}
		$consumeTime=microtime_float()-$startTime;
		$this->sv("consumeTime",$consumeTime);	
	}
	function cn($params){
		$this->jp($params,"cn");
	}
	


}

?>