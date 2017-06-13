<?php /* Smarty version 2.6.18, created on 2009-02-18 19:46:31
         compiled from /home/.escort/likethewind/wx/app/view/_pub/table_delete.tpl */ ?>
<?php echo '

<script type="text/javascript" src="/public/js/jquery.js"></script>
<script type="text/javascript">
function deleteRow(iId, sRowId)
{
   jqRow = $("tr#" + sRowId);
  /* Change de color of row */
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
      <td><a href=\'javascript:deleteRow(1, "row-1");\'>Delete</a></td>
   </tr>

   <tr id="row-10">
      <td>News title</td>
      <td><a href=\'javascript:deleteRow(10, "row-10");\'>Delete</a></td>
   </tr>
</table>

'; ?>