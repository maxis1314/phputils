{include file="_share/_head.tpl"}

<h2>Search Engine</h2>
<form method=GET>
<input type=text name=key id=key value="{$keyw|escape}" title="输入关键字进行检索"><input type=submit value="検索">
<br>

{if isset($result)}
{if count($result)>0}
<table> 
<tr> 
  <td nowrap>&nbsp;<span id=sd>&nbsp;<b>Mim134.com</b>&nbsp;</span></td> 
  <td align=right nowrap><font size=-1><b>{$keyw|escape}</b> 的检索结果 <b>{$page*10}</b> - <b>{$page*10+10}</b> 件  (<b>{$consumeTime}</b> 秒)&nbsp;</font></td> 
</tr> 
</table> 
    	{foreach name=foo from=$result item=custid}

	       
			
		<h3><a href="/out/rd?url={$custid.link|urlencode}" target=_blank>
{$custid.title}</a></h3>

<table border=0 cellpadding=0 cellspacing=0 width=550>
<tr>
<td class=j>
{$custid.description|nl2br}
<font size=-1>&nbsp;
<a href="{$custid.link|escape}" target=_blank>{$custid.link|escape}</a>
<br>
<span class=a>

<a href="http://{$custid.host|escape}"  target=_blank>{$custid.host|escape}</a></span> &nbsp;-&nbsp;<nobr>人気:<span class=rank>{$custid.num}</span></td>
</tr></table>
<br><br>
        {/foreach}

{if $page>0}<a href="?key={$keyw|urlencode}&page={$page-1}">←</a>&nbsp;{/if}{$page+1}{if $has_next}&nbsp;<a href="?key={$keyw|urlencode}&page={$page+1}">→</a>{/if}
{else}
找不到与 <b>{$keyw|escape}</b> 相关的网页
{/if}
{/if}

{include file="_share/_foot.tpl"}
