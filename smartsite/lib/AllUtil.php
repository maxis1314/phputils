<?php
class ControlUnit {
	var $type;
	var $data;
	function __construct($type, $data = nil) {
		$this->type = $type;
		$this->data = $data;
	}
}

function code2pic($authstr = "",$width = 60, $height = 25, $space = 10, $size = 5, $line_num = 3, $length = 5) {
	$left = 10; // 字符左间距
	$top = 2; // 上间距
	$move = 4; //上下错位幅度
	// 初始化图片
	$image = imagecreate($width, $height);
	// 设定颜色
	$black = ImageColorAllocate($image, 0, 0, 0);
	$white = ImageColorAllocate($image, 255, 255, 255);
	$gray = ImageColorAllocate($image, 255, 255, 255);
	$silver = ImageColorAllocate($image, 240, 240, 240);
	$msilver = ImageColorAllocate($image, 220, 220, 220);
	$bg_white = ImageColorAllocate($image, 255, 255, 255);
	// 生成背景
	imagefill($image, 0, 0, $bg_white);
	// 画出字符
	for ($i = 0; $i < strlen($authstr); $i++) {
		$y = ($i % 2) * $move + $top;
		imagestring($image, $size, $space * $i + $left, $y, substr($authstr, $i, 1), $black);
	}
	// 画出横向干扰线
	/*if ($i > 0) {
		$line_space = ceil($height / ($line_num +2));
		for ($i = 1; $i <= $line_num; $i++) {
			$y = $line_space * $i;
			imageline($image, 0, $y, $width, $y, $silver);
		}
	}*/
	// 输出图象
	Header("Content-type: image/PNG");
	ImagePNG($image);
	ImageDestroy($image);
}

function set_cookie($name, $value, $limit = 86400) {
	setcookie($name, $value, time() + $limit, "/");
}

function get_cookie($name) {
	if (isset ($_COOKIE[$name])) {
		return $_COOKIE[$name];
	} else {
		return "";
	}
}

function cacheme($key, $value = null) {
	$file = ROOT . 'data/cache/' . urlencode($key);
	if ($value) {
		if ($value != "bh") {
			$handle = fopen($file, 'w');
			fwrite($handle, $value);
			fclose($handle);
		} else {
			unlink($file);
		}
	} else {
		if (file_exists($file)) {
			return join('', file($file));
		} else {
			return null;
		}
	}
}

function getopt_instr($str) {
	preg_match_all('/\-([^ \-]+) +([^ \-]+)/', $str, $matches);
	$all = count($matches[1]);
	$return = array ();
	for ($i = 0; $i < $all; $i++) {
		$optname = $matches[1][$i];
		$optvalue = $matches[2][$i];
		if (!$return[$optname]) {
			$return[$optname] = array ();
		}
		$return[$optname][] = $optvalue;
	}
	return $return;
}

function either($a, $b = "") {
	if ($a) {
		return $a;
	} else {
		return $b;
	}
}

function daxie2xiaoxie($str) {
	$healthy = explode(",", "０,１,２,３,４,５,６,７,８,９");
	$yummy = explode(",", "0,1,2,3,4,5,6,7,8,9");
	return str_replace($healthy, $yummy, $str);
}

function microtime_float() {
	list ($usec, $sec) = explode(" ", microtime());
	return ((float) $usec + (float) $sec);
}

function findexts($filename) {
	$filename = strtolower($filename);
	$exts = split("[/\\.]", $filename);
	$n = count($exts) - 1;
	$exts = $exts[$n];
	return $exts;
}

function trucate($a, $num = 350) {
	return mb_convert_encoding(substr($a, 0, $num), "UTF-8", "UTF-8");
}

function human_check($flag, $csrf, $flag_name = "flag") {
	if (!$flag) {
		$htmlsrc = add_csrf("<h2>Human Check</h2>please input the string in the picture below<br><form action=\"/admin/clogin\" method=\"POST\"><img src=\"/out/get_image?" . time() . "\"><br><input type=text name=\"image\"><input type=submit><input type=hidden name=c value=\"$flag_name\"><input type=hidden name=backurl value=\"" . htmlspecialchars($_SERVER['REQUEST_URI']) . "\"></form>", $csrf);
		echo $htmlsrc;
		exit;
	}
}

function ima() {
	return date("Y-n-j H:i:s", time() + 17 * 3600);
}

function upload_name($a){
	return @$_FILES[$a]["tmp_name"];
}

function f($a) {
	if (@ $_POST[$a]) {
		return @ $_POST[$a];
	} else if(@ $_GET[$a]) {
		return @ $_GET[$a];
	} else {
		return null;
	}
	/*else{
		return upload_name($a);
	}*/
}
function p($a) {
	return @ $_POST[$a];
}
function g($a) {
	return @ $_GET[$a];
}
function e($a) {
	return htmlspecialchars($a, ENT_QUOTES);
}

function limit_length($i, $length = 10000) {
	if (strlen($i) > $length) {
		$i = substr($i, 0, $length);
	}
	return $i;
}
function get_i($a) {
	if (preg_match('/^\d+$/', $a)) {
		return $a;
	} else {
		return 1;
	}
}
function get_w($a) {
	if (preg_match('/^[\w\_\-]+$/', $a)) {
		return $a;
	} else {
		return "";
	}
}

function random_str($length = 7,$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789"){
	srand((double) microtime() * 1000000);
	$i = 0;
	$pass = '';
	$lengthstr = strlen($chars);
	while ($i < $length) {
		$num = rand() % $lengthstr;
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

function is_safe_searh($key) {
	if (strlen($key) < 30 && preg_match('/^[^\;\&\"\'\<\>\.\/\\\?]+$/', $key) && !preg_match('/(rm|ls|ssh)/', $key)) {
		return 1;
	} else {
		return 0;

	}
}

function get_info_cookie() {
	$info = $_COOKIE["info"];
	$a = array ();
	if ($info) {
		$arr = split('\|', $info);
		foreach ($arr as $i) {
			$kv = split('\:', $i);
			if ($kv[0] && $kv[1]) {
				$a[$kv[0]] = $kv[1];
			}
		}
	}
	return $a;
}

function search_dir($dir, $key, $subdir = "") {
	$files = array ();
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file == "." || $file == "..") {
				continue;
			}
			if (is_dir($dir . $file)) {
				if ($subdir) {
					$files = array_merge($files, search_dir($dir . $file, $key, $subdir . "/" . $file . "/"));
				} else {
					$files = array_merge($files, search_dir($dir . $file, $key, $file . "/"));
				}
			}
			elseif (preg_match('/' . $key . '/', $file)) {
				if ($subdir) {
					$files[] = $subdir . $file;
				} else {
					$files[] = $file;
				}
			}
		}
		closedir($dh);
	}

	return $files;
}

function pagerfoot($page, $data, $phpfile, $pagesize = 10, $pagelen = 11, $end = "") {
	if (!$phpfile) {
		$phpfile = $_SERVER['REQUEST_URI'];
	}
	if (!preg_match('/\?/', $phpfile)) {
		$phpfile .= '?';
	}

	$pagecode = '';
	$page = intval($page);

	$total = count($data);

	$total = intval($total);
	if (!$total)
		return array ();
	$pages = ceil($total / $pagesize);

	if ($page < 1)
		$page = 1;
	if ($page > $pages)
		$page = $pages;

	$data = array_slice($data, ($page -1) * $pagesize, $pagesize);

	$offset = $pagesize * ($page -1);

	$init = 1;
	$max = $pages;
	$pagelen = ($pagelen % 2) ? $pagelen : $pagelen +1;
	$pageoffset = ($pagelen -1) / 2;

	$pagecode = '<br><div class="page">';
	#$pagecode.="<span>$page/$pages</span>";

	if ($page != 1) {
		$pagecode .= "<a href='{$phpfile}&page=1'>&lt;&lt;</a>$end";
		$pagecode .= "<a href='{$phpfile}&page=" . ($page -1) . "'>&lt;&nbsp;</a>$end";
	}

	if ($pages > $pagelen) {

		if ($page <= $pageoffset) {
			$init = 1;
			$max = $pagelen;
		} else {

			if ($page + $pageoffset >= $pages +1) {
				$init = $pages - $pagelen +1;
			} else {

				$init = $page - $pageoffset;
				$max = $page + $pageoffset;
			}
		}
	}

	for ($i = $init; $i <= $max; $i++) {
		if ($i == $page) {
			$pagecode .= '<span>' . sprintf("%02d", $i) . '</span>' . $end;
		} else {
			$pagecode .= "<a href='{$phpfile}&page=$i'>" . sprintf("%02d", $i) . "</a>$end";
		}
	}
	if ($page != $pages) {
		$pagecode .= "<a href='{$phpfile}&page=" . ($page +1) . "'>&gt;&nbsp;</a>$end";
		$pagecode .= "<a href='{$phpfile}&page=$pages'>&gt;&gt;</a>$end";
	}
	$pagecode .= '</div>';
	return array (
		'pagenum' => $page,
		'data' => $data,
		'pagecode' => $pagecode,
		'sqllimit' => ' limit ' . $offset . ',' . $pagesize
	);
}

function pagerfoot2($page, $data, $phpfile, $pagesize = 10, $pagelen = 11, $end = "") {
	if (!$phpfile) {
		$phpfile = $_SERVER['REQUEST_URI'];
	}
	if (!preg_match('/\?/', $phpfile)) {
		$phpfile .= '?';
	}
	$pagecode = '';
	$page = intval($page);
	if (is_array($data)) {
		$total = count($data);
	} else {
		$total = intval($data);
	}

	$total = intval($total);
	if (!$total)
		return array ();
	$pages = ceil($total / $pagesize);

	if ($page < 1)
		$page = 1;
	if ($page > $pages)
		$page = $pages;

	if (is_array($data)) {
		$data = array_slice($data, ($page -1) * $pagesize, $pagesize);
	} else {
		$data = null;
	}

	$offset = $pagesize * ($page -1);

	$init = 1;
	$max = $pages;
	$pagelen = ($pagelen % 2) ? $pagelen : $pagelen +1;
	$pageoffset = ($pagelen -1) / 2;

	$pagecode = '<br><div class="page">';
	#$pagecode.="<span>$page/$pages</span>";

	if ($page != 1) {
		$pagecode .= "<a href='{$phpfile}&page=1'>&lt;&lt;</a>$end";
		$pagecode .= "<a href='{$phpfile}&page=" . ($page -1) . "'>&lt;&nbsp;</a>$end";
	}

	if ($pages > $pagelen) {

		if ($page <= $pageoffset) {
			$init = 1;
			$max = $pagelen;
		} else {

			if ($page + $pageoffset >= $pages +1) {
				$init = $pages - $pagelen +1;
			} else {

				$init = $page - $pageoffset;
				$max = $page + $pageoffset;
			}
		}
	}

	for ($i = $init; $i <= $max; $i++) {
		if ($i == $page) {
			$pagecode .= '<span>' . sprintf("%02d", $i) . '</span>' . $end;
		} else {
			$pagecode .= "<a href='{$phpfile}&page=$i'>" . sprintf("%02d", $i) . "</a>$end";
		}
	}
	if ($page != $pages) {
		$pagecode .= "<a href='{$phpfile}&page=" . ($page +1) . "'>&gt;&nbsp;</a>$end";
		$pagecode .= "<a href='{$phpfile}&page=$pages'>&gt;&gt;</a>$end";
	}
	$pagecode .= '</div>';
	return array (
		'pagenum' => $page,
		'data' => $data,
		'pagecode' => $pagecode,
		'sqllimit' => ' limit ' . $offset . ',' . $pagesize
	);
}

function encodeMe($cookie, $kk) {
	$newcookie = array ();
	$cookie = base64_encode($cookie);
	$encodeKey = encodeKey($kk);
	for ($i = 0; $i <= strlen($cookie); $i++) {
		$newcookie[$i] = ord($cookie[$i]) * $encodeKey;
	}
	$newcookie = implode('.', $newcookie);
	return $newcookie;
}
function decodeMe($oldcookie, $kk) {
	$newcookie = array ();
	$cookie = explode('.', $oldcookie);
	$encodeKey = encodeKey($kk);
	for ($i = 0; $i <= strlen($oldcookie); $i++) {
		$newcookie[$i] = chr($cookie[$i] / $encodeKey);
	}
	$newcookie = implode('', $newcookie);
	$newcookie = base64_decode($newcookie);
	return $newcookie;
}
function encodeKey($kk) {
	$newkey = 0;
	if (!$kk) {
		$kk = "Dl9hftRqCAeunluVUnnzRoSAVf19GIDhHMZUvXmEExmNhwWfWbNCcEXVjLK6A.HYFFe7GRLsYtiIVvAMgZdIS0Cir7LGeFdeWJki";
	}
	for ($i = 0; $i <= strlen($kk); $i++) {
		$newkey += ord($kk[$i]);
	}
	return $newkey;
}

function md5_check($str, $md5) {
	return md5("wf435hfgd5hFr4F345" . $str) == $md5;
}
function md5_make($str) {
	return md5("wf435hfgd5hFr4F345" . $str);
}

function obj_call($object, $method, $args = array ()) {
	return call_user_func_array(array (
		& $object,
		$method
	), $args);
}

function rteSafe($strText) {

	$tmpString = $strText;

	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	$tmpString = str_replace("'", "&#39;", $tmpString);

	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);

	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);

	return $tmpString;
}

function getIP() {
	unset ($onlineip);
	if ($_SERVER['HTTP_CLIENT_IP']) {
		$onlineip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
		$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	return $onlineip;
}
?>
