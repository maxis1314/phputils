<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {math} function plugin
 *
 * Type:     function<br>
 * Name:     math<br>
 * Purpose:  handle math computations in template<br>
 * @link http://smarty.php.net/manual/en/language.function.math.php {math}
 *          (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_easy($params, &$smarty)
{
 	if($params["type"] == "history_back"){
 		return "<input type=button onclick=\"history.back()\" value='Back'>";
 	}
 	if($params["type"] == "random"){
 		srand((double)microtime()*1000000);
 		return rand();
 	}
 	return ""; 
}

/* vim: set expandtab: */

?>
