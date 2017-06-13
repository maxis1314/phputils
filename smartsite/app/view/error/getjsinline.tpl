{literal}(function() {

document.title="fangyi";

var linkElem = document.createElement('link');
linkElem.rel='stylesheet';
linkElem.type='text/css';
linkElem.href='http://localhost:5558/rubythings.css';
document.getElementsByTagName('head')[0].appendChild(linkElem);

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

function setframe(evt){
	var selected=getselect();
	settext(selected);
}

function settext(text){
	if(text){		
		parent.frames["iframe3g4454"].location.href='http://localhost:5558/self/admin/rubyinline/'+encodeURI(text)+'/{/literal}{$url[0]}{literal}/?min=1';
		return;
	}
}


function callfromchild(){
	alert("333");
}



var x= document.body.innerHTML;
{/literal}
{foreach name=foo from=$replace item=item}
x=x.replace(/{$item[1]}/g,"<ruby><rb><font color=blue>{$item[1]}</font></rb><rp></rp><rt><a target=_blank href='http://localhost:5558/self/admin/rubyinline/{$item[1]|urlencode}/jp/'><font color=red>{$item[0]}</font></a></rt><rp></rp></ruby>");
{/foreach}


{if !$url[0]}
document.body.innerHTML=x;
{else}
{literal}
document.body.innerHTML="";

//otherthing
var maindiv = document.createElement("div");
var mydiv = document.createElement("div");
var iframe = document.createElement("iframe");
iframe.name="iframe3g4454";
iframe.width=1000;
iframe.height=700;
iframe.src="http://localhost:5558/self/admin/rubyinline/?min=1";
mydiv.appendChild(iframe);
maindiv.id="main3g4454";
mydiv.id="navigation3g4454";
maindiv.innerHTML=x+"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

document.body.appendChild(maindiv);
document.body.appendChild(mydiv);

document.body.onmouseup = function (evt) { setframe(evt); };

{/literal}
{/if}

{literal}
})();{/literal}
