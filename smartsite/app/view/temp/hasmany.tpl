{$user.name}<br>
{$user.password}<br>
{$user.email}<br>
Post Title<br>
{$user.title}<br>
Post Body<br>
{$user.body}<br>

Comments
<table border=1>
{foreach from=$user.manycomments item=item}
<tr><td>{$item.id}</td><td>{$item.content}</td><td>{$item.user_id}</td></tr>
{/foreach}
</table>

Tools
<table border=1>
{foreach from=$user.manytools item=item}
<tr><td>{$item.id}</td><td>{$item.name}</td></tr>
{/foreach}
</table>