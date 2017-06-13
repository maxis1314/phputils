<?php

require_once ("lib/Inflector.php");

class model {
	var $db;
	var $table_name;
	var $check_error;
	var $error_field_name = array ();
	var $error_field = array ();
	var $table_detail;
	var $tables_detail = array ();
	var $raw_data;
	var $config;

	function get_check_filter() {
		return array ();
	}

	function get_logs() {
		return $this->db->logs;
	}

	function detail() {
		return $this->colsOfTable($this->table_name);
	}

	function dumyinsert(){
		$cols=$this->colsOfTable($this->table_name);
		$hash=array();
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));
		foreach($cols as $i){
			if($i['name']!="id"){
				$hash[$i['name']]=rand(0,99);
			}
		}
		$this->save($hash);
	}
	
	function colsOfTable($table) {
		if ($this->tables_detail[$table]) {
			return $this->tables_detail[$table];
		}
		$fields = false;
		$cols = $this->rows('DESCRIBE ' . $table);
		foreach ($cols as $column) {
			if (isset ($column)) {
				$length = "";
				if (preg_match('/\((\d+)\)/', $column['Type'], $matches)) {
					$length = $matches[1];
				}

				$fields[] = array (
					'name' => $column['Field'],
					'type' => preg_replace('/\(.*/', "", $column['Type']),
					'null' => ($column['Null'] == 'YES' ? true : false),
					'default' => $column['Default'],
					'length' => $length,

					
				);
			}
		}
		$this->tables_detail[$table] = $fields;
		return $fields;
	}

	function colsNames($table) {
		$colsdetail = $this->colsOfTable($table);
		$cols = array ();
		foreach ($colsdetail as & $i) {
			$cols[] = "$table.$i[name] as join_" . $table . "_$i[name]";
		}
		return join(',', $cols);
	}

	function check_record($raw) {
		$this->raw_data = $raw;
		$this->clear_error();
		try {
			$filter = $this->get_check_filter();
		} catch (Exception $e) {
			$filter = array ();
		}
		$result = true;
		foreach ($raw as $i => $j) {
			if (isset ($filter[$i])) {
				if (isset ($filter[$i]["method"])) {
					$method = "check_" . $filter[$i]["method"];
					if (!$this-> $method ($i, $j, $filter[$i])) {
						$result = false;
					}
				} else {
					foreach ($filter[$i] as $check_item) {
						$method = "check_" . $check_item["method"];
						if (!$this-> $method ($i, $j, $check_item)) {
							$result = false;
						}
					}
				}
			}
		}
		return $result;
	}

	function check_equal($i, $raw, $option) {
		if ($raw == $this->raw_data[$option['other']]) {
			return true;
		} else {
			$this->add_error($i, $raw, $option, "equal", " is not equal with $option[other]");
			return false;
		}
	}

	function valid($raw) {
		return $this->check_record($raw);
	}
	function error_detail() {
		return $this->error_field;
	}
	function get_error_field() {
		return $this->error_field_name;
	}
	function set_error_field($a) {
		$this->error_field_name = $a;
	}

	function check_int($i, $raw, $option) {
		if ($raw && !preg_match('/^\d+$/', $raw)) {
			$this->add_error($i, $raw, $option, "int", " is not an integer");
			return false;
		} else {
			return true;
		}
	}

	function check_notnull($i, $raw, $option) {
		if ($raw) {
			return true;
		} else {
			$this->add_error($i, $raw, $option, "notnull", " is empty");
			return false;
		}
	}
	function check_email($i, $raw, $option) {
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $raw)) {
			$this->add_error($i, $raw, $option, "email", " is not an email address");
			return false;
		} else {
			return true;
		}
	}

	function check_unique($i, $raw, $option) {
		$rows = $this->rows("select * from " . $this->get_table_name() . " where $i=? limit 1", array (
			$raw
		));
		if (count($rows) > 0) {
			$this->add_error($i, $raw, $option, "unique", " is not unique");
			return false;
		} else {
			return true;
		}
	}

	function check_format($i, $raw, $option) {
		if ($raw && !preg_match($option["format"], $raw)) {
			$this->add_error($i, $raw, $option, "format", " 's format is wrong");
			return false;
		} else {
			return true;
		}
	}

	function check_range($i, $raw, $option) {
		if ($raw) {
			if ($option["max"] && $raw > $option["max"]) {
				$this->add_error($i, $raw, $option, "range", " is too bigger($option[min]~$option[max])");
				return false;
			}
			if ($option["min"] && $raw < $option["min"]) {
				$this->add_error($i, $raw, $option, "range", " is too small($option[min]~$option[max])");
				return false;
			}
			return true;
		} else {
			return false;
		}
	}

	function check_foreign_key($i, $raw, $option) {
		if (!isset ($option["fkey"])) {
			$option["fkey"] = "id";
		}
		if (!isset ($option["key"])) {
			$option["key"] = $option["table"] . "_id";
		}
		$rows = $this->rows("select * from " . $option["table"] . " where $option[fkey]=? limit 1", array (
			$raw[$option[key]]
		));
		if (count($rows) > 0) {
			$this->add_error($i, $raw, $option, "unique", " is not exist in $option[table]");
			return false;
		} else {
			return true;
		}
	}

	function check_include($i, $raw, $option) {
		if (in_array($raw, $option["in"])) {
			return true;
		} else {
			$this->add_error($i, $raw, $option, "include", " is not in the list");
			return false;
		}
	}

	function check_exclude($i, $raw, $option) {
		if (!in_array($raw, $option["in"])) {
			return true;
		} else {
			$this->add_error($i, $raw, $option, "exclude", " is in the forbidden list");
			return false;
		}
	}

	function clear_error() {
		$this->check_error = "";
	}
	function error() {
		return "<div class=errorExplanation id=errorExplanation><h2>Error list</h2><ul>" . $this->check_error . "</ul></div>";
	}
	function add_error($i, $raw, $option, $type, $str) {
		if (!$this->check_error) {
			$this->check_error = "";
		}
		$error_field = $this->get_error_field();

		$errorstr = $GLOBALS["model_check_error_str"];
		if (isset ($errorstr[$type])) {
			$this->check_error = $this->check_error . "<li>" . ($error_field[$i] ? $error_field[$i] : $i) . " " . $errorstr[$type] . "</li>";
		} else {
			$this->check_error = $this->check_error . "<li>" . ($error_field[$i] ? $error_field[$i] : $i) . $str . "</li>";
		}
		if ($option["msg"]) {
			$this->error_field[$i] = ($this->error_field[$i] ? $this->error_field[$i] : "") . $option["msg"] . '. ';
		} else {
			$this->error_field[$i] = ($this->error_field[$i] ? $this->error_field[$i] : "") . $str . '. ';
		}
	}
	function check_length($i, $raw, $option) {
		if ($raw) {
			if ($option["max"] && strlen($raw) > $option["max"]) {
				$this->add_error($i, $raw, $option, "length", " is too long,max is $option[max]");
				return false;
			}
			if ($option["min"] && strlen($raw) < $option["min"]) {
				$this->add_error($i, $raw, $option, "length", " is too short,min is $option[min]");
				return false;
			}
			return true;
		} else {
			return true;
		}
	}

	function model($db, $table_name, $config) {
		$this->db = $db;
		$this->table_name = $table_name;
		$this->config = $config;
	}
	function change_table($table_name) {
		$this->table_name = $table_name;
	}
	function get_table_name() {
		return $this->table_name;
	}
	function create($hash) {
		$keys = array ();
		$values = array ();
		$placehold = array ();

		foreach ($hash as $i => $j) {
			if ($i != "id" && $j) {
				$keys[] = "`$i`";
				$values[] = $j;
				$placehold[] = "?";
			}
		}

		$this->db->update("insert ignore into " . $this->get_table_name() . "(" . join(",", $keys) . ") values(" . join(",", $placehold) . ")", $values);
		return true;
	}

	function save($hash, $f = null) {
		if (!$this->check_record($hash)) {
			return false;
		}
		$detail = $this->detail();
		$has_created = false;
		$has_modified = false;
		$filter_hash = array ();

		foreach ($detail as $i) {
			if ($i["name"] == "created") {
				$has_created = true;
			}
			elseif ($i["name"] == "modified") {
				$has_modified = true;
			}
			elseif ($i["name"] == "ip") {
				$filter_hash["ip"] = $_SERVER[REMOTE_ADDR];
			}
			if ($hash[$i["name"]]) {
				$filter_hash[$i["name"]] = $hash[$i["name"]];
			}
		}

		if ($hash["id"]) {
			if ($has_modified) {
				$filter_hash['modified'] = ima();
			}
			if ($f) {
				return $this->peek_update($filter_hash, $f);
			} else {
				return $this->update($filter_hash);
			}
		} else {
			if ($has_created) {
				$filter_hash['created'] = ima();
			}
			return $this->create($filter_hash);
		}
	}

	function update($hash) {
		$keys = array ();
		$values = array ();
		$placehold = array ();

		foreach ($hash as $i => $j) {
			if ($i == "id") {
				continue;
			}
			$keys[] = " `" . $i . "`=?";
			$values[] = $j;
		}

		$where = " where id = ?";
		$values[] = $hash["id"];

		$this->db->update("update " . $this->get_table_name() . " set " . join(",", $keys) . " " . $where, $values);
		return true;
	}

	function peek_update($hash, $f) {
		if (!$this->check_record($hash)) {
			return false;
		}
		$values = array ();
		$sql = "update " . $this->get_table_name() . "  set ";
		$keys = array ();
		foreach ($hash as $i => $j) {
			if ($i == "id") {
				next;
			}
			$keys[] = " " . $i . "=?";
			$values[] = $j;
		}
		$sql .= join(",", $keys) . " ";

		if (isset ($f["search"]) || isset ($f["like"])) {
			$sql = $sql . " where ";
			if (isset ($f["search"])) {
				foreach ($f["search"] as $i => $j) {
					if (preg_match('/\?/', $i)) {
						$sql = $sql . " $i and ";
						$values[] = $j;
					} else {
						$sql = $sql . " $i=? and ";
						$values[] = $j;
					}
				}
			}

			/*if(isset($f["like"])){
				foreach($f["like"] as $i=>$j){
					$sql=$sql." $i like ? and ";
					$j=str_replace("%","\%",$j);
					$j=str_replace("_","\_",$j);
					$params[]="%$j%";
				}
			}*/
			$sql = $sql . " 1=1 ";
		}

		$this->db->update($sql, $values);
		return true;
	}

	function all($related=false) {
		return $this->peeks(array (),$related);
	}
	function del_by_id($id) {
		return $this->peek_del(array (
			"id" => $id
		));
	}
	function find_by_id($id,$related=false) {
		return $this->peek(array (
			"id" => $id
		),$related);
	}
	function peek($f,$related=false) {
		$all = $this->search(array (
			"search" => $f,
			"limit" => 1,
			'related'=>$related
		));
		if ($all && count($all) >= 1) {
			return $all[0];
		}
		return null;
	}
	function peek_table($table,$f,$related=false) {
		$old_table_name=$this->table_name;
		$this->table_name=$table;
		$all = $this->search(array (
			"search" => $f,
			"limit" => 1,
			'related'=>$related
		));
		$this->table_name=$old_table_name;
		if ($all && count($all) >= 1) {
			return $all[0];
		}
		return null;
	}
	function peek_create($f,$related=false) {
		$record=$this->peek($f,$related);
		if(!$record){
			return $this->save($f);
		}
		return $record;	
	}
	function peeks($f, $order = null, $limit = null,$related=false) {
		$all = $this->search(array (
			"search" => $f,
			"order" => $order,
			"limit" => $limit,
			'related'=>$related
		));
		if ($all && count($all) >= 0) {
			return $all;
		}
		return null;
	}

	function peeks_or($f, $order = null, $limit = null,$related=false) {
		$all = $this->search_or(array (
			"search" => $f,
			"order" => $order,
			"limit" => $limit,
			'related'=>$related
		));
		if ($all && count($all) >= 0) {
			return $all;
		}
		return null;
	}

	function peeks_like($f, $order = null, $limit = null,$related=false) {
		$all = $this->search_advance(array (
			"like" => $f,
			"order" => $order,
			"limit" => $limit,
			'related'=>$related
		));
		if ($all && count($all) >= 0) {
			return $all;
		}
		return null;
	}

	function peeks_page($f, $order = null, $page = 1, $size = 12,$related=false) {
		$page = intval($page);
		$size = intval($size);
		if (!$page) {
			$page = 1;
		}
		$from = ($page -1) * $size;
		$all = $this->search(array (
			"search" => $f,
			"order" => $order,
			"limit" => "$from,$size",
			'related'=>$related
		));
		if ($all && count($all) >= 0) {
			return $all;
		}
		return null;
	}
	function peeks_sql($sql, $params = null) {
		$all = $this->rows($sql, $params);
		if ($all && count($all) >= 0) {
			return $all;
		}
		return null;
	}
	function peek_sql($sql, $params = null) {
		$all = $this->rows($sql, $params);
		if ($all && count($all) >= 0) {
			return $all[0];
		}
		return null;
	}
	function peek_num($f) {
		$all = $this->search(array (
			"select" => "count(*) as records_num_model",
			"search" => $f,
			"limit" => 1
		));
		if ($all && count($all) >= 1) {
			return $all[0]["records_num_model"];
		}
		return null;
	}

	function peek_col($f, $col,$related=false) {
		$all = $this->search(array (
			"select" => "distinct $col",
			"search" => $f,
			'related'=>$related
		));
		if ($all && count($all) >= 1) {
			$cols = array ();
			foreach ($all as $i) {
				$cols[] = $i[$col];
			}
			return $cols;
		}
		return null;
	}

	function peek_del($f) {
		$this->find_del(array (
			"search" => $f
		));
	}
	function execute($sql, $params = null) {
		return $this->db->update($sql, $params);
	}
	function field_names() {
		return $this->db->field_names();
	}
	function table_names() {
		return $this->db->getTables();
	}
	function rows($sql, $params = null) {
		return $this->db->getAll($sql, $params);
	}
	function row($sql, $params = null) {
		return $this->db->getRow($sql, $params);
	}
	function find_del($f) {
		if (!$f) {
			return $this->all();
		}
		$params = array ();

		$sql = "delete from " . $this->get_table_name() . " ";
		if (isset ($f["joins"])) {
			$sql = $sql . $f["joins"] . " ";
		}
		if (isset ($f["search"])) {
			$sql = $sql . " where ";
			if (isset ($f["search"])) {
				foreach ($f["search"] as $i => $j) {
					if (preg_match('/\?/', $i)) {
						$sql = $sql . " $i and ";
						$params[] = $j;
					} else {
						$sql = $sql . " $i=? and ";
						$params[] = $j;
					}
				}
			}

			/*if(isset($f["like"])){
				foreach($f["like"] as $i=>$j){
					$sql=$sql." $i like ? and ";
					$j=str_replace("%","\%",$j);
					$j=str_replace("_","\_",$j);
					$params[]="%$j%";
				}
			}*/
			$sql = $sql . " 1=1 ";
		}
		return $this->execute($sql, $params);
	}
	function find($f) {
		return $this->search($f);
	}
	function search($f) {
		$f["and"] = $f["search"];
		return $this->search_advance($f);
	}
	function search_or($f) {
		$f["or"] = $f["search"];
		return $this->search_advance($f);
	}
	function search_advance($f) {
		if (!$f) {
			return $this->all();
		}

		$inithash = array (
			'Name' => '',
			'Select' => '',
			'Join' => '',
			'Where' => '',
			'InField' => ''
		);

		$params = array ();
		$addtionnal_select = "";
		$addtionnal_join = "";
		$addtionnal_where = "";
		$thistable = $this->get_table_name();
		if ($f['related'] && $hasone = $this->config['hasOne'] { $thistable }) {
			foreach ($hasone as $i) {
				if (!$i['Select']) {
					$i['Select'] = $this->colsNames($i['Name']);
				}
				if (!$i['Join']) {
					$s_thistable = Inflector :: singularize($thistable);
					$s_orhertable = Inflector :: singularize($i['Name']);
					$i['Join'] = "left join $i[Name] on $i[Name].$s_thistable" . "_id = $thistable.id";
				}
				if ($i['Where']) {
					$addtionnal_where .= " $i[Where] and ";
				}
				$addtionnal_select .= ", $i[Select]";
				$addtionnal_join .= " $i[Join] ";
			}
		}
		if ($f['related'] && $hasone = $this->config['belongsTo'] { $thistable }) {
			foreach ($hasone as $i) {
				if (!$i['Select']) {
					$i['Select'] = $this->colsNames($i['Name']);
				}
				if (!$i['Join']) {
					$s_thistable = Inflector :: singularize($thistable);
					$s_orhertable = Inflector :: singularize($i['Name']);
					$i['Join'] = "left join $i[Name] on $thistable.$s_orhertable" . "_id = $i[Name].id";
				}
				if ($i['Where']) {
					$addtionnal_where .= " $i[Where] and ";
				}
				$addtionnal_select .= ", $i[Select]";
				$addtionnal_join .= " $i[Join] ";
			}
		}

		//var_dump($this->config);

		if (isset ($f["select"])) {
			$sql = "select " . $f["select"];
		} else {
			$sql = "select " . $this->get_table_name() . ".* ";
			$sql .= " $addtionnal_select ";
		}
		$sql = $sql . " from " . $this->get_table_name() . " ";
		if (isset ($f["joins"])) {
			$sql = $sql . $f["joins"] . " ";
		}

		$sql = $sql . " $addtionnal_join ";

		if (isset ($f["or"]) || isset ($f["and"]) || isset ($f["like"])) {
			$sql = $sql . " where ";
			if (isset ($f["and"]) && count($f["and"])>0) {
				$sql = $sql . " (";
				foreach ($f["and"] as $i => $j) {
					if (preg_match('/\?/', $i)) {
						$sql = $sql . " " . $thistable . ".$i and ";
						$params[] = $j;
					} else {
						$sql = $sql . " " . $thistable . ".$i=? and ";
						$params[] = $j;
					}
				}
				$sql = $sql . " 1=1 ) and ";
			}

			if (isset ($f["or"]) && count($f["or"])>0) {
				$sql = $sql . " (";
				foreach ($f["or"] as $i => $j) {
					if (preg_match('/\?/', $i)) {
						$sql = $sql . " " . $thistable . ".$i or ";
						$params[] = $j;
					} else {
						$sql = $sql . " " . $thistable . ".$i=? or ";
						$params[] = $j;
					}
				}
				$sql = $sql . " 1=0 ) and ";
			}

			if (isset ($f["like"]) && count($f["like"])>0) {
				$sql = $sql . " (";
				foreach ($f["like"] as $i => $j) {
					if ($j) {
						$sql = $sql . " `$i` like ? or ";
						$j = str_replace("%", "\%", $j);
						$j = str_replace("_", "\_", $j);
						$params[] = "%$j%";
					}
				}
				$sql = $sql . " 1=0 ) and ";
			}
			$sql = $sql . " $addtionnal_where 1=1 ";
		}
		if (isset ($f["group"])) {
			$sql = $sql . " group by " . $f["group"];
		}
		if (isset ($f["order"])) {
			$sql = $sql . " order by " . $f["order"];
		}
		if (isset ($f["limit"])) {
			$sql = $sql . " limit " . $f["limit"];
		}
		$all = $this->db->getAll($sql, $params);

		$idarray = array ();
		foreach ($all as & $i) {
			$idarray[] = $i['id'];
		}
		$strid = join(",", $idarray);
		if ($f['related'] && $strid && strlen($strid) > 0) {
			if ($hasone = $this->config['hasMany'] { $thistable }) {
				foreach ($hasone as $j) {
					$s_thistable = Inflector :: singularize($thistable);
					$s_orhertable = Inflector :: singularize($j['Name']);
					if (!$j['Where']) {
						$j['Where'] = " 1=1 ";
					}
					if (!$j['InField']) {
						$j['InField'] = $s_thistable . "_id";
					}
					if (!$j['Select']) {
						$j['Select'] = "$j[Name].*";
					}
					$middle_id = str_replace(".", '_', "$j[InField]");	
					$hasmany = $this->peeks_sql("select $j[Select],$j[InField] as $middle_id from $j[Name] $j[Join] where $j[Where] and $j[InField] in($strid)");

					foreach ($all as & $i) {
						$manyname='many_' . $j[Name];
						$i[$manyname] = array ();
						foreach ($hasmany as & $k) {
							if ($i['id'] == $k[$middle_id]) {
								$i[$manyname][] = $k;
							}
						}
					}
				}
			}

			if ($hasone = $this->config['hasAndBelongsToMany'] { $thistable }) {
				foreach ($hasone as $j) {					
					$s_thistable = Inflector :: singularize($thistable);
					$s_orhertable = Inflector :: singularize($j[Name]);
					$ra_middletable = array (
						$s_thistable,
						$s_orhertable
					);
					sort($ra_middletable);
					$middletable = join("_", $ra_middletable);
					if (!$j['Where']) {
						$j['Where'] = " 1=1 ";
					}
					if (!$j['InField']) {
						$j['InField'] = "$middletable." . $s_thistable . "_id";
					}
					if (!$j['Join']) {
						$j['Join'] = "join $middletable on $j[Name].id = $middletable.$s_orhertable" . "_id";
					}
					if (!$j['Select']) {
						$j['Select'] = "$j[Name].*";
					}
					$middle_id = str_replace(".", '_', "$j[InField]");					
					$hasmany = $this->peeks_sql("select $j[Select],$j[InField] as $middle_id from $j[Name] $j[Join] where $j[InField] in($strid) and $j[Where]");

					foreach ($all as & $i) {
						$manyname='many_' . $j[Name];
						$i[$manyname] = array ();
						foreach ($hasmany as & $k) {
							if ($i['id'] == $k[$middle_id]) {
								$i[$manyname][] = $k;
							}
						}
					}
				}
			}
		}
		return $all;
	}

}
?>