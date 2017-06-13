{literal}

<script type="text/javascript" src="/public/js/jquery.js"></script>
<script type="text/javascript">
function deleteRow(iId, sRowId)
{
  jqRow = $("tr#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           jqRow.remove();
           window.alert("Record delete");
        });

   }
}


</script>
<style type="text/css">		
		.alt { background: #eee; }		
</style>
		
		
<div id=debugArea></div>
	
<table id="explorer">
   <tr id="row-1">
      <td>News title</td>
      <td><a href='javascript:deleteRow(1, "row-1");'>Delete</a></td>
   </tr>

   <tr id="row-10">
      <td>News title</td>
      <td><a href='javascript:deleteRow(10, "row-10");'>Delete</a></td>
   </tr>
</table>

{/literal}