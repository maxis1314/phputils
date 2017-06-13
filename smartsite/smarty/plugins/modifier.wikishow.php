<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     replace<br>
 * Purpose:  simple search/replace
 * @link http://smarty.php.net/manual/en/language.modifier.replace.php
 *          replace (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_wikishow($string)
{


    $string = htmlspecialchars($string, ENT_QUOTES);

    $bbcode_search = array(
    			'/\[v\=(.*?)\](.*?)\[\/v\]/is',
    			'/\[v\](.*?)\[\/v\]/is',
                '/\[i\](.*?)\[\/i\]/is',
                '/\[u\](.*?)\[\/u\]/is',
                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
                '/\[url\](.*?)\[\/url\]/is',
                '/\[img\](.*?)\[\/img\]/is',
                '/\[c\](.*?)\[\/c\]/is',
                '/\[c\=(.*?)\](.*?)\[\/c\]/is',
                 '/\n( [^\n]+(\n [^\n]+)*)/is'
                );
    $bbcode_replace = array(
    			'<div id="container"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</div><script type="text/javascript" src="/public/data/flv/swfobject.js"></script><script type="text/javascript">	var s1 = new SWFObject("/public/data/flv/player.swf","ply","328","200","9","#FFFFFF");	s1.addParam("allowfullscreen","true");	s1.addParam("allowscriptaccess","always");	s1.addParam("flashvars","file="+encodeURL("$2")+"&image=$1");	s1.write("container");</script>',
    			'<div id="container"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</div><script type="text/javascript" src="/public/data/flv/swfobject.js"></script><script type="text/javascript">	var s1 = new SWFObject("/public/data/flv/player.swf","ply","328","200","9","#FFFFFF");	s1.addParam("allowfullscreen","true");	s1.addParam("allowscriptaccess","always");	s1.addParam("flashvars","file="+encodeURL("$1")+"&image=");	s1.write("container");</script>',
                '<em>$1</em>',
                '<u>$1</u>',
                '<a target=_blank href="/out/rd?url=$1">$2</a>',
                '<a target=_blank href="/out/rd?url=$1">$1</a>',
                '<img width=480 src="$1" />',
                '<b><font color="green">$1</font></b>',
                '<b><font color="$1">$2</font></b>',
                '<div class=wikiblock>$1</div>'
                );
    return preg_replace($bbcode_search, $bbcode_replace, $string);

}

/* vim: set expandtab: */

?>
