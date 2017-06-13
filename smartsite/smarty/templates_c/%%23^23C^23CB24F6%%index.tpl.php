<?php /* Smarty version 2.6.18, created on 2009-09-13 19:20:57
         compiled from /home/likethewind/wx/app/view/chat/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2>Chat</h2>
<textarea cols=50 rows="10"  id="msg"  readonly></textarea><br>
Name:<input id=n style="width:80px">Say:<input id=s style="width:200px" onkeydown="<?php echo 'if(event.keyCode==13){subform();}'; ?>
">
<input type="button" onclick="subform()" value="Send">




<?php echo '
<script type="text/javascript" src="/public/js/util.js"></script>
<script type="text/javascript" src="/public/js/prototype.js"></script>
<script language="javascript" type="text/javascript">

var num = 0;


function subform() {
	if($("n").value == ""){
		alert("input a name please!");
		$("n").focus();
		return;
	}

	var name = $("n").value;
	var subject = $("s").value;
	var param={
    	type: 1,
    	n: name,
    	s: subject,
    	csrf_form_protection: '; ?>
"<?php echo $this->_tpl_vars['v']['form_csrf']; ?>
"<?php echo '
    };
	postUrl("/chat/get_chat",param);
	$("s").value="";
	$("s").focus();
}

function receivedata() {
	Stamp = new Date();
	var param={
    	type: 2,
    	num: num,
    	csrf_form_protection: '; ?>
"<?php echo $this->_tpl_vars['v']['form_csrf']; ?>
"<?php echo '
    };
	postUrl("/chat/get_chat",param,updatePage);

}
function updatePage(request) {
	if (request.readyState == 4) {
		if (request.status == 200) {
			var response = request.responseText.split("\\n");
			response[0].replace(/\\n/g, "")
			num=response[0];
			for (var j = 1 ; j < response.length ; j ++){
				response[j]=response[j].replace(/\\n/g, "")
		     		//$("m").innerHTML=$("m").innerHTML+response[j];
		     	$("msg").value=$("msg").value+"\\n"+response[j];
				$("msg").scrollTop=$("msg").scrollHeight; 
			}
			//$("msg").scrollTop=$("msg").scrollHeight;  
			//$("msg").scrollTop=$("msg").scrollHeight-$("msg").scrollWidth; 
			//$("m").value = response[0];
			//$("m").innerHTML =response[1].replace(/\\n/g, "");
			//$("m").innerHTML =request.responseText;
		} else{
			//alert("status is " + request.status);
			//alert("网路故障 " + request.status);
		}
	}
	//$("m").innerHTML="Server is done!";
}



setInterval(\'receivedata()\',2000);



</script>
'; ?>

<div id=navigation></div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>