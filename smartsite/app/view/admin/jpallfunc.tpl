<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>fanyi</title>
</head>


 <title>JPALL</title>
{literal}
<script src="/public/js/jquery.js" type="text/javascript"></script>
<script src="/image/windows_files/interface.js" type="text/javascript"></script>

<script language="javascript">
function setrefresh2(text){
	if(!text){
		text=$("#newwordxiaodi").val();
	}
	if($('#window').css('display') == 'none') {					
		  $('#window').show("fast");													
	}
	var y=document.body.scrollTop;
	$('#window').css({ top: y, right: "0px" });				
	//$("#window").css('top') = document.body.scrollTop;  
	
	var url="/admin/getjapanese234/"+text+"/jp";
	$("#windowContent").html("Load.."+text);	
	$.get(url, function(data){
		for(i=0;i<120;i++){
			data=data.replace('<font color=red><b>|</b></font>','<br>');
		}
		  $("#windowContent").html("<input size=40 type=text id=newwordxiaodi value='"+text+"' onkeydown='if(event.keyCode==13){setrefresh2();return false;}'><br><font size=3>"+data.replace(' ','')+"</font>");
		  $("#newwordxiaodi").focus();
	});	
	
	
}

$(document).ready(
	function()
	{
		$('.rubylink').bind(
			'click',
			function() {
				//alert(this.title);
				if($('#window').css('display') == 'none') {					
					  $('#window').show("fast");													
				}
				var y=document.body.scrollTop;
				$('#window').css({ top: y, right: "0px" });				
				//$("#window").css('top') = document.body.scrollTop;				
				var text=this.title;
				var url="/admin/getjapanese234/"+text+"/jp";
				$("#windowContent").html("Load.."+text);
				
				$.get(url, function(data){
					for(i=0;i<20;i++){
						data=data.replace('<font color=red><b>|</b></font>','<br>');
					}
					$("#windowContent").html("<input  size=40 type=text id=newwordxiaodi value='"+text+"' onkeydown='if(event.keyCode==13){setrefresh2();return false;}'><br><font size=3>"+data.replace(' ','')+"</font>");
					$("#newwordxiaodi").focus();
				});	
				
				this.blur();
				return false;
			}
		);
		
		$('#windowClose').bind(
			'click',
			function()
			{
				$('#window').TransferTo(
					{
						to:'windowOpen',
						className:'transferer2', 
						duration: 400
					}
				).hide();
			}
		);
		$('#windowMin').bind(
			'click',
			function()
			{
				$('#windowContent').SlideToggleUp(300);
				$('#windowBottom, #windowBottomContent').animate({height: 10}, 300);
				$('#window').animate({height:40},300).get(0).isMinimized = true;
				$(this).hide();
				$('#windowResize').hide();
				$('#windowMax').show();
			}
		);
		$('#windowMax').bind(
			'click',
			function()
			{
				var windowSize = $.iUtil.getSize(document.getElementById('windowContent'));
				$('#windowContent').SlideToggleUp(300);
				$('#windowBottom, #windowBottomContent').animate({height: windowSize.hb + 13}, 300);
				$('#window').animate({height:windowSize.hb+43}, 300).get(0).isMinimized = false;
				$(this).hide();
				$('#windowMin, #windowResize').show();
			}
		);
		$('#window').Resizable(
			{
				minWidth: 200,
				minHeight: 60,
				maxWidth: 700,
				maxHeight: 400,
				dragHandle: '#windowTop',
				handlers: {
					se: '#windowResize'
				},
				onResize : function(size, position) {
					$('#windowBottom, #windowBottomContent').css('height', size.height-33 + 'px');
					var windowContentEl = $('#windowContent').css('width', size.width - 25 + 'px');
					if (!document.getElementById('window').isMinimized) {
						windowContentEl.css('height', size.height - 48 + 'px');
					}
				}
			}
		);
		setrefresh2("{/literal}{$url[0]}{literal}");
	}
);


function save(a,b){
	if(!a || !b){
		return;
	}
   var param={		
		kannji: a,
		yomi: $("#yomi2").val(),
		lang: "jp"
    };

	$.post("/admin/rubyjp/",param,
	  function(data){
	    
	});
}




</script>

<style type="text/css" media="all">
body
{
	background: #fff;
	height: 100%;
}
#window
{
	position: absolute;
	right: 0px;
	top: 100px;
	width: 400px;
	height: 300px;
	overflow: hidden;
	display: none;
}
#windowTop
{
	height: 30px;
	overflow: 30px;
	background-image: url(/image/windows_files/window_top_end.png);
	background-position: right top;
	background-repeat: no-repeat;
	position: relative;
	overflow: hidden;
	cursor: move;
}
#windowTopContent
{
	margin-right: 13px;
	background-image:url(/image/windows_files/window_top_start.png);
	background-position:left top;
	background-repeat: no-repeat;
	overflow: hidden;
	height: 30px;
	line-height: 30px;
	text-indent: 10px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	color: #6caf00;
}
#windowMin
{
	position: absolute;
	right: 25px;
	top: 10px;
	cursor: pointer;
}
#windowMax
{
	position: absolute;
	right: 25px;
	top: 10px;
	cursor: pointer;
	display: none;
}
#windowClose
{
	position: absolute;
	right: 10px;
	top: 10px;
	cursor: pointer;
}
#windowBottom
{
	position: relative;
	height: 270px;
	background-image: url(/image/windows_files/window_bottom_end.png);
	background-position: right bottom;
	background-repeat: no-repeat;
}
#windowBottomContent
{
	position: relative;
	height: 270px;
	background-image: url(/image/windows_files/window_bottom_start.png);
	background-position: left bottom;
	background-repeat: no-repeat;
	margin-right: 13px;
}
#windowResize
{
	position: absolute;
	right: 3px;
	bottom: 5px;
	cursor: se-resize;
}
#windowContent
{
	position:absolute;
	top: 30px;
	left: 10px;
	width: auto;
	height: auto;
	overflow: auto;
	margin-right: 10px;
	border: 1px solid #6caf00;
	height: 255px;
	width: 375px;
	font-family:Arial, Helvetica, sans-serif;
	font-size: 11px;
	background-color: #fff;
}
#windowContent *
{
	margin: 10px;
}
.transferer2
{
	border: 1px solid #6BAF04;
	background-color: #B4F155;
	filter:alpha(opacity=30); 
	-moz-opacity: 0.3; 
	opacity: 0.3;
}
</style>
{/literal}

{include file="admin/hatuonn.tpl"}




<div  id="window">
	<div id="windowTop">
		<div id="windowTopContent">translate</div>
		<img src="/image/windows_files/window_min.jpg" id="windowMin">
		<img src="/image/windows_files/window_max.jpg" id="windowMax">
		<img src="/image/windows_files/window_close.jpg" id="windowClose">
	</div>
	<div id="windowBottom"><div id="windowBottomContent">&nbsp;</div></div>
	<div id="windowContent">888888888888888
	</div>
	<img src="/image/windows_files/window_resize.gif" id="windowResize">
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>
