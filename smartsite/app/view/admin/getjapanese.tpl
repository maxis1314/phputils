<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>fanyi</title>
</head>


{$faying}
<br>
{$setumeyi}

{foreach name=foo from=$other item=item}
<a href="http://rd.yahoo.co.jp/dic/redirect_from_spell_check/?http://dic.yahoo.co.jp/dsearch?enc=UTF-8&stype=1&dtype=0&p={$item|urlencode}">{$item|escape}</a>
{/foreach}