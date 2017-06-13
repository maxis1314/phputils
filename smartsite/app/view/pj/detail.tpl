<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
<script src="{$v.prefix}/public/js/jquery.cookie.js" type="text/javascript"></script>
<h2>Project {$get.project|escape}</h2>
<iframe width=1000 height=300 src=/pj/gantt?project={$get.project|escape}></iframe><br>

{if $get.member}
<a href=/pj/detail?project={$get.project|escape}>Hide Members' Gantt</a><br>
{else}
<a href=/pj/detail?project={$get.project|escape}&member=1>Show Members' Gantt</a><br>
{/if}
{foreach from=$members item=item}
<iframe width=1000 height=250 SCROLLING=yes src=/pj/gantt?member={$item} title="{$item|escape}'s info"></iframe><br>
{/foreach}


<table border=1>
{foreach from=$items item=item}
<tr>
<td><a href=# onclick="redirect_back('/filecms/pjtask/edit/{$item.id|escape}/')">{$item.stage|escape}</a></td>
<td>{$item.date_start|escape}~{$item.date_end|escape}({$item.percent|escape}%)</td>
<td><a href=/pj/member?member={$item.member|escape}>{$item.member|escape}</a></td>
</tr>
{/foreach}
</table>