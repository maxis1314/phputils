<?php
class gu_controller extends application {
	
	protected $table_name;
	protected $modeldb;
	protected $table_detail;
	protected $table_cols=array();
		
	function filter($method){		
		if($_SERVER[REMOTE_ADDR]!="127.0.0.1"){
			echo "You are fobbiden to access";
			exit;
		}		
	
		$this->table_name = 'gu';
		$this->sv("table_name",$this->table_name);
		$this->modeldb=$this->fmodel($this->table_name);
		$this->table_detail=$this->modeldb->detail();
		foreach($this->table_detail as $i){
			$this->table_cols[$i['name']]=1;
		}
		$this->sv("table",$this->table_detail);
	}
	
	
	function index(){
		$order=f('order');
		if(! $this->table_cols[$order]){
			$order='id';
		}
		$pagedata = $this->modeldb->peeks(array());
		
		$allnum = count($pagedata);
		$foot = pagerfoot(f("page"), $pagedata, PREFIXURL."/".$this->ctl.'/?order='.$order, 30, 11, "<br>");
		$allsunyi=0;
		$allziben=0;
		foreach($foot["data"] as &$i){
			$i["sunyi"]=($i['gunow']-$i['guin'])*$i['gushu'];
			$allsunyi+=$i["sunyi"];
			$allziben+=$i['guin']*$i['gushu'];
			$i["sunyilv"]=sprintf('%.2f',100*$i["sunyi"]/($i['guin']*$i['gushu']));
			$i["gujiaolv"]=sprintf('%.1f',100*$i['gujiao']/$i['guliang']);//$i['gujiao'].$i['guliang'];
		}
		$this->sv("list",$foot["data"]);
		$this->sv("allsunyi",$allsunyi);
		$this->sv("allziben",$allziben);
		$this->sv("foot", $foot["pagecode"]);
		$this->sv("headtitle", $allsunyi);
	}
	
	function search(){
		if($this->is_post() && p('key')){
			$detail=$this->modeldb->detail();
			$search_r=array();
			$search_r=array();
		$search_r['id']=p('key');
			$search_r['guid']=p('key');
			$search_r['gushu']=p('key');
			$search_r['guin']=p('key');
			$search_r['gunow']=p('key');
			$search_r['comment']=p('key');
	
			$pagedata=$this->modeldb->peeks_like($search_r);
			$this->sv("list",$pagedata);
			$this->sf("gu/index");		
		}else{
			$this->to_path(PREFIXURL."/".$this->ctl."/");
		}
	}
	
	function add(){
		if($this->is_post()){
			$data=p("data");						
			if($this->modeldb->peek(array("guid"=>$data['guid']))){
				$this->jump("/gu/add","data exist.",3);
			}			
			
			$datadb=array();
		$datadb['id']=$data['id'];
			$datadb['guid']=$data['guid'];
			$datadb['gushu']=$data['gushu'];
			$datadb['guin']=$data['guin'];
			$datadb['gunow']=$data['gunow'];
			$datadb['comment']=$data['comment'];
			$datadb['danwei']=$data['danwei'];
	

			$re=$this->modeldb->save($datadb);
			if($re){
				$this->jump("/gu/add","data added.");
			}else{				
				$this->sv("error_field",$this->modeldb->error_detail());				
			}	
		}
	}
	function show($params){
		$params[0]=daxie2xiaoxie($params[0]);
		$data=$this->modeldb->peek(array("guid"=>$params[0]));
		$this->sv("data",$data);
		$data2=$this->fmodel("gu_his")->peeks(array("guid"=>$data['guid']));
		//var_dump($data2);exit;
		
		$datayesterday=$data2[1];
		$datatoday=$data2[0];		
		
		$preditdown=-($datayesterday["gunow"]-$datatoday["guxiao"])+$datatoday["gunow"];
		$preditup=(-$datayesterday["gunow"]+$datatoday["guda"])+$datatoday["gunow"];
		$this->sv("preditdown",$preditdown);
		$this->sv("preditup",$preditup);
		$singleday=$this->fmodel("gu_his")->peek(array('guid'=>$data['guid'],'date'=>date("Y-m-d")));
		$singleday['preditdown']=$preditdown;
		$singleday['preditup']=$preditup;
		$this->fmodel("gu_his")->save($singleday);
		
		
		$x=array();
		$y=array();		
		$z=array();
		$v=array();
		$upjiaoliang=0;
		$downjiaoliang=0;
		foreach($data2 as &$i){
			if($i["gubian"]>0){				
				$upjiaoliang+=$i['gujiao'];
			}else{
				$downjiaoliang+=$i['gujiao'];
			}
			$x[]=$i['gujiao'];
			$y[]=$i['price'];
			$z[]=$i['buyleft']-$i['sellleft'];
			if($i['guda']>$i['guxiao']){
				$v[]=abs($i['guda']-$i['guxiao']);
			}else{
				$v[]=0;
			}
			
			
			$i["sunyi"]=($i['gunow']-$i['guin'])*$i['gushu'];
			$i["sunyilv"]=sprintf('%.2f',100*$i["sunyi"]/($i['guin']*$i['gushu']));
			$i["gujiaolv"]=sprintf('%.2f',100*$i['gujiao']/$i['guliang']);//$i['gujiao'].$i['guliang'];
		}
		
		$y=$this->getDataForGraph($y);
		$x=$this->getDataForGraph($x);
		$z=$this->getDataForGraph($z);
		$v=$this->getDataForGraph($v);			
		
		$this->sv("headtitle", $data2[0]['sunyi'].':'.$data2[0]['sunyilv'].'%'.'('.($data2[0]['gunow']-$data2[0]['fududown']).','.($data2[0]['fuduup']-$data2[0]['gunow']).')'.$data2[0]['gunow'].":".$data2[0][gujiaolv]);
		
		$this->sv("x",join(',',array_reverse($x)));
		$this->sv("y",join(',',array_reverse($y)));
		$this->sv("z",join(',',array_reverse($z)));
		$this->sv("v",join(',',array_reverse($v)));
		$this->sv("data2",$data2);
		$this->sv("upjiaoliang",$upjiaoliang);
		$this->sv("downjiaoliang",$downjiaoliang);
		$this->sv("gulianghe",$data2[0]['guliang']);
		
		$shijian=date("G")+date("i")/100;
		if($shijian<9 || ($shijian>11 && $shijian<13) || $shijian>15){
			$this->sv("stop","T");
		}
		
	}
	
	
	function showgraph(){
		$pagedata = $this->modeldb->peeks(array());
		$dbhis=$this->fmodel("gu_his");
		foreach($pagedata as &$i){
			$price=$dbhis->peek_col(array("guid"=>$i['guid']),"price");
			$gujiao=$dbhis->peek_col(array("guid"=>$i['guid']),"gujiao");
			$price=$this->getDataForGraph($price);
			$gujiao=$this->getDataForGraph($gujiao);
			$i['g_price']=join(',',array_reverse($price));
			$i['g_gujiao']=join(',',array_reverse($gujiao));
		}
		//var_dump($pagedata);exit;
		$this->sv("data",$pagedata);
	}
	
	private function getDataForGraph($ra){
		$max=max($ra);
		$min=min($ra);
		foreach($ra as &$i){
			$i=100*($i-$min)/($max-$min);
		}
		return $ra;
	}
	
	function edit($params){		
		if($this->is_post()){
			$data=p("data");
			$datadb=array();
		$datadb['id']=$data['id'];
			$datadb['guid']=$data['guid'];
			$datadb['gushu']=$data['gushu'];
			$datadb['guin']=$data['guin'];
			$datadb['gunow']=$data['gunow'];
			$datadb['comment']=$data['comment'];
			$datadb['fenxi']=$data['fenxi'];
			$datadb['danwei']=$data['danwei'];
	
			if(f("inguprice") && f("ingunum")){
				$datadb['guin']=($datadb['guin']*$datadb['gushu']+f("inguprice"))/($datadb['gushu']+f("ingunum"));
				//echo $datadb['guin'];exit;
				$datadb['gushu']=$datadb['gushu']+f("ingunum");
			}

			$re=$this->modeldb->save($datadb);
			if($re){
				$this->jump(PREFIXURL."/".$this->ctl."/show/".get_w($data[guid]),"data updated.");
			}else{
				$this->sv("error_field",$this->modeldb->error_detail());
			}
			$this->sv("data",p("data"));
		}else{
			$this->sv("data",$this->modeldb->peek(array("guid"=>$params[0])));
		}
	}
	function sync($params){
		$params[0]=daxie2xiaoxie($params[0]);		
		$this->sync_one($params);
		return new ControlUnit("redirect_action",array("gu","show",$params));
	}
	
	function sync_all(){
		$pagedata = $this->modeldb->peeks(array());
		foreach($pagedata as $i){
			$this->sync_one(array($i['guid']));
		}	
		return new ControlUnit("redirect_action",array("gu","index"));
	}
	
	function sync_one($params){
		$data=$this->modeldb->peek(array("guid"=>$params[0]));
	
		$url='http://stocks.finance.yahoo.co.jp/stocks/detail/?code='.$data['guid'];
		$str=$this->url2str($url);
	    
     	preg_match('/<span class="yjFL">([0-9,]+)<\/span>/',$str,$matches);		
		$data['gunow']=str_replace(",","",$matches[1]);	
		
		preg_match_all('/<dd class="ymuiEditLink mar0"><strong>(.*)<\/strong>/',$str,$matches);		
		//preg_match_all('/<dd class="ymuiEditLink mar0"><strong>([0-9,]+)<\/strong>/',$str,$matches);
		$data['gujiao']=str_replace(",","",$matches[1][2]);
		
		$data['sellleft']=str_replace(",","",$matches[1][15]);	
		$data['buyleft']=str_replace(",","",$matches[1][13]);		


		$data['guliang']=str_replace(",","",$matches[1][6]);
		
		$data['per']=preg_replace('/.* /',"",$matches[1][9]);		
		$data['pbr']=preg_replace('/.* /',"",$matches[1][10]);
		
		$fudu=explode('～',$matches[1][4]);
		$data['fuduup']=str_replace(",","",$fudu[1]);
		$data['fududown']=str_replace(",","",$fudu[0]);
		
		preg_match_all('/<dd class="ymuiEditLink mar0">\n<strong>(.*)<\/strong>/',$str,$matches);
		$data['guda']=str_replace(",","",$matches[1][0]);
		$data['guxiao']=str_replace(",","",$matches[1][1]);
		
		preg_match_all('/<strong class="redFin">([0-9,\-\.]+)<\/strong>/',$str,$matches);		
		if(!$matches[1][0]){
			preg_match_all('/<strong class="greenFin">([0-9,\-\.\+]+)<\/strong>/',$str,$matches);
		}
		$data['gubian']=str_replace(",","",$matches[1][0]);
		$data['gubianlv']=str_replace(",","",$matches[1][1]);
		
		
		
		preg_match_all('/<strong class="yjL">\n([^<]+)/',$str,$matches);
		
		$data['guming']=str_replace("(株)","",$matches[1][0]);
		
		$re=$this->modeldb->save($data);
		
		$data['price']=$data['gunow'];
		$data['date']=date("Y-m-d");
		$data['id']=null;
		$singleday=$this->fmodel("gu_his")->peek(array('guid'=>$data['guid'],'date'=>date("Y-m-d")));
		if($singleday && $singleday['id']){
			$data['id']=$singleday['id'];
		}
		$re=$this->fmodel("gu_his")->save($data);
		
		if(false && $data["fenxi"]>0 && date("G")>=16 && !file_exists(ROOT."public/gu/$params[0]-".date("Y-m-d").".png")){
			$this->get_url_pic2("http://money.www.infoseek.co.jp/MnStock/$params[0]/schart/","public/gu/$params[0]-".date("Y-m-d").".png",450);
		}
		
	}
	
	function delete($params){		
		$this->modeldb->peek_del(array("id"=>$params[0]));
		$this->jump(PREFIXURL."/".$this->ctl."/?showdetail=1","data deleted.");
	}
	
	function deletemulti(){
		$ids=p('selectids');
		foreach($ids as $id){			
			$this->modeldb->peek_del(array("id"=>$id));
		}
		$this->jump(PREFIXURL."/".$this->ctl."/","data deleted.");
	}
	
	
	function download(){
		$detail=$this->modeldb->detail();
		$all=$this->modeldb->peeks();
		$str='';
		$arr=array();
		foreach($detail as $j){
			$arr[]=$j['name'];
		}
		$str=join(",",$arr);
		foreach($all as $i){
			$arr=array();
			foreach($detail as $j){
				$arr[]=preg_replace('/\r|\n/',"",$i[$j['name']]);
			}
			$str.="\n".join(",",$arr);
		}
		View::download_str($this->table_name.'.csv',$str);
		exit;
	}
	
	
	function amuse($params){		
		$this->sv("a",'C:\workspace\rubish\drop\My Dropbox\private\japanese\ja_level_one\1级(001-017).mp3');
	}
	
	function bunnseki(){
		$all=$this->fmodel('blog')->peeks();
		var_dump($all);exit;
	}
	
}

?>

