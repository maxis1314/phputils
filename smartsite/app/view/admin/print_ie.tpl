<form method=POST>

Url<input type=text name=url>Scroll
<input type=text name=scroll><br>
Url2<input type=text name=url2>Scroll
<input type=text name=scroll2><br>
Url3<input type=text name=url3>Scroll
<input type=text name=scroll3><br>

<input type=submit>

</form>

{if $picurl}
<img src="{$picurl}">
{/if}
{if $picurl2}
<img src="{$picurl2}">
{/if}
{if $picurl3}
<img src="{$picurl3}">
{/if}

<a href=/self/admin/print_screen>Print Screen</a>