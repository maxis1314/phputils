{literal}<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>jQuery UI Example Page</title>
		<link type="text/css" href="/public/css/ui.all.css" rel="Stylesheet" />	
		<script type="text/javascript" src="/public/js/jquery.js"></script>
		<script type="text/javascript" src="/public/js/jquery-ui-personalized.js"></script>
		<script type="text/javascript">
			$(function(){
				// Tabs
				$('#tabs').tabs();
			});
		</script>
{/literal}
	</head>
	<body>
	
		<!-- Tabs -->
		<h2 class="demoHeaders">Tabs</h2>
		<div id="tabs">
			<ul>
				{foreach name=foo from=$blog item=custid}
				<li><a href="#tabs-{$smarty.foreach.foo.iteration}">{$custid.title|substr2:0:12|escape}</a></li>			
				{/foreach}
			</ul>
			{foreach name=foo from=$blog item=custid}
			<div id="tabs-{$smarty.foreach.foo.iteration}">{$custid.content|escape|nl2br}</div>
			{/foreach}
		</div>
	
	

	</body>
</html>


