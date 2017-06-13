<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
   {literal}
    <head>
		<title>Calendar</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<style>
			.event_text
					{
					font-family:arial;
					font-size:8pt;
					font-weight:bold;
					}
			a:link { text-decoration: none}
			a:visited { text-decoration: none}
			a:hover { text-decoration: none}
			body div#toolTip { position:absolute;z-index:1000;width:220px;background:#000;border:2px double #fff;text-align:left;padding:5px;min-height:1em;-moz-border-radius:5px; }
			body div#toolTip p { margin:0;padding:0;color:#fff;font:11px/12px verdana,arial,sans-serif; }
			body div#toolTip p em { display:block;margin-top:3px;color:#f60;font-style:normal;font-weight:bold; }
			body div#toolTip p em span { font-weight:bold;color:#fff; }
		</style>
	<script type="text/javascript" src="/public/js/sweettitles/addEvent.js"></script>
	<script type="text/javascript" src="/public/js/sweettitles/sweetTitles.js"></script>
	</head>
	{/literal}
	<body>
		<h3>{$task.stage} {$task.date_start}~{$task.date_end} <a href=/filecms/pjtask/edit/{$task.id}>Edit</a><br></h3>
		<iframe width=1000 src=/pj/gantt?project={$task.project} title="project {$task.project}'s info">Gantt Chat of Project {$task.project}</iframe><br>
		<iframe width=1000 src=/pj/gantt?member={$task.member} title="{$task.member}'s info">Gantt Chat of Member {$task.member}</iframe><br>
		
	</body>
	
</html>
