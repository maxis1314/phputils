<?php
class pj_controller extends application {

	function filter($method) {

	}

	function task($params) {
		$db = $this->fmodel('pjtask');
		$task = $db->peek(array (
			'id' => $params[0]
		));
		$this->sv('task', $task);
	}

	function member(){
		$db = $this->fmodel('pjtask');
		$member = f('member');
		$this->sv('items',$db->peeks(array('member' => $member)));
	}

	function detail($params) {
		$db = $this->fmodel('pjtask');
		$project = f('project');

		$members = $db->peek_col(array (
			'project' => $project
		), 'member');
		if(f('member')){
			$this->sv('members', array_unique($members));
		}
		
		$this->sv('items',$db->peeks(array('project' => $project)));
		
	}

	function index($params) {
		$this->detail($params);
		$this->sf('pj/detail');
	}

	function gantt($params) {
		$project = f('project');
		$member = f('member');

		// image paths
		$image_left = '/public/image/gantt_img/gantt_left.gif';
		$image_middle = '/public/image/gantt_img/gantt_middle.gif';
		$image_middle_finished = '/public/image/gantt_img/gantt_middle_finished.gif';
		$image_right = '/public/image/gantt_img/gantt_right.gif';

		// left-right-image widths
		$left_right_width = 5;
		$stage_height = 15;
		$left_margin = 50;
		$top_margin = 25;
		$thesizeofblock = 2900;

		$db = $this->fmodel('pjtask');
		$events_array = array_reverse($db->peeks(array (
			'project' => $project,
			'member' => $member
		)));

		$start_days = $db->peek_col(array (
			'project' => $project,
			'member' => $member
		), 'date_start');
		$end_days = $db->peek_col(array (
			'project' => $project,
			'member' => $member
		), 'date_end');
		$members = $db->peek_col(array (
			'project' => $project,
			'member' => $member
		), 'member');

		$all_days = array_merge($start_days, $end_days);
		$pjfromday = min($all_days); //2009/10/1
		$pjtoday = max($all_days); //2009/10/1

		$chart_date_begin = date("U", strtotime($pjfromday));
		$chart_date_end = date("U", strtotime($pjtoday));
		$chart_width_in_days = ($chart_date_end / 86400) - ($chart_date_begin / 86400);

		$chart_width_in_px = ($chart_date_end - $chart_date_begin) / $thesizeofblock;

		$chart_height_in_px = ((count($events_array) + 1) * 16) + 2;

		$bounding_box_height = $chart_height_in_px +40;
		$bounding_box_width = $chart_width_in_px +45;
		$bounding_box_top = $top_margin;
		$bounding_box_left = $left_margin -10;

		$day_width_in_px = $chart_width_in_px / $chart_width_in_days;
		$width_of_day_in_px = 25;

		//echo "chart day width = $chart_width_in_days";
		//echo "chart pixel width = $chart_width_in_px";

		$displaytitle = "";

		if ($project) {
			$displaytitle .= "Project:$project ";
		}
		if ($member) {
			$displaytitle .= "Member:$member";

		}

		$event_display =<<<END

	<div class="event_text" style="display:block; border:solid 1px #999999; position:absolute; height:{$bounding_box_height}px; top:{$bounding_box_top}px; left:{$bounding_box_left}px; width:{$bounding_box_width}px;">{$displaytitle}</div>
END;

		//display the days
		$i = 0;
		$chart_width_in_days = intval($chart_width_in_days);
		while ($i <= $chart_width_in_days) {

			$chart_header_date = date('n/j', $chart_date_begin + ($i * 86400));
			$chart_header_date_ymd = date('y/n/j', $chart_date_begin + ($i * 86400));
			$today_date_ymd = date('y/n/j');
			$weekday = date('w', $chart_date_begin + ($i * 86400));
			if ($weekday == 6) {
				$chart_header_date = "<font color=green>$chart_header_date</font>";
			}
			if ($weekday == 0) {
				$chart_header_date = "<font color=red>$chart_header_date</font>";
			}

			if ($today_date_ymd == $chart_header_date_ymd) {
				//echo $today_date_ymd,$chart_header_date_ymd,'<br>';
				$chart_header_date = "[$chart_header_date]";
			}
			$day_left = $i * $day_width_in_px + $left_margin;
			$day_width = $day_width_in_px -1;

			$header_top = $top_margin +30;

			$event_display .=<<<END
		<div class="event_text" style="display:block; border:solid 1px #CCCCCC; position:absolute; height:{$chart_height_in_px}px; top:{$header_top}px; left:{$day_left}px; width:{$day_width}px;  text-align:center;" title="{$chart_header_date_ymd}">{$chart_header_date}</div>
END;

			$i++;
		} //echo $i,"-",$chart_width_in_days;

		//display project
		$color_array = array (
			'CED0B0',
			'B2D0B0',
			'8589BB',
			'B885BB',
			'BB858D',
			'CED0B0',
			'B2D0B0',
			'8589BB',
			'8589BB'
		);
		$color_length = count($color_array);
		$j = 0;
		foreach ($events_array as $key => $value) {

			$stage_name = $value['stage'];
			$background = $value['color'];
			if (!$background) {
				$color_index = $j % $color_length;
				$background = $color_array[$color_index];
				$j++;
			}
			if ($member) {
				$stage_name = "$stage_name($value[project])";
			}
			if (!$value[percent]) {
				$value[percent] = "0";
			}
			$stage_name = "$stage_name $value[percent]%";

			$top = ($key * ($stage_height +1)) + $top_margin +45;
			$position_left = ((date("U", strtotime($value['date_start'])) - $chart_date_begin) / $thesizeofblock) + $left_margin;
			$position_right = (((date("U", strtotime($value['date_end'])) - $chart_date_begin) + 86400) / $thesizeofblock) + $left_margin;
			$width = $position_right - $position_left;

			$img_left = $position_left;

			$img_middle = $position_left + $left_right_width;
			$image_width_middle = $width - ($left_right_width * 2);
			if ($value['percent']) {
				$img_middle_finished = $img_middle;
				$image_width_middle_finished = $image_width_middle * $value['percent'] / 100;
				$img_middle = $img_middle_finished + $image_width_middle_finished;
				$image_width_middle = $image_width_middle - $image_width_middle_finished;
			} else {
				$img_middle_finished = $img_middle;
				$image_width_middle_finished = 0;
			}

			$img_right = $position_right - $left_right_width;

			$event_display .=<<<CODE
		<div class="event_text" style="display:block; position:absolute; overflow:hidden; top:{$top}px; left:{$position_left}px; width:{$width}px; height:{$stage_height}px; z-index: 101;" >
			&nbsp;&nbsp;<a title="{$value['date_start']}~{$value['date_end']}" href=# onclick="redirect_back('/filecms/pjtask/edit/{$value['id']}')">{$stage_name}</a>
		</div>
		<img style="display:block; position:absolute; height:{$stage_height}px; background: #{$background}; top:{$top}px; left:{$img_left}px; z-index: 100;" src="{$image_left}" />
		<img style="display:block; position:absolute; height:{$stage_height}px; width:{$image_width_middle_finished}px; background: #{$background}; top:{$top}px; left:{$img_middle_finished}px; z-index: 100;" src="{$image_middle_finished}" />
		<img style="display:block; position:absolute; height:{$stage_height}px; width:{$image_width_middle}px; background: #{$background}; top:{$top}px; left:{$img_middle}px; z-index: 100;" src="{$image_middle}" />
		<img style="display:block; position:absolute; height:{$stage_height}px; background: #{$background}; top:{$top}px; left:{$img_right}px; z-index: 100;" src="{$image_right}" />
CODE;

		}

		$this->sv('event_display', $event_display);

	}

	

	function test() {
		echo date('m/j', 1257058800), ":";
		echo date('m/j', 1257145200);
		echo date('Z'),"<br>"; 
		echo date('Y/m/d H:i:s', 1257058800) . ":".date('Y/m/d H:i:s',1257145200)."\n";
		exit;
	}

	/*
	
	//-------------------------------------------------------------------------------------------
		function index2() {
			$chart_date_begin = date("U", strtotime("7/1/2007"));
			$chart_date_end = date("U", strtotime("8/1/2007"));
	
			// image paths
			$image_left = '/public/image/gantt_img/gantt_left.gif';
			$image_middle = '/public/image/gantt_img/gantt_middle.gif';
			$image_right = '/public/image/gantt_img/gantt_right.gif';
	
			// left-right-image widths
			$left_right_width = 5;
			$stage_height = 10;
			$left_margin = 0;
			$top_margin = 0;
	
			$events_array=$this->fmodel('pjtask')->peeks(array('project'=>'test'));
	
	
			$chart_width_in_days = ($chart_date_end / 86400) - ($chart_date_begin / 86400) + 2;
			$chart_width_in_px = ($chart_date_end / 3600) - ($chart_date_begin / 3600);
			$chart_table_width_px = $chart_width_in_px +80;
			$chart_height_in_px = ((count($events_array) + 1) * 16) + 2;
	
			//$day_width_in_px = $chart_width_in_px / $chart_width_in_days;
			$day_width_in_px = 24;
	
			//echo "chart day width = $chart_width_in_days";
			//echo "chart pixel width = $chart_width_in_px";
	
			$header =<<<CODE
	
		<div class="event_text" >
			PHP Gantt Chart
		</div>
			
	
	CODE;
	
			$i = 0;
	
			while ($i <= $chart_width_in_days) {
	
				$chart_header_date = date('n/j', $chart_date_begin + ($i * 86400));
				$day_left = $i * $day_width_in_px + $left_margin;
				$day_width = $day_width_in_px;
	
				$header_display .=<<<CODE
	
			<div class="event_text" style="display:block; float:left; width:{$day_width}px; overflow:hidden; top:0px; left:{$day_left}px;">{$chart_header_date}</div>
	
	CODE;
	
				$i++;
			}
	
			$event_list =<<<CODE
	
		<tr class="event_text" style="background: #CCCCCC;">
			
			<td align="center">
				Stage Name
			</td>
			<td align="center">
				Start Date
			</td>
			<td align="center">
				End Date
			</td>
			<td align="center">
				Color
			</td>
			
		</tr>
	
	CODE;
	
			foreach ($events_array as $key => $value) {
	
				$stage_name = $value['stage'];
				$background = $value['color'];
	
				$top = ($key * ($stage_height +1)) + $top_margin +45;
				$position_left = ((date("U", strtotime($value['date_start'])) - $chart_date_begin) / 3600) + $left_margin;
				$position_right = (((date("U", strtotime($value['date_end'])) - $chart_date_begin) + 86400) / 3600) + $left_margin;
				$width = $position_right - $position_left;
	
				$img_left = $position_left +5;
				$img_middle = $position_left + $left_right_width;
				$image_width_middle = $width - ($left_right_width * 2);
				$img_right = $position_right - $left_right_width;
	
				$event_list .=<<<CODE
			
			<tr class="event_text">
				
				<td>		
					{$stage_name}
				</td>
				<td align="right">
					{$value['date_start']}
				</td>
				<td align="right">
					{$value['date_end']}
				</td>
				<td align="center" style="background: #{$background};">
					{$value['color']}
				</td>
			</tr>
	CODE;
	
				$event_display .=<<<CODE
			
			<tr style="background-image: url('/public/image/gantt_img/column_24.gif');">
				<td>
					<div class="event_text" style="display:block; position:relative; overflow:hidden; top:0px; left:{$position_left}px;" >
						{$stage_name}<br />
						<img style="display:inline; margin-right:-2px; height:{$stage_height}px; width:5px; background: #{$background}; top:0px; left:{$img_left}px; z-index: 100;" src="{$image_left}" />
						<img style="display:inline; margin-left:-2px; height:{$stage_height}px; width:{$image_width_middle}px; background: #{$background};  top:0px; left:{$img_middle}px; z-index: 100;" src="{$image_middle}" />
						<img style="display:inline; margin-left:-5px; height:{$stage_height}px; width:5px; background: #{$background}; top:0px; left:{$img_right}px; z-index: 100;" src="{$image_right}" />
					</div>
				</td>
			</tr>
			
			
	CODE;
	
			}
	
			$this->sv('event_list',$event_list);
			$this->sv('header_display',$header_display);
			$this->sv('event_display',$event_display);
			
			
		}*/
}
?>

