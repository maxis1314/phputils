{if $simple}
{include file="_share/_head_simple.tpl"}
{else}
{include file="_share/_head.tpl"}
{/if}


 {foreach from=$resultsave item=item}
 {$item|escape}<br>
 {/foreach}

<form name="form1" id="form1" enctype="multipart/form-data" method="post">
        <input type="file" name="userfile" />
        <input type="submit" name="upload" />
</form>


{$colstr}<br>

<br>
<a href={$v.prefix}/{$v.control}/>List</a>
<br>

{if $simple}
{include file="_share/_foot_simple.tpl"}
{else}
{include file="_share/_foot.tpl"}
{/if}
