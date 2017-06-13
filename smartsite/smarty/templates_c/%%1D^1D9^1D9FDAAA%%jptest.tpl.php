<?php /* Smarty version 2.6.18, created on 2009-10-28 12:37:23
         compiled from /home/likethewind/wx/app/view/admin/jptest.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/likethewind/wx/app/view/admin/jptest.tpl', 12, false),)), $this); ?>
<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<title>JPTest</title>
<script src="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/public/js/jquery.js" type="text/javascript"></script>
</head>
<body>
<div id=result>result</div>
<hr>
<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>

<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][1])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:<input id="input<?php echo $this->_foreach['foo']['iteration']; ?>
" type=text <?php echo 'onkeydown="if(event.keyCode==13){checkresult(this,'; ?>
'<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][0])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'<?php echo ','; ?>
<?php echo $this->_foreach['foo']['iteration']; ?>
,'<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][1])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'<?php echo ');return false;}">'; ?>
<div id="show<?php echo $this->_foreach['foo']['iteration']; ?>
" style="display:none"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'][0])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/<?php echo $this->_tpl_vars['item'][2]; ?>
<input id=report<?php echo $this->_foreach['foo']['iteration']; ?>
 type=button value="Report Error" onclick="reporterror('<?php echo $this->_tpl_vars['item'][1]; ?>
',<?php echo $this->_foreach['foo']['iteration']; ?>
);this.disabled=true;"></div><br>

<?php endforeach; endif; unset($_from); ?>


<?php echo '
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
		page: \'JPTEST\',
		ajaxwiki: 1,
		encode_hint: \'ぷ\',
		msg: \'&now; \'+errorstr,
		cmd: \'edit\',
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
		page: \'JPTESTERROR\',
		ajaxwiki: 1,
		encode_hint: \'ぷ\',
		msg: test,
		cmd: \'edit\',
		write: "ページの更新"
   	};	
	$.post("/index.php",param,
	  function(data){
	  	$("#report"+a).hidden("fast");	  	
	});	
}

</script>
'; ?>



<input id="savebtn" type=button value="保存错误结果" onclick="savejieguo();this.disabled=true;">



<a target=_blank href="http://localhost:5558/index.php?JPTEST">历史结果</a>
<br><br>

<input id="restartbtn" type=button value="重新来过!" onclick="location.reload();">


<a target=_blank href="/self/admin/jptest?type=2th">以前错的</a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/hatuonn.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</body>


</html>