{include file="_share/_head.tpl"}
{literal}
<style type="text/css">
		#bounce { padding: 0.4em; }
		#bounce h3 { margin: 0; padding: 0.4em; text-align: center; }
	</style>
	<script type="text/javascript">
	var rand={/literal}{$rand}{literal};
	$(function() {
		$("#bounce").click(function() {
			if(rand%8==0){
				$("> :eq(0)", this).effect("bounce", {height:5});
			}
			if(rand%8==1){
				//$("> :eq(0)", this).toggle("puff");
				//$("> :eq(0)", this).toggle("fold");
				$("> :eq(0)", this).toggle("pulsate");			
			}
			if(rand%8==2){
				//$(this).effect("highlight");
				$("> :eq(0)", this).toggle("scale");				
			}
			if(rand%8==3){
				$("> :eq(0)", this).toggle("blind");
			}			
			if(rand%8==4){
				$("> :eq(0)", this).toggle("clip");
			}
			if(rand%8==5){
				$("> :eq(0)", this).toggle("drop");
			}
			if(rand%8==6){
				$("> :eq(0)", this).toggle("explode");
			}
			if(rand%8==7){
				$("> :eq(0)", this).toggle("slide");
			}
			rand++;			
		});
	});
	</script>

{/literal}
<div class="drag" title="{$detail.id|escape}">
<h2>
<a href="#" onclick='$("#blogdiv").slideToggle("slow");return false;'>
{$detail.title|escape}
</a>
(Drop to Black Hole to delete)</h2>
</div>

<br>
<div id="blogdiv">


	<div id="bounce" class="ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all">{$detail.title|escape}(Click Me!!)</h3>
	<p>
	
	{$detail.content|wikishow|nl2br}<br>---<br>by {$detail.nick|escape}<br>				
	<br><br><br>
	{foreach from=$commentblog item=custid}
	{$custid.comment|escape|nl2br}<br>-------------------<br>
	{/foreach}
	

	</p>
	</div>

</div>
	<iframe width=550 height=500 
scrolling="no" border="0" frameborder="0"
src="/in/x2f/newreply/?father={$detail.id|escape}"></iframe>

<br>
<a href="/quick/">more ..</a>
<br><br><br>

{include file="_share/_foot.tpl"}
    