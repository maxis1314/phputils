<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title></title>
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
</head>
<body>


<select id="rss" onchange="giveme()">
{foreach name=foo from=$rssfeed item=item}
<option value='{$item.url}' {if $item.url==$get.url}selected{/if}>{$item.who} - {$item.url}</option>
{/foreach}        
</select><a target=_blank href='/self/filecms/rss'>Manage</a>

{literal}
<script language="javascript">
function giveme(){	
	window.location.href="/self/wiki/rss/?url="+$('#rss').val();
}
function giveme2(){	
	window.location.href="/self/wiki/rss/?url="+$('#rss2').val();
}
</script>
{/literal}


{foreach name=foo from=$rssresult.items item=custid}        
	        <table id="mytable" border=1 width=100%>
			
			
	
			<tr><td width=5% class="alt" valign=top>
			{$smarty.foreach.foo.iteration}
			</td>
			<td>
			<div class=dashbox"><p>
			<a class=linkstyle href="/self/out/rd?id={$custid.id}&url={$custid.link|urlencode}" target=_blank>{$custid.title|escape}</a><br>({$custid.pubDate|escape})<br>
			{$custid.description|nl2br}
			<br>
			&lt;<a target=_blank href="/self/error/rd?url={$custid.link|escape}">{$custid.rssname|escape} - {$custid.numrank|escape}</a>&gt;
			
			<input id="tit{$smarty.foreach.foo.iteration}" type=hidden value="{$custid.title|escape}">
			<input id="con{$smarty.foreach.foo.iteration}" type=hidden value="{$custid.description|escape}">
			<input id="url{$smarty.foreach.foo.iteration}" type=hidden value="{$custid.link|escape}">
			<br>
			
			</p></div></td>
			</tr>
	
			</table>
        </div>
{/foreach}

<select id="rss2" onchange="giveme2()">
{foreach name=foo from=$rssfeed item=item}
<option value='{$item.url}' {if $item.url==$get.url}selected{/if}>{$item.who} - {$item.url}</option>
{/foreach}        
</select><a target=_blank href='/self/filecms/rss'>Manage</a>
<br><br><br><br><br><br>