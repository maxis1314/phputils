<?php
class relation_controller extends application {

	function __construct($params) {

	}

	function filter($method) {

	}

	private function process_words($word){
		//$word=strtolower($word);
		$word=preg_replace('/ +$/','',$word);
		$word=preg_replace('/^ +/','',$word);
		$word=preg_replace('/　+$/','',$word);
		$word=preg_replace('/^　+/','',$word);
		$word=str_replace('_',' ',$word);
		$word=str_replace('　',' ',$word);
	    $word=ucwords($word);
	    $word=str_replace(' ','',$word);
	       
		return $word;
	}
	
	private function levelstr($level){
		$strlevel=array(
			array("一级","0","100","试用期","魔法学徒","童生","兵卒","初学弟子"),
			array("二级","101","500","助理","见习魔法师","秀才","门吏","初入江湖"),
			array("三级","501","1000","助理","见习魔法师","秀才","门吏","初入江湖"),
			array("四级","1001","2500","经理","魔法师","举人","千总","江湖新秀"),
			array("五级","2501","5000","经理","魔法师","举人","千总","江湖新秀"),
			array("六级","5001","8000","高级经理","高级魔法师","同进士出身","都司","江湖少侠"),
			array("七级","8001","12000","高级经理","高级魔法师","同进士出身","都司","江湖少侠"),
			array("八级","12001","16000","总监","大魔法师","进士出身","参将","江湖大侠"),
			array("九级","16001","20000","总监","大魔法师","进士出身","参将","江湖大侠"),
			array("十级","20001","25000","副总裁","魔导师","探花","总兵","江湖豪侠"),
			array("十一级","25001","35000","副总裁","魔导师","探花","总兵","江湖豪侠"),
			array("十二级","35001","50000","首席运营官","大魔导师","榜眼","护军统领","一派掌门"),
			array("十三级","50001","80000","首席运营官","大魔导师","榜眼","护军统领","一派掌门"),
			array("十四级","80001","120000","首席执行官","护国法师","状元","九门提督","一代宗师"),
			array("十五级","120001","180000","首席执行官","护国法师","状元","九门提督","一代宗师"),
			array("十六级","180001","250000","董事长","魔神","大学士","骠骑将军","武林盟主"),
			array("十七级","250001","400000","董事长","魔神","大学士","骠骑将军","武林盟主"),
			array("十八级","400001","100000000","商界领袖","魔界至尊","翰林文圣","天下兵马大都督","独孤求败")
		);
		
		foreach($strlevel as $i){
			if($level>=$i[1] && $level<=$i[2]){
				$levelnow=$i;
				$percent=intval(100*($level-$i[1])/($i[2]-$i[1]));
				break;
			}
		}
		return "$levelnow[7]($levelnow[0]) $percent%";
	}
	
	function index($params) {
		$db = $this->fmodel('relation');
		
		$type = f('type');
		if ($type == 'add') {
			$word2=f('word2');
			if($word2){
				$word2_array=explode(",", $word2);
				foreach($word2_array as $j){
					$db->save(array (
						'word1' => $this->process_words(f('word1')),
						'word2' => $this->process_words($j),
						'relation' => f('relation')
					));
				}
			}
			$this->to_path('?type=relation&word='.urlencode($this->process_words(f('word1'))));
		}
		
		
		$all=$db->peeks();
		$level=count($all);
		$words=array();
		foreach($all as $i){
			$words[]=$i['word1'];
			$words[]=$i['word2'];
		}
		
		$words=array_unique($words);
		sort($words);
		$this->sv('words',$words);
		
		$this->sv('level',$this->levelstr($level));
		
		
		if ($type == 'relation') {
			$rwords=array();
			$word=f('word');
			foreach($all as $i){
				if($i['word1']==$word){					
					$rwords[]=$i['word2'];
				}
				if($i['word2']==$word){					
					$rwords[]=$i['word1'];
				}
			}
			$rwords=array_unique($rwords);
			sort($rwords);
			$this->sv('rwords',$rwords);
		}
		

	}
	function index2($params) {
		$db = $this->fmodel('relation2');
		$who=either(f('who'),'root');
		$this->sv('who',$who);
		$type = f('type');
		if ($type == 'add') {
			$word2=f('word2');
			if($word2){
				$word2_array=explode(",", $word2);
				foreach($word2_array as $j){
					$db->save(array (
						'word1' => $this->process_words(f('word1')),
						'word2' => $this->process_words($j),
						'relation' => f('relation'),
						'who'=>$who
					));
				}
			}
			$this->to_path('?who='.$who.'&type=relation&word='.urlencode($this->process_words(f('word1'))));
		}
		
		
		$all=$db->peeks(array('who'=>$who));
		$level=count($all);
		$words=array();
		foreach($all as $i){
			$words[]=$i['word1'];
			$words[]=$i['word2'];
		}
		
		$words=array_unique($words);
		sort($words);
		$this->sv('words',$words);
		$this->sv('all',$all);
		
		$this->sv('level',$this->levelstr($level));
		
		
		if ($type == 'relation') {
			$frwords=array();
			$brwords=array();
			$word=f('word');
			foreach($all as $i){
				if($i['word1']==$word){					
					$frwords[]=array('id'=>$i['id'],'word'=>$i['word2'],'relation'=>str_replace(' ','&nbsp;',e($i['relation'])));
				}
				if($i['word2']==$word){					
					$brwords[]=array('id'=>$i['id'],'word'=>$i['word1'],'relation'=>str_replace(' ','&nbsp;',e($i['relation'])));
				}
			}
			$frwords=array_unique($frwords);
			$brwords=array_unique($brwords);				
			$this->sv('frwords',$frwords);
			$this->sv('brwords',$brwords);
		}
		

	}

}
?>