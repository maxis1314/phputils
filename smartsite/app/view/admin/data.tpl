{foreach from=$mysqltables item=item}
<a href=/cms/{$item}>{$item}</a><br>
{/foreach}

<hr>
{foreach from=$filetables item=item}
<a href=/filecms/{$item}>{$item}</a>/JA:<a href=http://localhost:8080/hpx/filedb/index.jsp?t={$item}>{$item}</a>
<br>
{/foreach}

<a href=/wiki/rss>RSS</a>