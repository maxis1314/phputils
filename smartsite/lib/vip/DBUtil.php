<?php


define("DB_FETCH_ROW", MYSQL_NUM);
define("DB_FETCH_ASSOC", MYSQL_ASSOC);
define("DB_FETCH_ARRAY", MYSQL_BOTH);

class DB
{
	var $dbHost = null;
	var $dbName = null;
	var $dbUser = null;
	var $dbPswd = null;
	var $conn   = null;
	var $query  = null;
	var $result = null;
	var $errStr = null;
	var $quick  = false;        
	var $sqlStr = array();
	var $sQueries = 0;
	var $uQueries = 0;
	var $charset = null;
	var $logs=array();

	function DB($dsn, $fetchMode = DB_FETCH_ASSOC, $pConn = false)
	{
		$this->dbHost = $dsn["dbHost"];
		$this->dbName = $dsn["dbName"];
		$this->dbUser = $dsn["dbUser"];
		$this->dbPswd = $dsn["dbPswd"];
		$this->charset = $dsn["charset"];
		$this->connect($pConn);
		$this->selectDB();
		$this->setFetchMode($fetchMode);		
	}

	function connect($pConn = false)
	{
		$pConn ? $connFunc = "mysql_pconnect" : $connFunc = "mysql_connect";
		$this->conn = @ $connFunc($this->dbHost, $this->dbUser, $this->dbPswd);
		if($this->charset){//utf8
			mysql_set_charset($this->charset,$this->conn);
		} 
		if (!$this->conn)
		{
			$this->errStr = "DataBase Connect False : ($this->dbHost, $this->dbUser, ******) !";
			$this->dbError();
		}
	}

	function selectDB()
	{
		if ($this->dbName != null)
		{
			if(! @ mysql_select_db($this->dbName, $this->conn))
			{
				$this->errStr = "DataBase -[$this->dbName]- does not exist !";
				$this->dbError();
			}
		}
		return false;
	}

	function setFetchMode($fetchMode)
	{
		if(!defined("DB_FETCH_MODE"))
		{
			define("DB_FETCH_MODE", $fetchMode);
		}
	}

	function query($query, $quick = false)
	{
		$t = microtime_float();		

		$this->quick = $quick;
		$this->query = $query;
		$this->sqlStr[] = $this->query;
		$this->quick ? $queryFunc = "mysql_unbuffered_query" : $queryFunc = "mysql_query";
		$this->result = @ $queryFunc($this->query, $this->conn);
		$this->sQueries++;		
		
		$took = microtime_float() - $t;
		$this->logs[]=array(
			$query,$took
		);		
		
		if (!$this->result)
		{
			$this->dbError();
		}
		return $this->result;
	}

	function escape_array(&$a){
		foreach($a as &$i){
			$i = mysql_real_escape_string($i);
		}
		return $a;
	}

	function bind_query($str,$param_array,$quick){
		if($param_array && count($param_array)>0){
			$this->escape_array($param_array);
			$str=preg_replace('/\?/',"'%s'",$str);			
			$this->query=vsprintf($str,$param_array);
			//echo $this->query;
			return $this->query($this->query,$quick);
		}else{
			return $this->query($str,$quick);
		}
	}
	
	function getOne($query,$a=NULL)
	{
		#$this->query($query, true);
		if($a){
			$this->bind_query($query,$a,true);
		}else{
			$this->query($query, true);
		}
		$row = $this->fetchRow(DB_FETCH_ROW);
		$this->free();
		return $row[0];
	}

	function getRow($query, $a=NULL,$fetchMode = DB_FETCH_MODE)
	{
		if($a){
			$this->bind_query($query,$a,true);
		}else{
			$this->query($query, true);
		}
		$row = $this->fetchRow($fetchMode);
		$this->free();
		return $row;
	}

	function getAll($query, $a=NULL,$fetchMode = DB_FETCH_MODE)
	{
		if($a){
			$this->bind_query($query,$a,true);
		}else{
			$this->query($query, true);
		}

		$allRows=array();
		while($rows = @ $this->fetchRow($fetchMode))
		{
			$allRows[] = $rows;
		}
		$this->free();
		return $allRows;
	}

	function getCol($query, $field,$fetchMode = DB_FETCH_MODE)
	{
		$this->query($query, true);
		$allRows=array();
		while($rows = @ $this->fetchRow($fetchMode))
		{
			$allRows[] = $rows[$field];
		}
		$this->free();
		return $allRows;
	}

	function update($query, $a=NULL)
	{
		if($a){
			$this->bind_query($query,$a,true);
		}else{
			$this->query($query, true);
		}
		$this->uQueries++;
		$this->free();
		return true;
	}

	function getTables()
	{
		$this->result = @ mysql_list_tables($this->dbName);
		if (!$this->result)
		{
			$this->errStr = "List database's tables Error !";
			$this->dbError();
		}
		$tablesNum = @ mysql_num_rows($this->result);
		for ($i = 0; $i < $tablesNum; $i++)
		{
			$tables[] = mysql_tablename($this->result, $i);
		}
		return $tables;
	}

	function fetchRow($fetchMode = DB_FETCH_MODE)
	{
		$rows = @ mysql_fetch_array($this->result, $fetchMode);
		return $rows;
	}

	function rows()
	{
		return @ mysql_num_rows($this->result);
	}

	function fields()
	{
		return @ mysql_num_fields($this->result);
	}

	function field_names()
	{
		$fields=array();
		$nb = @ mysql_num_fields($this->result);
		for($i=0;$i<$nb;$i++){
			$fields[]=mysql_field_name($this->result,$i);
		}
		return array($nb,$fields);		
	}

	function lastID()
	{
		return @ mysql_insert_id($this->conn);
	}

	function free()
	{
		@ mysql_free_result($this->result);
		$this->result = null;
	}

	function close()
	{
		@ mysql_close($this->conn);
	}

	function dbError()
	{
		$errStr = "Error No : " . mysql_errno() . "\n";
		$errStr .= "Time : " . date("Y-m-d H:i:s") . "\n";
		if (isset($this->errStr))
		{
			$errStr .= $this->errStr . "\n";
		}
		if(isset($this->query))
		{
			$errStr .= "Query : " . $this->query . "\n";
		}
		$errStr .= "Error MSG : " . mysql_error();
		
		$tracelogs =debug_backtrace();
    	$errStr.="<br><table><tr><th>File</th><th>Function</th></tr>";
    	foreach($tracelogs as $i){
    		$errStr.="<tr><td>".substr($i[file],29)."($i[line])</td><td>$i[function] ()</td></tr>";
    	}   
    	$errStr.="</table>"; 	
	    	
		throw new Exception($errStr);
	}
}

?>
