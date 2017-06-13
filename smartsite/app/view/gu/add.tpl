{include file="_share/_head_simple.tpl"}

<h3>Add</h3>


<form method=POST action="{$v.prefix}/gu/add/">
<table>

<tr>
<td>
guid
</td><td>
<textarea name="data[guid]" cols="30" rows="3" >{$post.data.guid|escape}</textarea>
<font color=red>{$error_field.guid|escape}</font>
</td>
</tr>

<tr>
<td>
gushu
</td><td>
<textarea name="data[gushu]" cols="30" rows="3" >{$post.data.gushu|escape}</textarea>
<font color=red>{$error_field.gushu|escape}</font>
</td>
</tr>

<tr>
<td>
guin
</td><td>
<textarea name="data[guin]" cols="30" rows="3" >{$post.data.guin|escape}</textarea>
<font color=red>{$error_field.guin|escape}</font>
</td>
</tr>

<tr>
<td>
gunow
</td><td>
<textarea name="data[gunow]" cols="30" rows="3" >{$post.data.gunow|escape}</textarea>
<font color=red>{$error_field.gunow|escape}</font>
</td>
</tr>

<tr>
<td>
comment
</td><td>
<textarea name="data[comment]" cols="30" rows="3" >{$post.data.comment|escape}</textarea>
<font color=red>{$error_field.comment|escape}</font>
</td>
</tr>

</table>
<input type="submit" value="Save">
</form>


<br>

<a href={$v.prefix}/gu/>List</a>

{literal}

<script language="javascript">
function simulateKeyPress(character) {
  jQuery.event.trigger({ type : 'keydown', which : character });
}
$(document).ready(	
	function()
	{


	}
);
</script>


{/literal}

{include file="_share/_foot_simple.tpl"}