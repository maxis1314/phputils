<?php /* Smarty version 2.6.18, created on 2009-08-30 18:28:45
         compiled from /home/.escort/likethewind/wx/app/view/admin/rubyjp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/admin/rubyjp.tpl', 100, false),)), $this); ?>
<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>fanyi</title>
<script src="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/public/js/jquery.js" type="text/javascript"></script>
 <meta http-equiv="content-style-type" content="text/css" />
<?php echo '
<style type="text/css">
ruby { display: inline-table }
ruby * {
display: inline;
line-height: 1.0;
text-indent: 1.2;
text-align: center;
white-space: nowrap;
}
ruby > * {
display: table-row-group;
}
ruby > rt, ruby rtc {
display: table-header-group;
font-size: 80%;
}
ruby rtc + rtc { display: table-footer-group }
ruby rbc > *, ruby rtc > * { display: table-cell }
/* this only works when an rt spans across all rb */
ruby rtc > *[rbspan] { display: table-caption }
ruby rp { display: none }

#navigation{
	RIGHT: 60px; 
	POSITION: absolute; 
	TOP: 60px;
	PADDING-RIGHT: 0px; 
	PADDING-LEFT: 1px; 
	PADDING-BOTTOM: 3px; 
	PADDING-TOP: 0px; 
	z-index:2;
}

#navigation2{
	LEFT: 0px; 
	POSITION: absolute; 
	TOP: 0px;
	PADDING-RIGHT: 0px; 
	PADDING-LEFT: 1px; 
	PADDING-BOTTOM: 3px; 
	PADDING-TOP: 0px;
	background:#FFFFFF;
	z-index:2;
}

#navigation3{
	position:absolute;
	'; ?>
<?php if ($this->_tpl_vars['post']['gongsi']): ?>top<?php else: ?>bottom<?php endif; ?><?php echo ':0px;
	right:16px;
	width:98%;	
	height:'; ?>
<?php if ($this->_tpl_vars['post']['gongsi']): ?>40<?php else: ?>85<?php endif; ?><?php echo 'px;
	text-align:left;
	background:#eee;
	z-index:2;
	overflow:hidden;
}


 a:link {
   text-decoration: none;
   }
   a:visited {
   color: blue;
   text-decoration: none;
   }
   a:hover {
   text-decoration: none;
   color: #FFFFFF;
   background-color:#0000FF;
   }
   a:active {
   text-decoration: none;
   color: #FFFFFF;
   }

#main {
position:absolute;
bottom:0px;
left:0px;

height:100%;
overflow:auto;
z-index:1;
}

</style>
'; ?>

</head>
<body onload="setNavi()">

<div id="navigation2">
<?php if (! $this->_tpl_vars['post']['gongsi']): ?>
<iframe frameborder=0 height="300" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=0 scrolling=yes width="500" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></iframe><br>
<?php endif; ?>
</div>


<div id="main">
<?php if (! $this->_tpl_vars['post']['gongsi']): ?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php else: ?>
<br><br><br>
<?php endif; ?>

<table border=0><tr><td width="75%">
<div onmouseup="setkannji(event)" oncontextmenu="return false;">
<font size=4>
<div id="refresh">
<?php echo $this->_tpl_vars['result']; ?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div>
</font>
</div>

<hr>
<form method=POST action="/admin/rubyjp/<?php echo ((is_array($_tmp=$this->_tpl_vars['last_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<a href="/admin/rubyjp/<?php echo ((is_array($_tmp=$this->_tpl_vars['last_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">SAVE</a>
<a href="/file">History</a>
<textarea name=ok>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ok'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

</textarea><a href="/error/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">[From..]</a>
<input id="kannji" type=text name=kannji><input type=button onclick="setrefresh();" value="Refresh"><input type=text name=yomi>
<input type=submit>
<input type=hidden name="url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<input type=hidden name="gongsi" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['gongsi'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<input type=hidden name="lang" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
</form>

</td>
<td valign=top width="25%">
<iframe name="myframe3" frameborder=0 height="500" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=-170 scrolling=no width="400"></iframe><br>

</td>
</tr>
</table>

</div>

<div id="navigation">
	<iframe name="myframe" frameborder=0 height="400" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=-170 scrolling=yes width="400"></iframe><br>
	<iframe name="myframe2" frameborder=0 height="300" margin-top=150 marginwidth=0 marginheight=0 hspace=0 vspace=-170 scrolling=yes width="400"></iframe>
</div>

<div id="navigation3">		
		<form method=POST action="/admin/rubyjp/<?php echo ((is_array($_tmp=$this->_tpl_vars['last_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">				
		<a href="/error/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">[From..]</a><a target=_blank href="/admin/jptest">[JPTEST]</a><a target=_blank href="/filecms/accessword">[HIS]</a>
		<?php echo '
		<input id="kannji2" type=text name=kannji size=6  onkeydown="if(event.keyCode==13){setrefresh2();return false;}">:<input id="yomi2" type=text name=yomi onkeydown="if(event.keyCode==13){save();return false;}">
		'; ?>
		
		<input type=button onclick="save();" value="save">
		<input type=hidden name="url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
		<input type=hidden name="lang" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
		<textarea style="display:none;">
		<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ok'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

		</textarea>
		<input type=button onclick="setrefresh();" value="refresh">
		<input type=text id="loading" value="ok" disabled size=4>
		<div id="xiaodi"></div>
		</form>	
</div>	


























<?php echo '
<script language="javascript">


function checksave(event){
	if(event.button==2){
		save();
	}
}

var needrefresh=0;

function openwindow(){
	newwindow(\'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=\'+document.getElementById("kannji").value+\'&stype=1&dtype=0\');
}
function newwindow(url){
  window.open(url,
  "",
  "width=750,height=600,top=100,left=100,scrollbars=yes,location=yes,menubar=no,resizable=yes,screenX=0,screenY=0,status=yes,toolbar=yes");
}

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

function setkannji(e){
	if(e.button==2){
		e.preventDefault(); 
        e.stopPropagation(); 
		save();
		return;
	}
	
	var selected=getselect();
	selected = selected.toString().replace(/ /g, "");
	selected = selected.toString().replace(/ /g, "");
	selected = selected.toString().replace(/　/g, "");
	
	
	if(selected){
		document.getElementById("kannji2").value=selected;		
		parent.frames["myframe2"].location.href=\'http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|\'+selected;
		if("'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '"=="en"){			
			parent.frames["myframe"].location.href=\'http://zidian.cn.yahoo.com/result_en2cn.html?p=\'+selected+\'&s=1&ei=utf-8&fr=\';			
			document.getElementById("yomi2").focus();
		}else{
			//parent.frames["myframe"].location.href=\'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=\'+selected+\'&stype=1&dtype=0\';
			if("'; ?>
<?php echo $this->_tpl_vars['post']['gongsi2']; ?>
<?php echo '"){
				parent.frames["myframe"].location.href=\'/admin/getjapanese23/\'+selected+\'/jp\';
			}else{
				parent.frames["myframe"].location.href=\'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=\'+selected+\'&stype=1&dtype=0\';				
			}
		}

		setrefresh2();
		loading();
	}
}

function displayyahoo(text){	
	parent.frames["myframe2"].location.href=\'http://translate.google.com/translate_t?sl=ja&tl=en#ja|zh-CN|\'+text;
	if("'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '"=="en"){			
		parent.frames["myframe"].location.href=\'http://zidian.cn.yahoo.com/result_en2cn.html?p=\'+text+\'&s=1&ei=utf-8&fr=\';		
	}else{
		if("'; ?>
<?php echo $this->_tpl_vars['post']['gongsi2']; ?>
<?php echo '"){
			parent.frames["myframe"].location.href=\'/admin/getjapanese23/\'+text+\'/jp\';
		}else{
			parent.frames["myframe"].location.href=\'http://dic.yahoo.co.jp/dsearch?enc=UTF-8&p=\'+text+\'&stype=1&dtype=0\';				
		}
	}
	var url="/admin/getjapanese2/"+text+"/'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo '";
	$("#xiaodi").html(text+"Loading...<br><img src=/image/ajax-loading.gif>");
	$.get(url, function(data){	        
	  $("#xiaodi").html(data);	  
	});	
}

var IE = document.all;
var PosTimer;
function stickNavi() {
	var y = document.body.scrollTop;
	var s = document.getElementById(\'navigation\').style

	s.top = y + 0;
	s.right = 0;


}

document.onkeydown = function(e) {
    var shift, ctrl, alt; 

    // Mozilla(Firefox, NN) and Opera 
    if (e != null) { 
        keycode = e.which; 
        ctrl = typeof e.modifiers == \'undefined\' ? e.ctrlKey : e.modifiers & Event.CONTROL_MASK; 
        shift = typeof e.modifiers == \'undefined\' ? e.shiftKey : e.modifiers & Event.SHIFT_MASK;
        alt = typeof e.modifiers == \'undefined\' ? e.altKey : e.modifiers & Event.ALT_MASK;  
        // &atilde;&sbquo;&curren;&atilde;&fnof;&trade;&atilde;&fnof;&sup3;&atilde;&fnof;&circ;&atilde;?&auml;&cedil;&Scaron;&auml;&frac12;&auml;&frac14;&aelig;&rsquo;&shy;&atilde;&sbquo;&rsquo;&eacute;&tilde;&sup2;&aelig;&shy;&cent; 
        //e.preventDefault(); 
        //e.stopPropagation(); 
    // Internet Explorer 
    } else { 
        keycode = event.keyCode; 
        ctrl = event.ctrlKey; 
        shift = event.shiftKey;
        alt = event.altKey
        // &atilde;&sbquo;&curren;&atilde;&fnof;&trade;&atilde;&fnof;&sup3;&atilde;&fnof;&circ;&atilde;?&auml;&cedil;&Scaron;&auml;&frac12;&auml;&frac14;&aelig;&rsquo;&shy;&atilde;&sbquo;&rsquo;&eacute;&tilde;&sup2;&aelig;&shy;&cent; 
        //event.returnValue = false; 
        //event.cancelBubble = true; 
    } 

    if(keycode == 27){//ESC CTRL
        save();
    }
}
function stickNaviLoop() {
	if (PosTimer){clearTimeout(PosTimer);}
	stickNavi();
	PosTimer = setTimeout("stickNaviLoop()", 10);
}
function setNavi() {
	if (IE) {document.body.onscroll = stickNavi;}
	else {stickNaviLoop();}
}


function save(){
   var param={		
		kannji: $("#kannji2").val(),
		yomi: $("#yomi2").val(),
		lang: "'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '"
    };

	document.getElementById("refresh").focus();
	
	$.post("/admin/rubyjp/",param,
	  function(data){
	    needrefresh=1;
	});   
    $("#yomi2").val("");
    $("#kannji2").val("");  
}


function refresh(){
	if(needrefresh>0){
		document.getElementById("loading").value="Redering";
		var url="/admin/rubyajax/'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['last_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/?gongsi=<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['gongsi'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '";
		$.get(url+"?"+randomChar(7,1), function(data){
		  document.getElementById("loading").value="Redered";
		  $("#refresh").html(data+"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>"); 
		});
	}
	needrefresh=needrefresh-1;
	//$("#refresh").html("dddddddddddd"); 
}

function setrefresh(){
	needrefresh=1;
}


function randomChar(l,type){
	var x;
   if (type) {
   	x = ".0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
   }
   else {
   	x = "!#$%&\'()=-~^|\\"\'@`{}:*;[]/?<>,.0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
   }
   var   tmp="";
   for(var   i=0;i<   l;i++)   {
    tmp   +=   x.charAt(Math.ceil(Math.random()*100000000)%x.length);
   }
   return   tmp;
}

setInterval(\'refresh()\',1000);

var needrefresh2=0;
function setrefresh2(){
	needrefresh2=1;
}
function loading(){
	if(needrefresh2){
		var selected=$("#kannji2").val();
		var url="/admin/getjapanese/"+selected+"/'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo '";
		var url2="/admin/getjapanese2/"+selected+"/'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['lang'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo '";
		document.getElementById("loading").value="Loading";
		document.getElementById("yomi2").value="";
		$("#xiaodi").html(selected+"Loading...<br><img src=/image/ajax-loading.gif>");	
		$.get(url, function(data){	     
		  document.getElementById("yomi2").value=data;		  
		  document.getElementById("loading").value="ok";
		});
		$.get(url2, function(data){	  
		  $("#xiaodi").html(data);	  
		});
	}
	needrefresh2=0;
}

setInterval(\'loading()\',500);
function savejieguo(errorstr){	
	var param={		
		page: \'生词本\',
		ajaxwiki: 1,
		encode_hint: \'ぷ\',
		msg: errorstr,
		cmd: \'edit\',
		write: "ページの更新",
		split: 1
   	};
	$("#xiaodi").html(errorstr+\' 保存中...\');	
	$.post("/index.php",param,
	  function(data){
	  	this.disabled=true;
	  	//$(\'#window\').css({ top: y, right: "0px" });
	  	$("#xiaodi").html(\'[\'+errorstr+"]已被加入你的<a target=_blank href=\'/index.php?生词本\'>生词本</a>");			
	}); 
}

</script>

'; ?>






</body>