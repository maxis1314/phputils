{include file="_share/_head.tpl"}

{literal}
<script type="text/javascript" src="/public/js/sorttable.js"></script> 
<script type="text/javascript">
function deleteRow(sRowId,dataid)
{
  jqRow = $("tr#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           $.get('/quick/blogdelete/'+dataid);
           jqRow.remove();
           //window.alert("Record delete");
        });

   }
}

function filtertable(term, _id, cellNr){
	var suche = term.value.toLowerCase();
	var table = document.getElementById(_id);
	var ele;	
	for (var r = 1; r < table.rows.length; r++){
		ele = table.rows[r].cells[cellNr].innerHTML.replace(/&lt;[^&gt;]+&gt;/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
			table.rows[r].style.display = '';
		else table.rows[r].style.display = 'none';
	}
}
</script>
<style type="text/css"> 
th, td {
  padding: 3px !important;
}
 
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style> 

{/literal}


<form>
	Search:<input name="filter" onkeyup="filtertable(this, 'filtertableid', 2)" type="text">&nbsp;&nbsp;&nbsp;<a href="/quick/">Change View</a>
</form>

<table class="sortable" id="filtertableid">
<tr><th>ID</th><th>TITLE</th><th>CONTENT</th>
</tr>
{foreach name=foo from=$blogpage item=custid}
{cycle values="#ffffff, #f0f0f0" assign="tr_color"}
<tr id="row-{$smarty.foreach.foo.iteration}">
<td style="background-color:{$tr_color};">
{$custid.id|escape}</a>
</td>
<td style="background-color:{$tr_color};">
<a  target=_blank href="/quick/blogshow/{$custid.id}/">{$custid.title|escape}</a>
</td>
<td style="background-color:{$tr_color};">
{$custid.content|substr2:0:120|wikinoshow|nl2br}

<br>
<a href="#" onclick='$("p#blogp{$smarty.foreach.foo.iteration}").slideToggle("slow");return false;'>More</a>&nbsp;
<a href='javascript:deleteRow("row-{$smarty.foreach.foo.iteration}","{$custid.id|escape}");'>delete</a>
<p id="blogp{$smarty.foreach.foo.iteration}" style="display:none">
{$custid.content|substr2:120:240|wikinoshow|nl2br}...<br>
<a target=_blank href="/quick/blogshow/{$custid.id}/">Detail</a>
<a href="#" onclick='$("p#blogp{$smarty.foreach.foo.iteration}:visible").slideUp("slow");return false;'>Close</a>
</p>

</td>
</tr>
{/foreach}
</table>

{$pagefoot|replace:'<br>':''}

{include file="_share/_foot.tpl"}
