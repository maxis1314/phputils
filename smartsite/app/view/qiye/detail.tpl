{include file="_share/_head_simple.tpl"}




{if !empty($list)}
	<table border=1>
	{foreach name=foo from=$list item=item}
	  <tr>
	  <td>{$item.id}</td>
	  <td>{$item.type}</td>
	  <td>{$item.title}</td>
	  
	  <td>{$item.ct}</td>
	  <td><a target=_blank href=/qiyedb/qiye/edit/{$item.id}>编辑</td>
	  </tr>
	{/foreach}
	</table>
{/if}
<br>
<a target=_blank href=/qiyedb/qiyesingle/search?key={$item.name}>企业信息</a>     

<br>
<a target=_blank href=/qiyedb/qiye/add/?name={$item.name}&type=news>添加新闻</a>     
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=public">添加公告 </a>
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=picad">添加图片广告 </a> 
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=pic">添加图片 </a> 
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=link">添加链接 </a> 
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=product">添加最新产品 </a> 
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=suggest">添加推荐产品 </a> 
<a target=_blank href="/qiyedb/qiye/add/?name={$item.name}&type=article">添加文章 </a> 
<hr>

<br>
<br>
{foreach name=foo from=$list item=item}
{if $item.type eq "jianjie"}
{assign var="jianjie" value=$item} 
{/if}


{if $item.type eq "liuyan"}
{assign var="liuyan" value=$item} 
{/if}

{if $item.type eq "zhaopin"}
{assign var="zhaopin" value=$item} 
{/if}

{if $item.type eq "chanping"}
{assign var="chanping" value=$item} 
{/if}

{if $item.type eq "dongtai"}
{assign var="dongtai" value=$item} 
{/if}

{if $item.type eq "tupian"}
{assign var="tupian" value=$item} 
{/if}
{/foreach}

简介 jianjie
<form name=1 method=Post>
<input type=text name=title value="{$jianjie.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$jianjie.content|escape}</textarea><br>
<input type=hidden name=what value=jianjie>
<input type=submit>
</form><br>
留言 liuyan
<form name=1 method=Post>
<input type=text name=title value="{$liuyan.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$liuyan.content|escape}</textarea><br>
<input type=hidden name=what value=liuyan>
<input type=submit>
</form><br>
招聘 zhaopin
<form  name=2 method=Post>
<input type=text name=title value="{$zhaopin.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$zhaopin.content|escape}</textarea><br>
<input type=hidden name=what value=zhaopin>
<input type=submit>
</form><br>
产品 chanping
<form  name=3 method=Post>
<input type=text name=title value="{$chanping.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$chanping.content|escape}</textarea><br>
<input type=hidden name=what value=chanping>
<input type=submit>
</form><br>
动态 dongtai
<form  name=4 method=Post>
<input type=text name=title value="{$dongtai.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$dongtai.content|escape}</textarea><br>
<input type=hidden name=what value=dongtai>
<input type=submit>
</form><br>
图片 tupian
<form  name=5 method=Post>
<input type=text name=title value="{$tupian.title|escape}"><br>
<textarea name=content rows=5 cols=60>{$tupian.content|escape}</textarea><br>
<input type=hidden name=what value=tupian>
<input type=submit>
</form><br>

{include file="_share/_foot_simple.tpl"}