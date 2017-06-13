{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}





{if !empty($list)}
	<table border=1>
	{foreach name=foo from=$list item=custid}
	  <tr>
	  {foreach key=key item=item from=$custid}
	  	{if $custid.id}
	    	<td><a href=/admin/table/{$url[0]|urlencode}/edit/{$key|urlencode}/{$custid.id|escape}>{$item|escape}</a>	    	
	    	</td>
	    {else}
	    	<td>{$item|escape}</td>
	    {/if}
	  {/foreach}
	  </tr>
	{/foreach}
	</table>
{/if}

<form method=POST action="/{$cmspath}/{$url[0]|escape}/sql">
<textarea name=execsql2 cols=120 rows=4>{$post.execsql2|escape}</textarea><br>
<input type=text name=param value="{$post.param|escape}"><br>
<input type=hidden name="do" value="simple">
<input type=submit>
</form>


{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}

