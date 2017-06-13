<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>JPTest</title>
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
</head>
<body>
<div id=result>result</div>
<hr>
{foreach name=foo from=$list item=item}

{$item[1]|escape}:<input id="input{$smarty.foreach.foo.iteration}" type=text {literal}onkeydown="if(event.keyCode==13){checkresult(this,{/literal}'{$item[0]|escape}'{literal},{/literal}{$smarty.foreach.foo.iteration},'{$item[1]|escape}'{literal});return false;}">{/literal}<div id="show{$smarty.foreach.foo.iteration}" style="display:none">{$item[0]|escape}/{$item[2]}<input id=report{$smarty.foreach.foo.iteration} type=button value="Report Error" onclick="reporterror('{$item[1]}',{$smarty.foreach.foo.iteration});this.disabled=true;"></div><br>

{/foreach}


{literal}
<script language="javascript">
$(document).ready(
	function()
	{
		$("#input1").focus();
	}
);
var right=0;
var wrong=0;
var errorstr="";
function checkresult(obj,b,c,d){
	if(obj.disabled){
		return;
	}
	
	//alert(obj.value+":"+b);
	obj.disabled=true;
	
	if(obj.value==b){
		right++;
	}else{
		wrong++;
		errorstr=d+" "+errorstr;
		$("#show"+c).show("fast");
		$.post("/self/admin/jptest",{type:"error",word:b+","+d},
		  function(data){		  	  	
		});	
	}
	
	$("#result").html("正确"+right+"错误"+wrong);
	
	if(right+wrong == 10){
		if(right==10){
			alert("超级无敌牛人!!!");
		}
		if(right==9 || right==8){
			alert("很好很强大!!");
		}
		if(right==7 || right==6){
			alert("同志还需努力!");
		}
		if(right<=5 && right>=3){
			alert("不要灰心嘛");
		}
		$("#savebtn").focus();
	}else{
		$("#input"+(c+1)).focus();
	}
	return false;
}


function savejieguo(){	
	var param={		
		page: 'JPTEST',
		ajaxwiki: 1,
		encode_hint: 'ぷ',
		msg: '&now; '+errorstr,
		cmd: 'edit',
		write: "ページの更新"
   	};	
	$.post("/index.php",param,
	  function(data){
	  	$("#savebtn").hidden("fast");	  		
	});
	$("#restartbtn").focus();
}

function reporterror(test,a){	
	var param={		
		page: 'JPTESTERROR',
		ajaxwiki: 1,
		encode_hint: 'ぷ',
		msg: test,
		cmd: 'edit',
		write: "ページの更新"
   	};	
	$.post("/index.php",param,
	  function(data){
	  	$("#report"+a).hidden("fast");	  	
	});	
}

</script>
{/literal}


<input id="savebtn" type=button value="保存错误结果" onclick="savejieguo();this.disabled=true;">



<a target=_blank href="http://localhost:5558/index.php?JPTEST">历史结果</a>
<br><br>

<input id="restartbtn" type=button value="重新来过!" onclick="location.reload();">


<a target=_blank href="/self/admin/jptest?type=2th">以前错的</a>
{include file="admin/hatuonn.tpl"}

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>


</html>