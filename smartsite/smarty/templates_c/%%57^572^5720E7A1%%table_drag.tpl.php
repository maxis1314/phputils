<?php /* Smarty version 2.6.18, created on 2009-02-18 19:38:37
         compiled from /home/.escort/likethewind/wx/app/view/_pub/table_drag.tpl */ ?>
<?php echo '

<script type="text/javascript" src="/public/js/jquery.js"></script>
<script type="text/javascript" src="/public/js/jquery.tablednd.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#table-1").tableDnD();
    $("#table-2 tr:even\').addClass(\'alt\')");
    $("#table-2").tableDnD({
	    onDragClass: "myDragClass",
	    onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var debugStr = "Row dropped was "+row.id+". New order: ";
            for (var i=0; i<rows.length; i++) {
                debugStr += rows[i].id+" ";
            }
	        $("#debugArea").html(debugStr);
	       	$("#"+row.id).fadeOut();
	        
	    },
		onDragStart: function(table, row) {
			$("#debugArea").html("Started dragging row "+row.id);
		}
	});
    
});
</script>
<style type="text/css">		
		.alt { background: #eee; }		
</style>
		
		
<div id=debugArea></div>
	
<table id="table-1" cellspacing="0" cellpadding="2">
    <tr id="1"><td>1</td><td>One</td><td>some text</td></tr>
    <tr id="2"><td>2</td><td>Two</td><td>some text</td></tr>
    <tr id="3"><td>3</td><td>Three</td><td>some text</td></tr>
    <tr id="4"><td>4</td><td>Four</td><td>some text</td></tr>
    <tr id="5"><td>5</td><td>Five</td><td>some text</td></tr>
    <tr id="6"><td>6</td><td>Six</td><td>some text</td></tr>
</table>


<table id="table-2" cellspacing="0" cellpadding="2"> 
<tr id="2.1"> 
<td>1</td> 
<td>One</td> 
<td> 
<input type="text" name="one" value="one"/></td> 
</tr> 
<tr id="2.2"> 
<td>2</td> 
<td>Two</td> 
<td> 
<input type="text" name="two" value="two"/></td> 
</tr> 
<tr id="2.3"> 
<td>3</td> 
<td>Three</td> 
<td> 
<input type="text" name="three" value="three"/></td> 
</tr> 
<tr id="2.4"> 
<td>4</td> 
<td>Four</td> 
<td> 
<input type="text" name="four" value="four"/></td> 
</tr> 
<tr id="2.5"> 
<td>5</td> 
<td>Five</td> 
<td> 
<input type="text" name="five" value="five"/></td> 
</tr> 
<tr id="2.6"> 
<td>6</td> 
<td>Six</td> 
<td> 
<input type="text" name="six" value="six"/></td> 
</tr> 
<tr id="2.7"> 
<td>7</td> 
<td>Seven</td> 
<td> 
<input type="text" name="seven" value="7"/></td> 
</tr> 
<tr id="2.8"> 
<td>8</td> 
<td>Eight</td> 
<td> 
<input type="text" name="eight" value="8"/></td> 
</tr> 
<tr id="2.9"> 
<td>9</td> 
<td>Nine</td> 
<td> 
<input type="text" name="nine" value="9"/></td> 
</tr> 
<tr id="2.10"> 
<td>10</td> 
<td>Ten</td> 
<td> 
<input type="text" name="ten" value="10"/></td> 
</tr> 
<tr id="2.11"> 
<td>11</td> 
<td>Eleven</td> 
<td> 
<input type="text" name="eleven" value="11"/></td> 
</tr> 
<tr id="2.12"> 
<td>12</td> 
<td>Twelve</td> 
<td> 
<input type="text" name="twelve" value="12"/></td> 
</tr> 
<tr id="2.13"> 
<td>13</td> 
<td>Thirteen</td> 
<td> 
<input type="text" name="thirteen" value="13"/></td> 
</tr> 
<tr id="2.14"> 
<td>14</td> 
<td>Fourteen</td> 
<td> 
<input type="text" name="fourteen" value="14"/></td> 
</tr> 
</table> 

'; ?>