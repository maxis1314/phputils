<?php

?>
<meta charset="utf-8">
<style>
body{
    font-family:"微软雅黑";    
}
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
}
.occupy{
    background:lightgreen;
}
</style>
<link type="text/css" href="skin/themes/base/ui.all.css" rel="stylesheet" />
<link href="skin/themes/base/lhgcheck.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="srcipt/lhgcheck.js"></script>
<script type="text/javascript" src="skin/jquery-1.3.2.js"></script>
<script type="text/javascript" src="skin/ui/ui.core.js" charset="utf-8"></script>
<script type="text/javascript" src="skin/ui/ui.datepicker_cn.js" charset="utf-8"></script>
<script type="text/javascript">
	$(function() {
		$("#datepicker").datepicker({showOn: 'button', buttonImage: 'skin/themes/base/images/calendar.gif', buttonImageOnly: true});
        $("#datepicker2").datepicker({showOn: 'button', buttonImage: 'skin/themes/base/images/calendar.gif', buttonImageOnly: true});
	
		
	});
</script>
    
<?php

$table_name = "blog";
$config_name = "python";

require "auto_default.php";


