<form method=POST>

Url<input type=text name=url value="{$post.url|escape}" size=60>
<input type=submit>
<hr>
<input type=checkbox name=downloadjpg value="1">DW<br>
{foreach name=foo from=$jpg item=item}
wget {$item|escape}<br>
{/foreach}
<hr>
<input type=checkbox name=downloadpng value="1">DW<br>
{foreach name=foo from=$png item=item}
{$item|escape}<br>
{/foreach}
<hr>
<input type=checkbox name=downloadgif value="1">DW<br>
{foreach name=foo from=$gif item=item}
{$item|escape}<br>
{/foreach}
<hr>
<input type=checkbox name=downloadbmp value="1">DW<br>
{foreach name=foo from=$bmp item=item}
{$item|escape}<br>
{/foreach}
<hr>
<input type=checkbox name=downloadother value="1">DW<br>
{foreach name=foo from=$other item=item}
{$item|escape}<br>
{/foreach}


</form>