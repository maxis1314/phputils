{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

<h2><a href={$v.prefix}/{$v.control}/show/{$before}>&lt;&lt;</a>{$table_name|escape} Show<a href={$v.prefix}/{$v.control}/show/{$after}>&gt;&gt;</a></h2>

<table> 
{foreach name=foo from=$table item=col}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
{if $col.name!="id"}
<tr><td style="background-color:{$tr_color};">{$col.name|escape}</td>
<td style="background-color:{$tr_color};">
{assign var='value' value=`$col.name`}
{$data.$value|escape|replace:' ':'&nbsp;'|nl2br}
{if $value=="url"}
	&nbsp;<a target=_blank href="/self/error/rd?url={$data.$value|urlencode}">-&gt;</a>
{/if}
</p></td>
</tr>
{/if}
{/foreach}

</table>

<br>
<a href={$v.prefix}/{$v.control}/edit/{$data.id}/>Edit</a><br>
<a href={$v.prefix}/{$v.control}/edit/{$data.id}/?bigtextarea=1>Edit in Big textarea</a><br>
<a href={$v.prefix}/{$v.control}/add/>Add</a><br>
<a href={$v.prefix}/{$v.control}/add/{$data.id}/>Copy Add</a><br>
<a href={$v.prefix}/{$v.control}/>List</a>

{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}
