{include file="_share/_head.tpl"}
{literal}
	<script type="text/javascript">
		$(function(){
			// Accordion
			$("#accordion").accordion({ header: "h3" });
		});
	</script>

{/literal}	
	
<a href="/quick/blog">Change View</a>
<div id="accordion">
	{foreach name=foo from=$blogpage item=custid}
	<div>
		<h3><a href="#">{$custid.title|escape}</a></h3>
		<div>{$custid.content|substr2:0:600|wikinoshow}
		<br>
		<a target=_blank href="/quick/blogshow/{$custid.id|urlencode}">more...</a>
		</div>
	</div>
	{/foreach}
</div>
<br>
{$pagefoot|replace:'<br>':''}


{include file="_share/_foot.tpl"}