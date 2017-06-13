{include file="_share/_head.tpl"}
{literal}
<script type="text/javascript" src="/public/data/lightbox/prototype.js"></script>
<script type="text/javascript" src="/public/data/lightbox/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="/public/data/lightbox/lightbox.js"></script>
<link rel="stylesheet" href="/public/data/lightbox/lightbox.css" type="text/css" media="screen" />
{/literal}
<h2>Albums</h2>

{foreach name=foo from=$piclist item=custid}
<a href="{$custid|escape}" rel="lightbox[plants]"><img src="{$custid|escape}" alt="Plants: {$smarty.foreach.foo.iteration}/{$smarty.foreach.foo.total} thumb" width="240" height="150"></a>
{/foreach}<br>
{$foot|replace:'<br>':''}
<br>


{include file="_share/_foot.tpl"}