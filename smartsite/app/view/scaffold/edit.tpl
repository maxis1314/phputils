{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

<h2>{$table_name|escape} Edit</h2>

<form method=POST>
<table>
{foreach name=foo from=$table item=col}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
{if $col.name=="id"}
<input type=hidden name="data[id]" value="{$data.id}">
{elseif $col.name=="ip" || $col.name=="created" || $col.name=="modified"}
{else}
	<tr><td style="background-color:{$tr_color};">{$col.name|escape}</td><td style="background-color:{$tr_color};">
	{assign var='value' value=`$col.name`}
	{if $col.type=="text" || $col.type=="blob" || $col.type=="longtext" }
		<textarea name="data[{$value}]" cols="{if $get.bigtextarea}100{else}50{/if}" rows="{if $get.bigtextarea}30{else}4{/if}" >{$data.$value|escape}</textarea><a href={$v.prefix}/{$v.control}/edit/{$data.id}/?bigtextarea=1>Big</a>		
	{else}
		<input type=text name="data[{$value}]" value="{$data.$value|escape}" size=50>		
	{/if}
	<font color=red>{$error_field.$value|escape}</font>
	</td></tr>
{/if}
{/foreach}
</table>
<br>
<input type="submit" value="Save" />
</form>

</div>
<br>
<a href={$v.prefix}/{$v.control}/show/{$data.id}/>Show</a><br>
<a href={$v.prefix}/{$v.control}/add/>Add</a><br>
<a href={$v.prefix}/{$v.control}/add/{$data.id}/>Copy Add</a><br>
<a href={$v.prefix}/{$v.control}/>List</a>

{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}
