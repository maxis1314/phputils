<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
<script src="{$v.prefix}/public/js/jquery.cookie.js" type="text/javascript"></script>
<h2>Member {$get.member|escape}</h2>
<iframe width=1000 height=300 src=/pj/gantt?member={$get.member|escape}></iframe><br>


<table border=1>
{foreach from=$items item=item}
<tr>
<td><a href=# onclick="redirect_back('/filecms/pjtask/edit/{$item.id}')"/>{$item.stage|escape}</a></td>
<td>{$item.date_start|escape}~{$item.date_end|escape}({$item.percent|escape}%)</td>
<td><a href=/pj/detail?project={$item.project|escape}>{$item.project|escape}</td>
</tr>
{/foreach}
</table>