<?php
class temp_controller extends application {

	function filter($method) {
		if ($method!="fangzi2" && $_SERVER[REMOTE_ADDR] != "127.0.0.1") {
			echo "You are fobbiden to access";
			exit;
		}
	}

	function hasmany() {
		$a = $this->model("users")->peek(array (
			"id" => 96
		));

		$this->sv("user", $a);
	}

	function test2() {
		/*var_dump($this->model("users")->peeks());
		echo $this->underscore("AaaBbbCccA"),"<br>";
			
		echo get_class($this);
		$this->{SSS}="dddd";
		echo $this->SSS;
		echo var_dump(get_class_methods($this));
		echo var_dump(get_class_methods('application'));
		$this->sf("_share/dumy");*/
	}

	function underscore($camelCasedWord) {
		//return strtolower(preg_replace('/([a-z0-9])([A-Z])/', '\\1_\\2', $camelCasedWord));
		return strtolower(preg_replace('/([A-Z])(?=\\w)/', '_\\1', $camelCasedWord));
	}

	function webspider() {
		$from = f("start");
		$end = f("end");
		$str = $this->exURL(f('url'), $from, $end);
		echo e($str);
		if (f('file')) {
			$this->save2($str, f('file'));
		}
		exit;
	}

	protected function save2($str, $file) {
		$handle = fopen(ROOT . 'data/temp/' . $file, 'a');
		fwrite($handle, "<hr><h3>" . f('url') . "</h3>" . $str . "\n");
		fclose($handle);
	}

	function pic() {
		for ($i = 2; $i <= 9; $i++) {
			echo "<img src='/self/temp/test2?url=" . urlencode("http://jp.hjenglish.com/page/57030/?page=$i") . "'><br>\n";
		}
		exit;
	}

	function index() {
		echo '<meta http-equiv="Content-Type" content="text/html;charset=Shift_JIS" />';
		$filelist = search_dir(ROOT . "data/temp/");
		echo "<ul>";
		foreach ($filelist as $i) {
			//$i=mb_convert_encoding($i, "UTF-8", 'SJIS');
			echo "<li><a href=/self/data/temp/$i target=_blank>$i</a>&nbsp;(" . (filesize(ROOT . "data/temp/$i") / 1000) . "k)";
			if (preg_match('/JP3/i', $i)) {
				echo '<b><font color=red>(3)</font></b>';
			}
			elseif (preg_match('/SanJi/i', $i)) {
				echo '<b><font color=red>(3 You Jiang Jie)</font></b>';
			}
			elseif (preg_match('/JP2/i', $i)) {
				echo '<b><font color=red>(2)</font></b>';
			}
			elseif (preg_match('/JPYi/i', $i)) {
				echo '<b><font color=red>(1)</font></b>';
			} else {
				echo '<b><font color=red>(You Jiang Jie)</font></b>';
			}
			echo "</li>";
		}
		echo "</ul>";
		exit;
	}

	function fangzi() {
		$db = $this->fmodel("shanghaifangchan");
		$all = $db->peeks(array ());
		$sec=5;
		$path='/temp/fangzi?ddd='.time();
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$sec; URL=$path\">";
		echo "<a href=/filecms/shanghaifangchan>see</a><br>";
		$count=4;
		foreach($all as $detail){
			if(!$detail['price']){
				if($count--<0){				
					break;//$this->jump('/temp/fangzi?ddd='.time(),'go to next 10',5,'<br><iframe src=/filecms/shanghaifangchan/?order=updated_at width=900 height=700></iframe>');
				}else{
					//$this->logme($detail);		
				}
				$str="";
				$matches=array();
				$matches2=array();
				$matches3=array();
				$str=$this->url2str2('http://newhouse.sh.soufun.com/house/' . $detail[id]);
				$str=mb_convert_encoding($str,'utf8','gb2312');	
				preg_match_all('/<td[^>]*><strong>([^<]*)<\/strong>([^<]*)<\/td>/i', $str, $matches);
				$detail['other']="({$matches[2][4]}){$matches[2][3]} | ".join('::',$matches[2]);
		
				$detail['price']=1;
				if(preg_match_all('/<strong style="font-size:12px;">当前价格 <\/strong>均价<span style="font-size:16px;color:#f00;">([0-9]*)<\/span>/i', $str, $matches2)){
					$detail['price']=$matches2[1][0];
				}
				if(preg_match_all('/<strong style="font-size:16px;color:#f00;">([0-9]*)<\/strong>元\/平方米/i', $str, $matches3)){
					$detail['price']=$matches3[1][0];
				}
				if(!$detail['price']){
					$detail['price']=1;
				}
				$db->save($detail);
				//$this->log($detail);
				echo $detail['id'],'<br>';
			}
		}
		echo '<br><iframe src=/filecms/shanghaifangchan/?order=updated_at width=900 height=700></iframe>';
		exit;
	}
	
	function fangzi2() {
		$db = $this->fmodel("nanjingfangchan");
		$all = $db->peeks(array ());
		$sec=5;
		$path='/temp/fangzi2?ddd='.time();
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$sec; URL=$path\">";		
		echo "<a href=/filecms/nanjingfangchan>see</a><br>";
		$count=4;
		
		foreach($all as $detail){
			if(!$detail['price']){
				if($count--<0){	
					break;			
					//$this->jump('/temp/fangzi2?ddd='.time(),'go to next 10',5,'<br><iframe src=/filecms/nanjingfangchan/?order=updated_at width=900 height=700></iframe>');
				}else{
					//$this->logme($detail);		
				}
				$str="";
				$matches=array();
				$matches2=array();
				$matches3=array();
				$str=$this->url2str2('http://nanjing.soufun.com/house/' . $detail[id]);
				$str=mb_convert_encoding($str,'utf8','gb2312');	
				preg_match_all('/<td[^>]*><strong>([^<]*)<\/strong>([^<]*)<\/td>/i', $str, $matches);
				$detail['other']="({$matches[2][4]}){$matches[2][3]} | ".join('::',$matches[2]);
		
				$detail['price']=1;
				if(preg_match_all('/<strong style="font-size:12px;">当前价格 <\/strong>均价<span style="font-size:16px;color:#f00;">([0-9]*)<\/span>/i', $str, $matches2)){
					$detail['price']=$matches2[1][0];
				}
				if(preg_match_all('/<strong style="font-size:16px;color:#f00;">([0-9]*)<\/strong>元\/平方米/i', $str, $matches3)){
					$detail['price']=$matches3[1][0];
				}
				if(!$detail['price']){
					$detail['price']=1;
				}
				$db->save($detail);
				//$this->log($detail);
				echo $detail['id'],'<br>';
			}
		}
		
		echo '<br><iframe src=/filecms/nanjingfangchan/?order=updated_at width=900 height=700></iframe>';
	
		exit;
	}
	
	
	function fangziqingdao() {
		$db = $this->fmodel("qingdaofangchan");
		$all = $db->peeks(array ());
		$sec=5;
		$path='/temp/fangziqingdao?ddd='.time();
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$sec; URL=$path\">";
		echo "<a href=/filecms/qingdaofangchan>see</a><br>";
		$count=4;
		foreach($all as $detail){
			if(!$detail['price']){
				if($count--<0){				
					break;//$this->jump('/temp/fangzi?ddd='.time(),'go to next 10',5,'<br><iframe src=/filecms/shanghaifangchan/?order=updated_at width=900 height=700></iframe>');
				}else{
					//$this->logme($detail);		
				}
				$str="";
				$matches=array();
				$matches2=array();
				$matches3=array();
				$str=$this->url2str2('http://newhouse.qd.soufun.com/house/' . $detail[id]);
				$str=mb_convert_encoding($str,'utf8','gb2312');	
				preg_match_all('/<td[^>]*><strong>([^<]*)<\/strong>([^<]*)<\/td>/i', $str, $matches);
				$detail['other']="({$matches[2][4]}){$matches[2][3]} | ".join('::',$matches[2]);
		
				$detail['price']=1;
				if(preg_match_all('/<strong style="font-size:12px;">当前价格 <\/strong>均价<span style="font-size:16px;color:#f00;">([0-9]*)<\/span>/i', $str, $matches2)){
					$detail['price']=$matches2[1][0];
				}
				if(preg_match_all('/<strong style="font-size:16px;color:#f00;">([0-9]*)<\/strong>元\/平方米/i', $str, $matches3)){
					$detail['price']=$matches3[1][0];
				}
				if(!$detail['price']){
					$detail['price']=1;
				}
				$db->save($detail);
				//$this->log($detail);
				echo $detail['id'],'<br>';
			}
		}
		echo '<br><iframe src=/filecms/qingdaofangchan/?order=updated_at width=900 height=700></iframe>';
		exit;
	}

}
?>