<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
		<title>PHP Gantt Chart</title>
		{literal}
		<style>
			.event_text
					{
						font-family:arial;
						font-size:9px;
						font-weight:bold;
					
					}
			.scrolling_div
					{
						border : solid 1px #000000;
						padding : 0px;
						width : 500px;
						height : auto;
						overflow : auto;

					}
		</style>
	{/literal}	
	</head>
	<body>
	
		<h1>PHP Gantt Chart</h1>
		
		<p>This is a Gantt chart generated using a combination of html/php/css and several images. It has been tested in IE, Firefox and Safari.</p>
		
		<table border="1" width="502" cellspacing="0" cellpadding"0" >
			{$event_list}
		</table>
		
		<br />
		
		<div class="scrolling_div" >
			<table border="1"  >
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding"0" width="{$chart_table_width_px}">
		
							<tr style="background-image: url('/public/image/gantt_img/column_24_reverse.gif');">
								<td style="border-bottom: solid 1px #999999;" nowrap>
									{$header_display}
								</td>
							</tr>
							{$event_display}
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="event_text">
			Author: Graham Sprague, <a href="http://www.grahamsprague.com" >http://www.grahamsprague.com</a>
		</div>
	</body>
	
</html>
