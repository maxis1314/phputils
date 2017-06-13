{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}

{literal}
<script type="text/javascript">
function CheckedAll()
{
	if($("input:checkbox[name='selectids[]']:eq(0)").attr('checked')){
		$("input:checkbox[name='selectids[]']").attr('checked', false);
	}else{
		$("input:checkbox[name='selectids[]']").attr('checked', true);
	}
}
function deleteRow(sRowId,dataid)
{
  jqRow = $("tr#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           $.get('{/literal}{$v.prefix}/{$v.control|escape}{literal}/delete/'+dataid);
           jqRow.remove();
           //window.alert("Record delete");
        });

   }
}


</script>	
{/literal}
<h2>Scaffold　デモ</h2>


<form method=POST action='{$v.prefix}/{$v.control}/search'><input type=text name=key size=30 value="{$post.key|escape}"><input type=submit value="検索"></form>
<form id="myform" method=POST action='{$v.prefix}/{$v.control}/deletemulti'>
<table>
   <tr>
   	  <th></th>
   	   {foreach name=foo from=$table item=col}
   	   {if $col.name!="created" && $col.name!="modified"}
       <th><a href="{$v.prefix}/{$v.control}/?order={$col.name|urlencode}">{$col.name|upper|escape}</a></th>
       {/if}
	   {/foreach}
	   <th>Operate</th>
   </tr>
     {foreach name=foo from=$list item=item}
      <tr id=row-{$smarty.foreach.foo.iteration}>
       {cycle values="#f0f0f0,#ffffff" assign="tr_color"}
       
       <td style="background-color:{$tr_color};">
       <input type=checkbox name="selectids[]" value="{$item.id|escape}">
       </td>
       
       {foreach from=$table item=col}
       {assign var='value' value=`$col.name`}
       {if $value!="created" && $value!="modified"}
       		{if $post.key}
	       		<td style="background-color:{$tr_color};">{$item.$value|substr2:0:6000|escape|nl2br|hilight:$post.key}</td>
	       	{else}
	       		<td style="background-color:{$tr_color};">{$item.$value|substr2:0:54|escape|nl2br}</td>
	       	{/if}
	   {/if}
       {/foreach}
       <td style="background-color:{$tr_color};">
       [<a href="{$v.prefix}/{$v.control}/show/{$item.id}">詳細</a>,<a href="{$v.prefix}/{$v.control}/edit/{$item.id}">編集</a>,
       <a href='javascript:deleteRow("row-{$smarty.foreach.foo.iteration}","{$item.id|escape}");'>削除</a>]
	   </td>
      </tr>
   {/foreach}
   
   </table>
<input type=button onClick='CheckedAll();' value="全部選択"><input type=submit value="選択したものを削除">
</form>
{$foot|replace:'<br>':''}
<br><a href="{$v.prefix}/{$v.control}/add">追加</a>
<br><a href="{$v.prefix}/{$v.control}/Download">ダウンロード　CSV</a>


{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}