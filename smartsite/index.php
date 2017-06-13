<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
date_default_timezone_set('Asia/Tokyo');

/*
if(preg_match('/gzip/',$_SERVER['HTTP_ACCEPT_ENCODING'])){
	ob_start("ob_gzhandler");
}
*/

global $globalstr;
$globalstr = 0;

function denyaccess() {
	if (!$_SERVER[HTTP_USER_AGENT] || preg_match('/bot/i', $_SERVER[HTTP_USER_AGENT]) || preg_match('/spider/i', $_SERVER[HTTP_USER_AGENT]) || preg_match('/http/i', $_SERVER[HTTP_USER_AGENT])) {
		header('Location: /public/404.html');
		exit;
	}
}

denyaccess();

define("ROOT", dirname(__FILE__) . "/");
if (@ $_GET["d"] == 1) {
	define("DEBUG", true);
} else {
	define("DEBUG", false);
}

//load
require ("config/config.php");
require ("app/main/controller.php");
require ("app/main/application.php");

require ("lib/AllUtil.php");

require ("lib/View.php");

//require ("lib/Inflector.php");

/*
$dir = dir(ROOT . "lib/");
while (($file = $dir->read()) !== false) {
	if (!preg_match("/^\./", $file) && preg_match("/\.php$/", $file)) {
		require_once (ROOT . "lib/" . $file);
	}
}
$dir->close();
*/

//get path
$path = $url = $_SERVER['REQUEST_URI'];

//clear
$path = preg_replace("/\?.*$/", '', $path);
$path = preg_replace("/^\/+/", '', $path);
//$path = preg_replace("/\/+$/", '', $path);

if (preg_match('/\.(\w+)$/', $path, $matches)) {
	$format = $matches[1];
	$path = preg_replace('/\.\w+$/', '', $path);
} else {
	$format = "";
}

//parse path
if ($path != "") {
	$pieces = explode("/", $path);
	$pieces = array_slice($pieces, PREFIXNUM);
} else {
	$pieces = array ();
}
if (count($pieces) === 0) {
	$className = $init_values['default_controller'];
	$methodName = $init_values['default_action'];
	$pieces = array ();
} else {
	foreach ($pieces as & $j) {
		$j = urldecode($j);
	}
	$oclass = $className = strtolower(array_shift($pieces));
	if (isset ($short_action[$className])) {
		$methodName = $short_action[$className][1];
		$className = $short_action[$className][0];
	} else {
		$methodName = strtolower(array_shift($pieces));
	}
	if (!$methodName) {
		$methodName = "index";
	}
}

//check 
if (!preg_match('/^[A-Za-z0-9_]+$/', $className) || !preg_match('/^[A-Za-z0-9_]+$/', $methodName)) {
	$pieces = array (
		"controller[$className] or action name[$methodName] is wrong, a-zA-Z0-9_ allowed only."
	);
	$className = "error";
	$methodName = "do404";
}

//check file exist
if (!file_exists("app/controller/" . $className . "_controller.php")) {
	$pieces = array (
		"file app/controller/" . $className . "_controller.php does not exist!"
	);
	include_once ("app/controller/error_controller.php");
	$className = "error";
	$methodName = "do404";
} else {
	include_once ("app/controller/" . $className . "_controller.php");
}

//load helper
if (file_exists("app/helper/" . $className . "_helper.php")) {
	include_once ("app/helper/" . $className . "_helper.php");
}

if (class_exists($className . '_controller') && $className != "controller" && $className != "application") {
	$classobjname = $className . '_controller';
	try {
		$classInstance = new $classobjname ($pieces);
		
		if (!method_exists($classInstance, $methodName)) {
			array_unshift($pieces, $methodName);
			$methodName = 'default_func';
		}
		$classInstance->format = $format;
		$classInstance->ctl = $className;
		$classInstance->action = $methodName;
		$classInstance->set_config($configini);
		$classInstance->filter($methodName);
	} catch (Exception $e) {
		do404($e->getMessage(), $configini);
		exit;
	}
	docontrolandmethod($classInstance, $methodName, $pieces);
} else {
	do404("can not find class {$className}_controller!", $configini);
}

/*
if(preg_match('/gzip/',$_SERVER['HTTP_ACCEPT_ENCODING'])){
	ob_end_flush();
}
*/




function docontrolandmethod(& $classInstance, $methodName, $pieces) {
	try {
		$re = $classInstance-> $methodName ($pieces);
		//log something if necessary
		if(!preg_match('/cms/',$_SERVER['REQUEST_URI']) && !preg_match('/admin/',$_SERVER['REQUEST_URI'])){
			//$classInstance->logme(getIP().':'.$_SERVER['REQUEST_URI'].':'.$_SERVER[HTTP_USER_AGENT]);
		}
		if (gettype($re) == "object") {
			if ($re->type == "redirect_action") {
				include_once (ROOT . 'app/controller/' . $re->data[0] . '_controller.php');
				$classobjname = $re->data[0] . '_controller';
				$classInstance2 = new $classobjname ($re->data[2]);
				$classInstance2->format = $classInstance->format;
				$classInstance2->ctl = $re->data[0];
				$classInstance2->action = $re->data[1];
				$classInstance2->set_config($classInstance->config);
				$classInstance2->filter($re->data[1]);

				$action = $re->data[1];
				$classInstance2->filter($action);
				$classInstance2-> $action ($re->data[2]);
				$classInstance = $classInstance2;
			}
			if ($re->type == "redirect_url") {
				echo "<iframe frameborder='no' width='100%' height='100%' scrolling='no' src='" . $re->data[0] . "'></iframe>";
				exit;
			}
		}

	} catch (Exception $e) {
		$classInstance->sv("error", $e->getMessage());
		$classInstance->do404();
	}
	$html = $classInstance->fetch_html($pieces);
	if (DEBUG) {
		$handle = fopen(ROOT . "data/temp/last.html", "w");
		fwrite($handle, $html);
		fclose($handle);
	}
	echo $html;
}

function do404($str, $configini) {
	$pieces = array (
		$str
	);
	$classInstance = new application();
	$classInstance->set_config($configini);
	docontrolandmethod($classInstance, 'do404', $pieces);
}
?>

