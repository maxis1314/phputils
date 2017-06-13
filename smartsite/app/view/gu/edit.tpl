{include file="_share/_head_simple.tpl"}
<h3>Edit</h3>


<form method=POST action="{$v.prefix}/gu/edit/">
<table>
<input type=hidden name="data[id]" value="{$data.id}">

<tr>
<td>
guid
</td><td>	
<textarea name="data[guid]" cols="30" rows="3" >{$data.guid|escape}</textarea>
<font color=red>{$error_field.guid|escape}</font>
</td>
</tr>

<tr>
<td>
gushu
</td><td>	
<textarea name="data[gushu]" cols="30" rows="3" >{$data.gushu|escape}</textarea>
<font color=red>{$error_field.gushu|escape}</font>
</td>
</tr>

<tr>
<td>
guin
</td><td>	
<textarea name="data[guin]" cols="30" rows="3" >{$data.guin|escape}</textarea>
<font color=red>{$error_field.guin|escape}</font>
</td>
</tr>

<tr>
<td>
gunow
</td><td>	
<textarea name="data[gunow]" cols="30" rows="3" >{$data.gunow|escape}</textarea>
<font color=red>{$error_field.gunow|escape}</font>
</td>
</tr>

<tr>
<td>
fenxi
</td><td>	
<textarea name="data[fenxi]" cols="30" rows="3" >{$data.fenxi|escape}</textarea>
<font color=red>{$error_field.fenxi|escape}</font>
</td>
</tr>

<tr>
<td>
danwei
</td><td>	
<textarea name="data[danwei]" cols="30" rows="3" >{$data.danwei|escape}</textarea>
<font color=red>{$error_field.danwei|escape}</font>
</td>
</tr>
<tr>

<td>
comment
</td><td>	
<textarea name="data[comment]" cols="30" rows="3" >{$data.comment|escape}</textarea>
<font color=red>{$error_field.comment|escape}</font>
</td>
</tr>

<td>
Add gu
</td><td>	
NUM<input type=text name="ingunum">
PRI<input type=text name="inguprice">
</td>
</tr>


</table>
<input type="submit" value="Save">
</form>


<a href={$v.prefix}/gu/show/{$data.guid}>Show</a><br>
<a href={$v.prefix}/gu/>List</a>



{include file="_share/_foot_simple.tpl"}