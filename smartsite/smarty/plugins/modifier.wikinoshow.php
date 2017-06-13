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
function smarty_modifier_wikinoshow($string)
{


    $string = htmlspecialchars($string, ENT_QUOTES);

    $bbcode_search = array(
    			'/\[s\=(.*?)\](.*?)\[\/s\]/is',
    			'/\[v\=(.*?)\](.*?)\[\/v\]/is',
    			'/\[v\](.*?)\[\/v\]/is',
                '/\[i\](.*?)\[\/i\]/is',
                '/\[u\](.*?)\[\/u\]/is',
                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
                '/\[url\](.*?)\[\/url\]/is',
                '/\[img\](.*?)\[\/img\]/is',
                '/\[c\](.*?)\[\/c\]/is',
                '/\[c\=(.*?)\](.*?)\[\/c\]/is',
                '/\[bg\](.*?)\[\/bg\]/is'
                );
    $bbcode_replace = array(
    			'',
    			'<img src=/public/data/video.jpg>',
    			'<img src=/public/data/video.jpg>',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
                );
    return preg_replace($bbcode_search, $bbcode_replace, $string);
}

/* vim: set expandtab: */

?>
