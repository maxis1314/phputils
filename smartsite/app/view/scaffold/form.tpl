{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

<h2>{$table_name|escape} Search</h2>

<form method=POST action='/{$v.control}/search'><input type=text name=key size=30 value="{$post.key|escape}"><input type=submit value="検索"></form>
<hr>
<h2>{$table_name|escape} Search Advance</h2>
<form method=POST action='/{$v.control}/search_adv'>
<table>
{foreach name=foo from=$table item=col}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
{if $col.name=="ip" || $col.name=="id" || $col.name=="created" || $col.name=="modified"}
{else}
	<tr><td style="background-color:{$tr_color};">{$col.name|escape}</td><td style="background-color:{$tr_color};">
	<select name=op_{$col.name|escape}>
	<option value=1 selected>=</option>
	<option value=2>&gt;</option>
	<option value=3>&lt;</option>
	<option value=4>&gt;=</option>
	<option value=5>&lt;=</option>
	<option value=6>like</option>
	</select>
	{assign var='value' value=`$col.name`}
	{assign var='postdata' value=`$post.data`}
	{if $col.type=="text" || $col.type=="blob" || $col.type=="longtext" }
		<textarea name="data[{$value}]" cols="30" rows="3" >{$post.$value|escape}</textarea>		
	{else}		
		<input type=text name="data[{$value}]" value="{$post.$value|escape}">				
	{/if}	
	</td></tr>
{/if}
{/foreach}
</table>
<br>
<input type="submit" value="Search" />
</form>



<br>
<a href={$v.prefix}/{$v.control}/>List</a>
<a href={$v.prefix}/{$v.control}/add>Add</a>



{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}
