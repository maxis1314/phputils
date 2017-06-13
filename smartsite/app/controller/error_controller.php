<?php
class error_controller extends application {
	
	function pub($params){
		$a=array();
		foreach($params as $i){
			$a[]=get_w($i);
		}
		$this->sf("_pub/".join("/",$a));
	}
	
	function index(){				
		echo $this->get_client_info();
		echo $_SERVER["REMOTE_ADDR"];
		exit;	
	}
	
	function jslist(){
		
	}
	
	function contact(){
		$msg=p('msg');
		$this->kdmail(array(
			'from'=>'demo@self.com',
			'to'=>$this->config["site"]["mail"],
			'subject'=>'demo',
			'msg'=>trucate(nl2br($msg.$this->get_client_info()),2000)
		));
		exit;
	}
	
	function test(){
		var_dump($_POST);
		echo "<hr>";
		var_dump($_GET);
		//echo $this->getIP();
		echo $_SERVER[HTTP_USER_AGENT];
		exit;		
	}
	
	function rd(){
		$url=f("url")?f("url"):"/";
		$url=preg_replace('/<|>/',"",$url);
		$this->jump($url);
	}
	
	function another($params){
		//return new ControlUnit("redirect_action",array("file","index",$params)); 
	}
	
	function collectjs(){
		
	}
	function collecter(){
		$type=p("type");
		$url=p("url");
		$title=p("title");
		$content=p("content");
		$other=p("other");
		if(!$title){
			$title=trucate($content,60);
		}
		$title2=trucate($title,33);
		if($type && $title && $content && $url){
			if($type=="todo"){
				$this->model("private")->save(array(
					"title"=>$title,
					"body"=>$content."\n\n".$url
				));
			}
			if($type=="url"){				
				$this->model("collection")->save(array(
					"url"=>$url,
					"title"=>$title,
					"comment"=>$content
				));
			}
			if($type=="blogger"){
				$this->kdmail(array(
					"from"=>"self@self.com",
					"to"=>''.$other.'@blogger.com',
					"subject"=>e("[ZZ]$title2"),
					"msg"=>nl2br(e($content.""))
					)
				);
			}
			if($type=="blog"){
				$this->model("somewordsjp")->save(array(
					"title"=>$title2,
					"content"=>$content,
					"name"=>"2@test.com"
				));
			}
			if($type=="priv"){
				//if($title && $content && $content!="null"){
					$this->model("private")->save(array(
						"title"=>$title,
						"body"=>$content.$this->get_client_info()
					));
				//}
				exit;
			}
			if($type=="mailto"){
				$this->kdmail(array(
					"from"=>$this->config["site"]["mailt"],
					"fromname"=>"TANG",
					"to"=>p('other'),
					"subject"=>e($title2),
					"msg"=>nl2br(e($content))//."  \n\nBy Hpx $url")						
					)
				);
			}
			if($type=="ruby"){
				$handle = fopen(ROOT."../lang-jp.txt", 'a');
				fwrite($handle, "$other,$content\n"); 
			}
			if($type=="baodu"){				
				$this->to_path("http://zhidao.baidu.com/q?ct=17&pn=0&tn=ikask&rn=12&word=%C8%D5%D3%EF%CE%CA%CC%E2&cm=1&lm=394496");
				exit; 
			}
			$this->to_path($url);
		}
		
		$this->to_path("/");
	}
	
	function blackhole(){		
		$type=f('type');
		if($type=="bendi"){
			$this->sv('doctitle','data[title]');
			$this->sv('docurl','data[url]');
			$this->sv('selected','data[content]');
			$this->sv('posturl','http://localhost:5558/self/file/add');
			return;			
		}
		if($type=="ruby"){
			$this->sv('selected','ok');
			$this->sv('param1','add');
			$this->sv('value1',f('add'));
			$this->sv('param2','lang');
			$this->sv('value2',f('lang'));
			
			$this->sv('param3','gongsi');
			$this->sv('value3',f('gongsi'));
			
			$this->sv('param4','simple');
			$this->sv('value4',f('simple'));
			
			
			$this->sv('docurl','url');
			$this->sv('posturl','http://wx.mim1314.com/admin/rubyjp');
			return;			
		}		
		
		$this->to_path("/");
	}

	function getjs(){
		$cv=get_cookie('maeuse');
		$this->sv('maeuse',$cv);
	}
	
	function getjsinline($params){
		if($params[0]=="en"){
			$lines=file(ROOT."../lang-en.txt");	
		}else{
			$lines=file(ROOT."../lang-jp.txt");
		}
		
		$jparray=array();
		$has_replcaed=array();
		$sort=array();
		foreach($lines as $i){
			$i=chop($i);
			$sort[$i]=strlen($i);			
		}
		
		asort($sort);
		
		foreach($sort as $i => $val) {			
			$temp=explode(',',$i);
			if(!$has_replcaed[$temp[1]]){
				$has_replcaed[$temp[1]]=1;
				$jparray[]=$temp;	
			}					
		}
		$this->sv("replace",$jparray);		
	}
	
	function answer(){
		$question=f("word");
		$str=$this->url2str('http://www.google.com/search?hl=zh-CN&start=10&q='.urlencode($question));
		$str= preg_replace('/<img[^>]*>/i','',$str);
		$str= preg_replace('/<ul[^>]*>/i','',$str);
		$str= preg_replace('/<\/ul[^>]*>/i','',$str);
		$str= preg_replace('/<li[^>]*>/i','',$str);
		$str= preg_replace('/<\/li[^>]*>/i','',$str);
		
		$str= preg_replace('/<a[^>]*>[^<]*<\/a>/i','',$str);
		
		
		$str= preg_replace('/<iframe[^>]*>/i','',$str);
		$str= preg_replace('/<EMBED[^>]*>/i','',$str);
		$str= preg_replace('/<object[^>]*>/i','',$str);
		$str= preg_replace('/<script[^>]*>[^<]*<\/script>/i','',$str);
		
		$str= preg_replace('/<[^>]*>/i','',$str);
		$str= preg_replace('/.*搜索结果/i','',$str);
		$str= preg_replace('/[\/0-9a-zA-Z\?]/i','',$str);
		$str= str_replace(array('百度','知道','zhidao.baidu.com','.','-','下一页','上一页','&;'),'',$str);
		
		echo substr($str,60,300); 
		exit;
	}
	
	
}

?>