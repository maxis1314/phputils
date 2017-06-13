{include file="_share/_head_simple.tpl"}
{foreach name=foo from=$data item=item}
<a target=_blank href=/gu/show/{$item.guid}>{$item.guming}</a><br>
JG<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$item.g_price}&cht=lc"><br>
JL<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$item.g_gujiao}&cht=lc"><br>
<hr>
{/foreach}