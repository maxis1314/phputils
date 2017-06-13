{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

<h2><a href={$v.prefix}/{$v.control}/show/{$before}>&lt;&lt;</a>{$table_name|bigcase|escape} Show<a href={$v.prefix}/{$v.control}/show/{$after}>&gt;&gt;</a></h2>

<table> 
{foreach from=$data key=key item=value}
{if is_scalar($value)}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
<tr><td style="background-color:{$tr_color};">{$key|escape}</td>
<td style="background-color:{$tr_color};">{$value|escape}
{if $key=="url"}
	&nbsp;<a target=_blank href="/self/error/rd?url={$v|urlencode}">-&gt;</a>
{/if}
</td>
{/if}
{/foreach}
</table>
<br>

{foreach from=$manyothers item=tablename}
<br><br>
<h2>{$tablename|replace:"many_":""|bigcase}</h2><hr>
    <table border=1>
    {if count($data.$tablename)>0}
    	<tr>
    	{foreach from=$data.$tablename[0] key=key item=value}
	 	  <th>{$key|bigcase|escape}</th>
		{/foreach}
		</tr>
		{foreach from=$data.$tablename item=item}
		{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
		<tr>{foreach from=$item key=key2 item=value2}		  
	 	  <td  style="background-color:{$tr_color};">{$value2|escape}{if $key2=="id"} <a href="{$v.prefix}/{$cmspath}/{$tablename|replace:"many_":""}/showdetail/{$value2|escape}">[Detail]<a href="{$v.prefix}/{$cmspath}/{$tablename|replace:"many_":""}/add/">[Add]</a>{/if}</td>
		{/foreach}</tr>
	{/foreach}
	{/if}	
	<table>
{/foreach}

<br>
<a href={$v.prefix}/{$v.control}/edit/{$data.id}>Edit</a><br>
<a href={$v.prefix}/{$v.control}/>List</a>

{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}


