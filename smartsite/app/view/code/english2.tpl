<title>Tool helping you to type english correctly</title>
{literal}
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="/public/js/suggest.js"></script>
<script type="text/javascript" src="/public/js/jquery.js"></script> 
<script type="text/javascript" src="/public/js/englishwordlist.js"></script>


<style type="text/css"> 
      <!--
        .dropdown {
          position: absolute;
          background-color: #FFFFFF;
          border: 1px solid #CCCCFF;
          width: 252px;
        }
        .dropdown div {
          padding: 1px;
          display: block;
          width: 250px;
          overflow: hidden;
          white-space: nowrap;
        }
        .dropdown div.select{
          color: #FFFFFF;
          background-color: #3366FF;
        }
        .dropdown div.over{
          background-color: #99CCFF;
        }
        -->
    </style>
    
    <script type="text/javascript" language="javascript"> 

    <!--       
      function start(){new Suggest.LocalMulti("text", "suggest", list, {ignoreCase: true, prefix: true, highlight: true,dispAllKey: true});};
      window.addEventListener ?
        window.addEventListener('load', start, false) :
        window.attachEvent('onload', start);
    //-->
    
function openwindow(url){
	window.open (url, "newwindow", "height=800, width=600, top=150, left=150, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no");
}
    
    //edit by tang on 2009/03/09 zidongbaocun
var saved=1;
var lastsaved="";
var lastgoogle="";

var otherstrmemu='<input type=button onclick="openwindow(\'/code/dn/{/literal}{$url[0]}{literal}\');" value="download"><input type=button onclick="openwindow(\'/code/show/{/literal}{$url[0]}{literal}\');" value="preview">';

function save2server(){
	if(saved == 1){
		return;
	}
	var param={
		id:	{/literal}'{$url[0]}'{literal},
		content: $("#content").val()
    };
    saved =1;
    var url="http://translate.google.com/translate_t?prev=hp&hl=ja&js=y&text="+lastsaved+"&sl=ja&tl=zh-CN&history_state0=#";	

    $("#msg").html("saved "+"<a target=_blank href="+url+">last word</a>"+otherstrmemu);
    
	$.post("/code/english",param);
}

function makethesame(){
	var old=$("#content").val();
	var new_text=$("#text").val();
	var cutlength=new_text.indexOf(' ',1);
	var copystr=new_text.substr(0,cutlength);
	var leftstr=new_text.substr(cutlength+1,new_text.length);
	var url="http://translate.google.com/translate_t?prev=hp&hl=ja&js=y&text="+new_text+"&sl=ja&tl=zh-CN&history_state0=#";	
	
	if(copystr == ''){
		if(lastgoogle!=new_text){
			lastgoogle=new_text;
			var patrn=/^[a-zA-Z ]+$/; 
			if (patrn.exec(new_text)){
				if(new_text.length>4){
					//parent.frames["myframe"].location.href='{/literal}{$transferurl}{literal}'+new_text+'';
				}
			}else{
				if(new_text.length>1){
					//parent.frames["myframe2"].location.href='http://translate.google.com/translate_t#zh-CN|en|'+new_text+'';
				}
			}
		}
	}else{
		if(lastsaved=="."){
			var f=copystr.charAt(0).toUpperCase();
    		copystr= f + copystr.substr(1);
		}
		lastsaved=copystr;
		var middlestr=' ';
		if(copystr==',' || copystr=='.'){
			middlestr='';
		}
		$("#content").val($("#content").val()+middlestr+copystr);
		//$("#content").scrollTop=$("#content").scrollHeight;
		var $cr222 = $('#content');
		$cr222.scrollTop($cr222.scrollTop()+100000);
		
		$("#text").val(leftstr);
		$("#msg").html("saving "+"<a target=_blank href="+url+">last word</a>"+otherstrmemu);
		saved=0;
		//get the mining
		if(false && copystr.length>4){
			//<div id="yisi" style="margin-left:300px; margin-top:4px;">&nbsp;</div>
			var yisiurl="/admin/getjapanese/"+copystr+"/en/";
			
			$("#yisi").html(copystr+" : loading");			
			$.get(yisiurl, function(data){	     
			  $("#yisi").html(copystr+" : "+data);		  
			});
		}		
		parent.frames["myframe"].location.href='{/literal}{$transferurl}{literal}'+copystr+'';
		parent.frames["myframe2"].location.href='http://translate.google.com/translate_t#en|zh-CN|'+copystr+'';
		$("#text").focus();
		lastgoogle="";
	}
}
function addEnglishWord(){
	var underindex=Math.floor(Math.random() * list.length);
	$("#content").val($("#content").val()+" ["+list[underindex]+"]");
	var $cr222 = $('#content');
	$cr222.scrollTop($cr222.scrollTop()+100000);
}
setInterval('makethesame()',500);
setInterval('save2server()',5000);
setInterval('addEnglishWord()',{/literal}{if $get.s}{$get.s|escape}{else}10000{/if}{literal});
    </script> 
    
{/literal}
<h3 style="margin-left:30px; margin-top:4px;">Tool helps you to type english correctly, input some words in the <font color=blue>blue</font> box below<a href=/code/english/>[CN]</a><a href=/code/englishja/>[JP]</a></h3>
<div id=msg style="margin-left:30px; margin-top:4px;">saved <input type=button onclick="openwindow('/code/dn/{$url[0]}');" value="download"><input type=button onclick="openwindow('/code/show/{$url[0]}');" value="preview"></div>


<div style="margin-left:30px; margin-top:4px;"> 

<table>
<tr><td>
<textarea id=content name=content rows=12 cols=70 style="font-size: 14pt;">{$record.content|escape}</textarea>
 </td></tr>

<tr><td>
<input id="text" type=text name=word1 value="" autocomplete="off"  style="display: block; width:618px; height: 30px;border: blue 1px solid;font-size: 14pt;"/>
<div id="suggest" class="dropdown"></div> 
</td>

</tr>
</table>

<table><tr><td>
<iframe name="myframe" frameborder=0 height="400" margin-top=0 marginwidth=0 marginheight=0 hspace=0 vspace=-155 scrolling=yes width="600"></iframe>
</td><td>
<iframe name="myframe2" frameborder=0 height="400" margin-top=0 marginwidth=0 marginheight=0 hspace=0 vspace=-155 scrolling=yes width="400"></iframe>
</td></tr>
</table>
</div>

