<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>fanyi</title>
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>

</head>
<body>
<div onmouseup="checksave(event)" oncontextmenu="return false;">
<form method=POST action="/self/admin/rubyjp/">				
{literal}
<input type=text id="loading" value="ok" disabled size=3>:
<input id="kannji2" type=text name=kannji size=5 value="{/literal}{$url[0]|escape}{literal}"  onkeydown="if(event.keyCode==13){setrefresh();return false;}">:
<input id="yomi2" type=text name=yomi size=5 onkeydown="if(event.keyCode==13){save();return false;}">
{/literal}		
<input type=button onclick="save();" value="save"><a target=_blank href="http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p={$url[0]|urlencode}&stype=1&dtype=0">YHOO</a>&nbsp;<a target=_blank href="http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|{$url[0]|urlencode}">GOOLE</a>&nbsp;<a target=_blank href="/self/admin/jpallfunc?word={$url[0]|urlencode}">SELF</a><div id="xiaodi"></div>
</form>
<br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>

{literal}
<script language="javascript">

var needrefresh=0;
function setrefresh(){
	needrefresh=1;
}

function checksave(event){
	if(event.button==2){
		event.preventDefault(); 
        event.stopPropagation(); 
		save();
		return;
	}
}


function save(){
   var param={		
		kannji: $("#kannji2").val(),
		yomi: $("#yomi2").val(),
		lang: "{/literal}{$post.lang|escape}{literal}"
    };	
	document.getElementById("loading").value="Saving";
	$.post("http://localhost:5558/self/admin/rubyjp/",param,
	  function(data){
	    document.getElementById("loading").value="ok";
	});   
    $("#yomi2").val("");
    $("#kannji2").val("");    
}

 $(document).ready(function(){
   setrefresh();
   loading();
 });


function loading(){
	if(needrefresh){
		var selected=$("#kannji2").val();
		var url="http://localhost:5558/self/admin/getjapanese/"+selected+"/{/literal}{$url[1]|escape}/{literal}";
		var url2="http://localhost:5558/self/admin/getjapanese2/"+selected+"/{/literal}{$url[1]|escape}/{literal}";
		document.getElementById("loading").value="Loading";
		document.getElementById("yomi2").value="";
		$("#xiaodi").html(selected+"Loading..");	
		$.get(url, function(data){	     
		  document.getElementById("yomi2").value=data;		  
		  document.getElementById("loading").value="ok";
		  //save();
		});
		$.get(url2, function(data){	  
		  $("#xiaodi").html(data);	  
		});
	}
	needrefresh=0;
}

setInterval('loading()',500);

</script>

{/literal}


{if !$get.min}
<iframe name="myframe" src="http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p={$url[0]|urlencode}&stype=1&dtype=0" frameborder=0 height="400" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=-170 scrolling=yes width="90%"></iframe><br>
<iframe name="myframe2" src="http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|{$url[0]|urlencode}" frameborder=0 height="400" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=-170 scrolling=yes width="90%"></iframe>
{/if}


</body>
</html>