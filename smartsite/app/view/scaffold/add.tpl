{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

<h2>{$table_name|escape} Add</h2>

<form method=POST>
<table>
{foreach name=foo from=$table item=col}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
{if $col.name=="ip" || $col.name=="id" || $col.name=="created" || $col.name=="modified"}
{else}
	<tr><td style="background-color:{$tr_color};">{$col.name|escape}</td><td style="background-color:{$tr_color};">
	{assign var='value' value=`$col.name`}
	{assign var='postdata' value=`$post.data`}
	{if $col.type=="text" || $col.type=="blob" || $col.type=="longtext" }
		<textarea name="data[{$value}]" cols="30" rows="3" >{$data.$value|escape}</textarea>		
	{else}		
		<input type=text name="data[{$value}]" value="{$data.$value|escape}">				
	{/if}
	<font color=red>{$error_field.$value|escape}</font>
	</td></tr>
{/if}
{/foreach}
</table>
<br>
<input type="submit" value="Save" />
</form>

<br>
<a href={$v.prefix}/{$v.control}/>List</a>

{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}
