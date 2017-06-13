<?php
class scaffold extends application {

	protected $table_name;
	protected $modeldb;
	protected $charset;
	protected $table_detail;
	protected $table_cols = array ();

	function filter($method) {
		if (!$this->table_name) {
			$this->to_path(PREFIXURL . '/');
			exit;
		}
		$this->sv("table_name", $this->table_name);
		$this->modeldb = $this->model($this->table_name, $this->charset);
		$table_detail = $this->modeldb->detail();

		foreach ($table_detail as  & $i) {
			$this->table_cols[$i['name']] = 1;
		}
		$this->table_detail=$table_detail;
		
		$this->sv("table", $this->table_detail);
	}

	function index() {
		$order = f('order');
		if (!$this->table_cols[$order]) {
			$order = $this->table_detail[0]['name'];
		}
		$pagedata = $this->modeldb->peeks_page(array (), "`$order` desc", f("page"), 20);
		$allnum = $this->modeldb->peek_num(array ());
		$foot = pagerfoot2(f("page"), $allnum, PREFIXURL . "/" . $this->ctl . "/" . $this->action . '/?order=' . $order, 20, 11, "<br>");
		
		foreach ($pagedata as & $i) {
			$i = array_change_key_case($i, CASE_LOWER);
		}
		$this->sv("list", $pagedata);
		$this->sv("foot", $foot["pagecode"]);
		$this->sf("scaffold/index");
		if ($this->format == "xml") {
			$this->outXML($pagedata);
		}
		if ($this->format == "fpdf") {
			$this->outPDFTABLE($pagedata);
		}
	}

	function index_cool() {
		$this->index();
		$this->sf("scaffold/index_cool");
	}

	function search() {
		//if ($this->is_post() && f('key')) {
		if (f('key')) {
			$detail = $this->modeldb->detail();
			$search_r = array ();
			foreach ($detail as $i) {
				$search_r[$i['name']] = f('key');
			}
			$pagedata = $this->modeldb->peeks_like($search_r);
			foreach ($pagedata as & $i) {
				$i = array_change_key_case($i, CASE_LOWER);
			}
			
			if ($this->format == "javaform") {			
				$this->downloadfile($pagedata,$detail);
				exit;
			}
			
			$this->sv("list", $pagedata);
			$this->sf("scaffold/index");
		} else {
			$this->to_path(PREFIXURL . "/" . $this->ctl . "/");
		}
	}

	function form() {
		$this->sf("scaffold/form");
	}
	function search_adv() {
		if ($this->is_post()) {
			$detail = $this->modeldb->detail();
			$search_r = array ();
			$search_and = array ();
			$search_like = array ();
			$data = p("data");
			foreach ($detail as $i) {
				$op = p('op_' . $i['name']);
				if ($data[$i['name']]) {
					if ($op == 1) { //=
						$search_and[$i['name']] = $data[$i['name']];
					}
					if ($op == 2) { //>
						$search_and[$i['name'] . '>?'] = $data[$i['name']];
					}
					if ($op == 3) { //<
						$search_and[$i['name'] . '<?'] = $data[$i['name']];
					}
					if ($op == 4) { //>=
						$search_and[$i['name'] . '>=?'] = $data[$i['name']];
					}
					if ($op == 5) { //<=
						$search_and[$i['name'] . '<=?'] = $data[$i['name']];
					}
					if ($op == 6) { //like
						$search_like[$i['name']] = $data[$i['name']];
					}
				}
			}
			$search_r = array (
				'and' => $search_and,
				'like' => $search_like
			);

			$pagedata = $this->modeldb->search_advance($search_r);
			$this->sv("list", $pagedata);
			$this->sf("scaffold/index");
		} else {
			$this->sf("scaffold/form");
		}
	}

	function add($params) {
		$data=array();
		if ($params[0]) {
			$data = $this->modeldb->peek(array (
				"id" => $params[0]
			));
		}
		if ($this->is_post()) {
			$data = p("data");
			$re = $this->modeldb->save($data);
			if ($re) {
				$this->jump_cookie(PREFIXURL . "/" . $this->ctl . "/", "data added.");
			} else {
				$this->sv("error_field", $this->modeldb->error_detail());
			}
		}
		foreach($_GET as $i=>$j){
			$data[$i]=$j;
		}
		$this->sv('data', $data);
		
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
	function show($params) {
		$data = $this->modeldb->peek(array (
			"id" => $params[0]
		));
		$this->sv("data", array_change_key_case($data, CASE_LOWER));
		$this->sf("scaffold/show");
		if ($this->format == "xml") {
			$this->outXML(array (
				$data
			));
		}
	}

	function showdetail($params) {
		$data = $this->modeldb->peek(array (
			"id" => $params[0]
		), true);
		$this->sv("data", $data);
		$many = array ();
		if ($hasone = $this->config['hasMany'] { $this->table_name }) {
			foreach ($hasone as $i) {
				$many[] = "many_$i[Name]";
			}
		}

		if ($hasone = $this->config['hasAndBelongsToMany'] { $this->table_name }) {
			foreach ($hasone as $i) {
				$many[] = "many_$i[Name]";
			}
		}
		$this->sv("manyothers", $many);
		$this->sf("scaffold/showdetail");
		//var_dump($data);
	}

	function edit($params) {
		if ($this->is_post()) {
			$data = p("data");
			$re = $this->modeldb->save($data);
			if ($re) {
				$this->jump_cookie(PREFIXURL . "/" . $this->ctl . "/show/" . intval($data[id]), "data updated.");
			} else {
				$this->sv("error_field", $this->modeldb->error_detail());
			}
			$this->sv("data", p("data"));
		} else {
			$data=$this->modeldb->peek(array (
				"id" => $params[0]
			));
			$this->sv("data", array_change_key_case($data, CASE_LOWER));
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
	function delete($params) {
		$this->modeldb->peek_del(array (
			"id" => $params[0]
		));
		
		$this->jump_cookie(PREFIXURL . "/" . $this->ctl . "/", "data deleted.");
	}

	function deletemulti() {
		$ids = p('selectids');
		foreach ($ids as $id) {
			$this->modeldb->peek_del(array (
				"id" => $id
			));
		}
		
		$this->jump(PREFIXURL . "/" . $this->ctl . "/", "data deleted.");
	}

	function upload() {
		$file = $_FILES["userfile"]["tmp_name"];
		if ($file && $this->is_post()) {
			$filearr = file($file);
			$headstr = array_shift($filearr);
			if (!$headstr) {
				$headstr = array_shift($filearr);
			}

			$headarr = explode(",", chop($headstr));
			$line = 1;
			$resultsave = array ();
			foreach ($filearr as $i) {
				$dataarr = explode(",", chop($i));
				$datahash = array ();
				for ($j = 0; $j < count($headarr); $j++) {
					$datahash[strtolower($headarr[$j])] = $dataarr[$j];
				}
				$re = $this->modeldb->save($datahash);
				if ($re) {
					$resultsave[] = "line $line:sucess saved $i";
				} else {
					$resultsave[] = "line $line:<font color=red>fail</font>to save [$i]";
				}
				$line++;
			}
			$this->sv("resultsave", $resultsave);
		}
		$cols=array();
		foreach($this->table_detail as $i){
			$cols[]=$i['name'];
		}
		$this->sv("colstr",join(",",$cols));
		$this->sf("scaffold/upload");
	}

	function download() {
		$detail = $this->modeldb->detail();
		$all = $this->modeldb->peeks();
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

	function code() {
		$this->sv("table_detail", $this->modeldb->detail());
		$this->sv("table_name", $this->table_name);
		$this->sf("scaffold/code");
	}

}
?>