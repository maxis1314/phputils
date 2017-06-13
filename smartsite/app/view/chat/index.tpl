{include file="_share/_head.tpl"}

<h2>Chat</h2>
<textarea cols=50 rows="10"  id="msg"  readonly></textarea><br>
Name:<input id=n style="width:80px">Say:<input id=s style="width:200px" onkeydown="{literal}if(event.keyCode==13){subform();}{/literal}">
<input type="button" onclick="subform()" value="Send">




{literal}
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
    	csrf_form_protection: {/literal}"{$v.form_csrf}"{literal}
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
    	csrf_form_protection: {/literal}"{$v.form_csrf}"{literal}
    };
	postUrl("/chat/get_chat",param,updatePage);

}
function updatePage(request) {
	if (request.readyState == 4) {
		if (request.status == 200) {
			var response = request.responseText.split("\n");
			response[0].replace(/\n/g, "")
			num=response[0];
			for (var j = 1 ; j < response.length ; j ++){
				response[j]=response[j].replace(/\n/g, "")
		     		//$("m").innerHTML=$("m").innerHTML+response[j];
		     	$("msg").value=$("msg").value+"\n"+response[j];
				$("msg").scrollTop=$("msg").scrollHeight; 
			}
			//$("msg").scrollTop=$("msg").scrollHeight;  
			//$("msg").scrollTop=$("msg").scrollHeight-$("msg").scrollWidth; 
			//$("m").value = response[0];
			//$("m").innerHTML =response[1].replace(/\n/g, "");
			//$("m").innerHTML =request.responseText;
		} else{
			//alert("status is " + request.status);
			//alert("网路故障 " + request.status);
		}
	}
	//$("m").innerHTML="Server is done!";
}



setInterval('receivedata()',2000);



</script>
{/literal}
<div id=navigation></div>


{include file="_share/_foot.tpl"}