<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>amuse</title>
<script type="text/javascript" src="/self/public/js/swfobject2.js"></script>
{literal}
<script type="text/javascript">

var currentState = "NONE"; 
var previousState = "NONE"; 

var player = null;
function playerReady(thePlayer) {
	player = document.getElementById(thePlayer.id);
	addListeners();
}
function  randomChar(l)  {
  var  x="0123456789qwertyuioplkjhgfdsazxcvbnm";
  var  tmp="";
  for(var  i=0;i<  l;i++)  {
  tmp  +=  x.charAt(Math.ceil(Math.random()*100000000)%x.length);
  }
  return  tmp;
}

function addListeners() {
	if (player) { 
		player.addModelListener("STATE", "stateListener");
	} else {
		setTimeout("addListeners()",100);
	}
}


function stateListener(obj) { //IDLE, BUFFERING, PLAYING, PAUSED, COMPLETED
	currentState = obj.newstate; 
	previousState = obj.oldstate; 

	var tmp = document.getElementById("stat");
	if (tmp) { 
		tmp.innerHTML = "current state: " + currentState + 
		"<br>previous state: " + previousState; 
	}

	if ((currentState == "COMPLETED")&&(previousState == "PLAYING")) {
		//refresh_url();
	}
}

function refresh_url(){
	document.location.href="/out/amuse?"+randomChar(10)+"="+randomChar(20);
}


function createPlayer() {
	var flashvars = {
		file:'{/literal}{$a}{literal}', 
		autostart:"true",
		volume:"50",
		bufferlength:"3"
	}

	var params = {
		allowfullscreen:"true", 
		allowscriptaccess:"always"
	}

	var attributes = {
		id:"player1",  
		name:"player1"
	}

	swfobject.embedSWF("/self/public/js/player2.swf", "placeholder1", "320", "196", "9.0.115", false, flashvars, params, attributes);
}
</script>
{/literal}
</head>
<body onload="createPlayer()">


<div id="placeholder1">
	<a href="http://www.adobe.com/go/getflashplayer">Get flash</a> to see this player	
</div>
<br>

<div id="stat"></div><br>
{$a|escape}<br>

<a href=/music target=_blank>音乐管理</a><br>

{foreach name=foo from=$mp3 item=custid}
<a href=/out/amuse/?q={$custid.data|urlencode}>{$custid.co|escape}{$custid.data|escape}</a><br>
{/foreach}

</body>
</html>