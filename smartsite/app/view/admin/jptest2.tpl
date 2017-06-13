<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>JPTest</title>
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
<script src="/image/windows_files/jquery.contextmenu.r2.js" type="text/javascript"></script>
</head>
<body>


{literal}
<script language="javascript">
$(document).ready(
	function()
	{
		$("#input1").focus();
		
		$('#gotoSelfDic').bind(
			'click',
			function() {				
				window.open('http://localhost:5558/self/admin/jpallfunc/'+getselect()+'/jp','mywindow','width=450,height=450');
			}
		);
		$('#gotoYahoo').bind(
			'click',
			function() {				
				window.open('http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p='+getselect()+'&stype=1&dtype=0','mywindow','width=450,height=200');
			}
		);
		$('#gotoGoogle').bind(
			'click',
			function() {				
				window.open('http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|'+getselect()+'','mywindow','width=450,height=200');
			}
		);
		$('#gotoXiaodi').bind(
			'click',
			function() {				
				window.open('http://dict.hjenglish.com/jp/w/'+getselect()+'&type=jc','mywindow','width=420,height=250');
			}
		);
		$('#demo').contextMenu('myMenu2', {          
	      menuStyle: {	
	        border: '2px solid #000'	
	      },

	      itemStyle: {	
	        fontFamily : 'verdana',	
	        backgroundColor : '#fff',	
	        color: 'white',	
	        border: 'none',	
	        padding: '1px'	
	      },

	      itemHoverStyle: {	
	        color: '#fff',	
	        backgroundColor: '#0f0',	
	        border: 'none'	
	      }	
	    });

	}
);

function getselect(){
    var a = "";//.toUpperCase();
    try {
        var selecter = window.getSelection();
        return selecter;
    }catch (err) {
        var selecter = document.selection.createRange();
        return selecter.text;
    }
    /*a = a.toString().replace(/ /g, "");
    if (a.length > 20) {
        a = "";
    /}*/
    return a;
}
	
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
		$("#show"+c).val(b);		
	}
	
	$("#showerror").html($("#explain"+c).html());
	if(right+wrong == 10){
		if(right==10){
			alert("超级无敌牛人!!!(10)");
		}
		if(right==9 || right==8){
			alert("很好很强大!!(8-9)");
		}
		if(right==7 || right==6){
			alert("同志还需努力!(6-7)");
		}
		if(right<=5 && right>=3){
			alert("不要灰心嘛(3-5)");
		}
		if(right<=2){
			alert("运气不佳?(~2)");
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



</script>
{/literal}
<div id=demo>
<table><tr><td width=500 valign=top>
{foreach name=foo from=$list item=item}
{$item[1]|escape}:<input id="input{$smarty.foreach.foo.iteration}" type=text {literal}onkeydown="if(event.keyCode==13){checkresult(this,{/literal}'{$item[0]|escape}'{literal},{/literal}{$smarty.foreach.foo.iteration},'{$item[1]|escape}'{literal});return false;}">{/literal}:<input type=text id="show{$smarty.foreach.foo.iteration}" style="display:true"><br>
<div id="explain{$smarty.foreach.foo.iteration}" style="display:none">{$item[0]|escape}/{$item[2]}<input id=report{$smarty.foreach.foo.iteration} type=button value="Report Error" onclick="reporterror('{$item[1]}',{$smarty.foreach.foo.iteration});this.disabled=true;"></div>
{/foreach}



<input id="savebtn" type=button value="保存错误结果" onclick="savejieguo();this.disabled=true;">

<a target=_blank href="http://localhost:5558/index.php?JPTEST">HI</a>
<br><br>
<input id="restartbtn" type=button value="Again!" onclick="location.reload();">
<div id=showerror><div>
</td><td valign=top>
{include file="admin/hatuonn.tpl"}
</td></tr>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
 <div class="contextMenu" id="myMenu2">

    <ul>

      <li id="item_1"><a id=gotoYahoo href=#>Yahoo</a></li>

      <li id="item_2"><a id=gotoGoogle href=#>Google</a></li>

      <li id="item_3"><a id=gotoXiaodi href=#>Xiaodi</a></li>

      <li id="item_4"><a id=gotoSelfDic href=#>SelfDic</a></li>

      <!-- etc... -->

    </ul>

  </div>
    
</body>

</html>