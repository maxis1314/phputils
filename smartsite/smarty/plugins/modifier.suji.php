<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_suji($string)
{
	$flag="";
	$string=intval($string);
	if($string<0){
		$flag="-";
		$string=-$string;
	}
	$int = intval($string);
	if($int<10000){
		return $flag.$int;
	}
	if($int<100000000){
		return $flag.sprintf('%d,%04d',$int/10000,$int%10000);
	}
	return $flag.sprintf('%d,%04d,%04d',$int/100000000,($int%100000000)/10000,$int%10000);
	
}

?>
