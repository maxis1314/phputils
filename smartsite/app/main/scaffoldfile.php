<?php
class scaffoldfile extends application {
	protected $table_name;
	protected $modeldb;
	protected $table_detail;
	protected $table_cols=array();
		
	function filter($method){
		if(!$this->table_name){			
			$this->to_path(PREFIXURL.'/');
			exit;
		}
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
		if($order && ! $this->table_cols[$order]){
			$order='id';
		}
		$pagedata = $this->modeldb->peeks(json_decode(f('sql'),true));
		
		if($order){
			usort($pagedata, "cmpfilestr");
			$pagedata=array_reverse($pagedata);
		}
		
		$allnum = count($pagedata);
		$foot = pagerfoot(f("page"), $pagedata, PREFIXURL."/".$this->ctl.'/?order='.$order, 20, 11, "<br>");
		
		if(f('showall')){
			$this->sv("list",$pagedata);
		}else{
			$this->sv("list",$foot["data"]);
			$this->sv("foot", $foot["pagecode"]);
		}		
		
		$this->sf("scaffold/index");
		if ($this->format == "xml") {
			$this->outXML($pagedata);
		}
		if ($this->format == "fpdf") {
			$this->outPDFTABLE($pagedata);
		}		
	}
	
	function search(){
		if($this->is_post() && p('key')){
			$detail=$this->modeldb->detail();
			$search_r=array();
			foreach($detail as $i){
				$search_r[$i['name']]=p('key');
			}
			$pagedata=$this->modeldb->peeks_like($search_r);
			
			if ($this->format == "javaform") {			
				$this->downloadfile($pagedata,$detail);
				exit;
			}
			$this->sv("list",$pagedata);
			$this->sf("scaffold/index");			
		}else{
			$this->to_path(PREFIXURL."/".$this->ctl."/");
		}
	}
	
	function form(){
		$this->sf("scaffold/form");
	}
	function search_adv() {		
		if($this->is_post()){
			$detail=$this->modeldb->detail();
			$search_r=array();
			$data = p("data");
			foreach($detail as $i){
				$search_r[$i['name']]=$data[$i['name']];
			}
			$pagedata=$this->modeldb->peeks_like($search_r);
			$this->sv("list",$pagedata);
			$this->sf("scaffold/index");			
		}else{
			$this->sf("scaffold/form");
		}
	}
	
	function add($params){
		if($params[0]){
			$data=$this->modeldb->peek(array("id"=>$params[0]));
		}
		
		if($this->is_post() || f('subfromurl')){
			$data=f("data");
			$re=$this->modeldb->save($data);
			if($re){
				$this->jump_cookie(PREFIXURL."/".$this->ctl."/","data added.");
			}else{				
				$this->sv("error_field",$this->modeldb->error_detail());				
			}	
		}
		$this->sv('data',$data);
		$this->sf("scaffold/add");
		if ($this->format == "javaform") {			
			foreach($this->table_detail as $col){
				$init=$data[$col[name]];
				$init=preg_replace('/\r|\n/', "[CRLF]", $init);
				if($col[name]!="id" && $col[name]!="created_at" && $col[name]!="updated_at" ){
					if($col["type"]=="text" || $col["type"]=="blob" || $col["type"]=="longtext"){
						echo "-n data[$col[name]] -s $col[name] -g TextareaGenerator -i $init\n"; 
					}else{
						echo "-n data[$col[name]] -s $col[name] -g InputTextGenerator -i $init\n";
					}
				}
			}
			exit;
		}
	}
	function show($params){		
		$data=$this->modeldb->peek(array("id"=>$params[0]));			
		$ids=$this->modeldb->peek_col();
		$rownum=count($ids);
		for($i=0;$i<$rownum;$i++){
			if($ids[$i]==$params[0]){
				$this->sv('before',$ids[$i-1]);
				$this->sv('after',$ids[$i+1]);
				break;
			}
		}
		
		$this->sv("data",$data);
		$this->sf("scaffold/show");
		if ($this->format == "xml") {
			$this->outXML(array($data));
		}
		if($params[1] && $data[$params[1]]){
			echo $data[$params[1]];
			if(f('op')=="add"){
				$data[$params[1]]=$data[$params[1]]+1;
				$this->modeldb->save($data);
			}
			if(f('op')=="sub"){
				$data[$params[1]]=$data[$params[1]]-1;
				$this->modeldb->save($data);
			}
			exit;
		}
	}
	function edit($params){		
		if($this->is_post()){
			$data=p("data");
			$re=$this->modeldb->save($data);
			if($re){
				$this->jump_cookie(PREFIXURL."/".$this->ctl."/show/".get_w($data[id]),"data updated.");
			}else{
				$this->sv("error_field",$this->modeldb->error_detail());
			}
			$this->sv("data",p("data"));
		}else{
			$data=$this->modeldb->peek(array("id"=>$params[0]));
			$this->sv("data",$data);
		}
		$this->sf("scaffold/edit");
		if ($this->format == "javaform") {			
			foreach($this->table_detail as $col){
				$init=$data[$col[name]];
				$init=preg_replace('/\r|\n/', "[CRLF]", $init);
				if($col[name]!="id" && $col[name]!="created_at" && $col[name]!="updated_at" ){
					if($col["type"]=="text" || $col["type"]=="blob" || $col["type"]=="longtext"){
						echo "-n data[$col[name]] -s $col[name] -g TextareaGenerator -i $init\n"; 
					}else{
						echo "-n data[$col[name]] -s $col[name] -g InputTextGenerator -i $init\n";
					}
				}else{
					echo "-n data[$col[name]] -s $col[name] -g HiddenGenerator -i $init\n";
				}
			}
			exit;
		}
	}
	function delete($params){		
		$this->modeldb->peek_del(array("id"=>$params[0]));
		$this->jump(PREFIXURL."/".$this->ctl."/","data deleted.");
	}
	
	function deletemulti(){
		$ids=p('selectids');
		foreach($ids as $id){			
			$this->modeldb->peek_del(array("id"=>$id));
		}
		$this->jump_cookie(PREFIXURL."/".$this->ctl."/","data deleted.");
	}
	
	
	function download(){
		$detail=$this->modeldb->detail();
		$all=$this->modeldb->peeks();
		$this->downloadfile($all,$detail);
		exit;
	}
	
	protected function downloadfile($all,$detail){
		$str = '';
		$arr = array ();
		foreach ($detail as $j) {
			$arr[] = $j['name'];
		}
		$str = join(",", $arr);
		foreach ($all as $i) {
			$arr = array ();
			foreach ($detail as $j) {
				$arr[] = preg_replace('/\r|\n/', "[CRLF]", $i[$j['name']]);
			}
			$str .= "\n" . join(",", $arr);
		}
		View :: download_str($this->table_name . '.csv', $str);
		exit;
	}
	
	function code(){
		$this->sv("table_detail",$this->modeldb->detail());
		$this->sv("table_name",$this->table_name);
		$this->sf("scaffold/code");
	}
	
}
function cmpfilestr($a, $b)
{
	$order=f('order');
    return strcmp($a[$order], $b[$order]);
}
?>