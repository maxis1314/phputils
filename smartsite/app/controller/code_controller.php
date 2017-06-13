<?php
class code_controller extends application {
	function filter($method) {
		if ($_SERVER[REMOTE_ADDR] != "127.0.0.1") {
			//echo "You are fobbiden to access";
			//exit;
		}
	}

	function index() {
		$dsn = array ();
		$this->sv("rooturl",preg_replace('/&t=.*/','',$_SERVER['REQUEST_URI']));
		
		if (f('submit')) {
			$dsn['dbHost'] = either(f("host"), "localhost");
			$dsn['port'] = either(f("port"), 3306);
			$dsn['dbHost'] .= ":" . $dsn['port'];
			$dsn['dbName'] = either(f("db"), "dev");
			$dsn['dbUser'] = either(f("user"), "root");
			$dsn['dbPswd'] = either(f("pass"), '');
			$dsn["charset"] = "";

			include_once (ROOT . "lib/vip/DBUtil.php");
			$db = new DB($dsn);
			include_once (ROOT . "app/main/model.php");
			$modelobj = new model($db);
			
			$this->sv("dsn", $dsn);

			try {
				$this->sv("table_list", $modelobj->table_names());
				$table=f('t');
				if($table){
					$modelobj->change_table($table);
					$table_detail=$modelobj->detail();
					$this->sv("table_detail",$table_detail);
					
				}
			} catch (Exception $e) {
				$this->sv("info", $e->getMessage());
			}
		}
	}
	
	function tool(){
		$this->sv('blog',$this->model('mvc_blog')->peeks(array("delete_flag is null or delete_flag <> ?"=>1),'id desc',10));
		$this->sv('comment',$this->model('mvc_comment')->peeks(null,'id desc',10));	
		
	}

	private function java($code) {
		return $code;
	}

	private function php($code) {
		return $code;
	}
	
	function xml2form(){
		$this->sv("str",file_get_contents(ROOT."data/xml/contact.xml"));
	}
	
	function english($params){
		$db=$this->fmodel('anything');
		if(!f('id') and !$params[0]){
			$record=$db->save(
				array(				
				'content'=>''
				)
			);
			$this->to_path('/code/'.$this->action.'/'.$record['id']);
		}else{
			$record=$db->peek_create(array('id'=>$params[0]));
		}
		
		
		if($this->is_post()){
			$db->save(
				array(
				'id'=>f('id'),
				'content'=>f('content')
				)
			);
			exit;
		}
		
		$this->sv('record',$record);
		$this->sv('transferurl','http://translate.google.com/translate_t#ja|zh-CN|');
	}
	function englishja($params){
		$this->english($params);
		$this->sf('code/english');
		$this->sv('transferurl','http://translate.google.com/translate_t#en|ja|');
	}
	function english2($params){
		$this->english($params);
		$this->sf('code/english2');
		$this->sv('transferurl','http://fanyi.cn.yahoo.com/translate_txt?ei=UTF-8&fr=&lp=en_zh&trtext=');
	}
	function dn($params){
		$db=$this->fmodel('anything');
		$record=$db->peek(array('id'=>$params[0]));
		if($record){
			View::download_str("$params[0].txt",$record['content']);
		}
		exit;
	}
	function show($params){
		$db=$this->fmodel('anything');
		$record=$db->peek(array('id'=>$params[0]));
		if($record){
			echo $record['content'];
		}
		exit;
	}
	function blogger($params){
		$db=$this->fmodel('anything');
		$record=$db->peek(array('id'=>$params[0]));
		if($record){
			$this->kdmail(array(
				"from"=>"self@self.com",
				"to"=>'maxis1314.'.$params[1].'@blogger.com',
				"subject"=>substr($record['content'],0,20),
				"msg"=>nl2br(e($record['content']))
				)
			);
		}
		echo "sent<hr>";
		echo $record['content'];
		$record['content']="";
		$db->save($record);
		exit;
	}
	
	function resume($params){
		$list=$this->fmodel('jianli')->peeks(array('lang'=>'jp'));
		usort($list,"cmpfilestr");
		$this->sv('listjp',array_reverse($list));
		
		$list=$this->fmodel('jianli')->peeks(array('lang'=>'cn'));
		usort($list,"cmpfilestr");
		$this->sv('listcn',array_reverse($list));
		
		$list=$this->fmodel('jianli')->peeks(array('lang'=>'en'));
		usort($list,"cmpfilestr");
		$this->sv('listen',array_reverse($list));
	}
	
	function resume_edit($params){
		$db=$this->fmodel('jianli');
		$record=$db->peek(array("id"=>$params[0]));
		$recorden=$db->peek(array("period"=>$record['period'],'lang'=>'en'));
		$recordjp=$db->peek(array("period"=>$record['period'],'lang'=>'jp'));
		$recordcn=$db->peek(array("period"=>$record['period'],'lang'=>'cn'));
		$this->sv('recorden',$recorden);
		$this->sv('recordjp',$recordjp);
		$this->sv('recordcn',$recordcn);
	}
	
	function resume2(){
		$this->resume();
	}

}

function cmpfilestr($a, $b)
{
	$order='period';
    return strcmp($a[$order], $b[$order]);
}
?>