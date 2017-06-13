var IE = document.all;
var PosTimer;
function stickNavi() {
	var y = document.body.scrollTop;
	var s = document.getElementById('navigation').style
	s.top = y + 60;
	s.right = 60;
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

function setFontSize(pt){

  try{

    var t=document.getElementById("textboxContent");

    if(t){

      t.style.fontSize=pt+"pt";

    }

  }catch(e){}

}



function postUrl(url, param, func){
    new Ajax.Request(url, {
        asynchronous: true,
        evalScripts: true,
        method: 'post',
        parameters: addSync(hash2query(param)),
        onComplete: function(request){
            func(request)
        }
    });
}

function go2url(str,url){
	if (confirm(str)) {
		window.location.href = url;
	}
}


function toggleSource( id )
{
  var elem
  var link

  if( document.getElementById )
  {
    elem = document.getElementById( id )
    link = document.getElementById( "l_" + id )
  }
  else if ( document.all )
  {
    elem = eval( "document.all." + id )
    link = eval( "document.all.l_" + id )
  }
  else
    return false;

  if( elem.style.display == "block" )
  {
    elem.style.display = "none"
    link.innerHTML = "show"
  }
  else
  {
    elem.style.display = "block"
    link.innerHTML = "hide"
  }
}


function getUrl(url,func,divid){
    new Ajax.Request(addSync(url), {
        asynchronous: true,
        evalScripts: true,
        method: 'get',
		onSuccess: function(request){
            func(request,divid)
        }
    });
}

function ranInt(a){
	var vNum;
    vNum = Math.random();
    vNum = Math.round(vNum*a);
	return vNum;
}

function getUrlJson(url,func,divid){
	$(divid).innerHTML="";
    $(divid).className='ajax-loading';
    new Ajax.Request(addSync(url), {
        asynchronous: true,
        evalScripts: true,
        method: 'get',
		onSuccess: function(request){
            func(request,divid)
        }
    });
}

function postUrlJson(url, param, func,divid){
	$(divid).innerHTML="";
    $(divid).className='ajax-loading';
    new Ajax.Request(url, {
        asynchronous: true,
        evalScripts: true,
        method: 'post',
        parameters: addSync(hash2query(param)),
        onComplete: function(request){
            func(request,divid)
        }
    });
}


function accessUrl(url){
    new Ajax.Request(addSync(url), {
        asynchronous: true,
        evalScripts: true,
        method: 'get'
    });
}




function replaceUrl(url, divid){
    testMessageBox();
    new Ajax.Request(addSync(url), {
        asynchronous: true,
        evalScripts: true,
        method: 'get',
        onComplete: function(request){
            updatePageHtml(request, divid)
        }
    });
}

function addSync(url){
    var Stamp = new Date();
    return url + "&rsyc=" + encodeURI(Stamp.toString());
}

function updatePageHtml(request, divid, func){
    if (request.readyState == 4) {
        if (request.status == 200) {
            if (func) {
                func(request, divid);
            }
            else {
                $(divid).innerHTML = request.responseText;
            }
        }
        else {
            //alert("status is " + request.status);
        }
    }
    else {
        //error code here
    }
	
    closeWindow();
    document.body.scrollTop=0;
}

function hash2query(a){
    /*var a = {
     first: 10,
     second: 20,
     third: 30
     };*/
    return $H(a).toQueryString();
}



function HighLight(nWord){
    if (document.createRange) {
        var range = document.createRange();
    }
    else {
        var range = document.body.createTextRange();
    }
    //while(orange.findText(nWord)){
    //	orange.pasteHTML("<span style='color:black;background-color: #ff9999;'>" + orange.text + "</span>");
    //	orange.moveStart('character',1);
    //}
    if (range.findText) {
        while (range.findText(nWord)) {
            range.pasteHTML(range.text.fontcolor("#ff0000"));
            range.collapse(true);
        }
    }
    else {
        var s, n;
        s = window.getSelection();
        while (window.find(nWord)) {
            var n = document.createElement("SPAN");
            n.style.color = "#ff0000"
            s.getRangeAt(0).surroundContents(n);
        }
    }
}

function highword(nWord){
    nWord = nWord.replace(/\ /g, "|");
    
    var Arr = nWord.split("|");
    for (var i = 0; i < Arr.length; i++) {
        HighLight(Arr[i]);
    }
}

function markWord(a){
    highword(a);
}


function showtip(who){
    var tip = document.getElementById("toolTip2");
    var scrX;
    var scrY;
    
    scrY = who.offsetTop;
    scrX = who.offsetLeft;
    
    var tp = parseInt(scrY + 25);
    var lt = parseInt(scrX + 100);
    tip.innerHTML = "<p>0000<em>9999</em></p>";
    if (parseInt(document.documentElement.clientWidth + document.documentElement.scrollLeft) < parseInt(tip.offsetWidth + lt)) {
        tip.style.left = parseInt(lt - (tip.offsetWidth + 10)) + 'px';
    }
    else {
        tip.style.left = lt + 'px';
    }
    if (parseInt(document.documentElement.clientHeight + document.documentElement.scrollTop) < parseInt(tip.offsetHeight + tp)) {
        tip.style.top = parseInt(tp - (tip.offsetHeight + 10)) + 'px';
    }
    else {
        tip.style.top = tp + 'px';
    }
    tip.style.display = 'block';
    tip.style.opacity = '.80';
    tip.style.filter = "alpha(opacity:80)";
}

function hidtip(){
    var tip = document.getElementById("toolTip2");
    tip.style.display = 'none';
}

//helper function to create the form
function getNewSubmitForm(){
    var submitForm = document.createElement("FORM");
    //document.body.appendChild(submitForm);
    submitForm.method = "POST";
    return submitForm;
}

//helper function to add elements to the form
function createNewFormElement(inputForm, elementName, elementValue){
    var newElement = document.createElement("<input name='" + elementName + "' type='hidden'>");
    inputForm.appendChild(newElement);
    newElement.value = elementValue;
    return newElement;
}

//function that creates the form, adds some elements
//and then submits it
function createFormAndSubmit(){
    var submitForm = getNewSubmitForm();
    createNewFormElement(submitForm, "content", window.clipboardData.getData("Text"));
    submitForm.action = "";
    submitForm.submit();
}


function test(){
    var url = '';
    var pars = 'comment=' + encodeURL(window.clipboardData.getData("Text"));
    //var   pars   =   'comment=2222';   
    var myAjax = new Ajax.Request(url, {
        method: 'post',
        parameters: pars
    });
}


//test();

function encodeURL(str){

    var s0, i, s, u;
    
    s0 = ""; // encoded str
    for (i = 0; i < str.length; i++) { // scan the source
        s = str.charAt(i);
        
        u = str.charCodeAt(i); // get unicode of the char
        if (s == " ") {
            s0 += "+";
        } // SP should be converted to "+"
        else {
        
            if (u == 0x2a || u == 0x2d || u == 0x2e || u == 0x5f || ((u >= 0x30) && (u <= 0x39)) || ((u >= 0x41) && (u <= 0x5a)) || ((u >= 0x61) && (u <= 0x7a))) { // check for escape
                s0 = s0 + s; // don't escape
            }
            
            else { // escape
                if ((u >= 0x0) && (u <= 0x7f)) { // single byte format
                    s = "0" + u.toString(16);
                    
                    s0 += "%" + s.substr(s.length - 2);
                    
                }
                
                else 
                    if (u > 0x1fffff) { // quaternary byte format (extended)
                        s0 += "%" + (oxf0 + ((u & 0x1c0000) >> 18)).toString(16);
                        
                        s0 += "%" + (0x80 + ((u & 0x3f000) >> 12)).toString(16);
                        
                        s0 += "%" + (0x80 + ((u & 0xfc0) >> 6)).toString(16);
                        
                        s0 += "%" + (0x80 + (u & 0x3f)).toString(16);
                        
                    }
                    
                    else 
                        if (u > 0x7ff) { // triple byte format
                            s0 += "%" + (0xe0 + ((u & 0xf000) >> 12)).toString(16);
                            
                            s0 += "%" + (0x80 + ((u & 0xfc0) >> 6)).toString(16);
                            
                            s0 += "%" + (0x80 + (u & 0x3f)).toString(16);
                            
                        }
                        
                        else { // double byte format
                            s0 += "%" + (0xc0 + ((u & 0x7c0) >> 6)).toString(16);
                            
                            s0 += "%" + (0x80 + (u & 0x3f)).toString(16);
                            
                        }
                
            }
            
        }
        
    }
    
    return s0;
    
}



/*  Function Equivalent to URLDecoder.decode(String, "UTF-8")
 Copyright (C) 2002 Cresc Corp.
 Version: 1.0
 */
function decodeURL(str){

    var s0, i, j, s, ss, u, n, f;
    
    s0 = ""; // decoded str
    for (i = 0; i < str.length; i++) { // scan the source str
        s = str.charAt(i);
        
        if (s == "+") {
            s0 += " ";
        } // "+" should be changed to SP
        else {
        
            if (s != "%") {
                s0 += s;
            } // add an unescaped char
            else { // escape sequence decoding
                u = 0; // unicode of the character
                f = 1; // escape flag, zero means end of this sequence
                while (true) {
                
                    ss = ""; // local str to parse as int
                    for (j = 0; j < 2; j++) { // get two maximum hex characters to parse
                        sss = str.charAt(++i);
                        
                        if (((sss >= "0") && (sss <= "9")) || ((sss >= "a") && (sss <= "f")) || ((sss >= "A") && (sss <= "F"))) {
                        
                            ss += sss; // if hex, add the hex character
                        }
                        else {
                            --i;
                            break;
                        } // not a hex char., exit the loop
                    }
                    
                    n = parseInt(ss, 16); // parse the hex str as byte
                    if (n <= 0x7f) {
                        u = n;
                        f = 1;
                    } // single byte format
                    if ((n >= 0xc0) && (n <= 0xdf)) {
                        u = n & 0x1f;
                        f = 2;
                    } // double byte format
                    if ((n >= 0xe0) && (n <= 0xef)) {
                        u = n & 0x0f;
                        f = 3;
                    } // triple byte format
                    if ((n >= 0xf0) && (n <= 0xf7)) {
                        u = n & 0x07;
                        f = 4;
                    } // quaternary byte format (extended)
                    if ((n >= 0x80) && (n <= 0xbf)) {
                        u = (u << 6) + (n & 0x3f);
                        --f;
                    } // not a first, shift and add 6 lower bits
                    if (f <= 1) {
                        break;
                    } // end of the utf byte sequence
                    if (str.charAt(i + 1) == "%") {
                        i++;
                    } // test for the next shift byte
                    else {
                        break;
                    } // abnormal, format error
                }
                
                s0 += String.fromCharCode(u); // add the escaped character
            }
            
        }
        
    }
    
    return s0;
    
}



function getselect(){
    var a = "";//.toUpperCase();
    try {
        var selecter = window.getSelection();
        a = selecter;
    } 
    catch (err) {
        var selecter = document.selection.createRange();
        a = selecter.text;
    }
    a = a.toString().replace(/ /g, "");
    if (a.length > 20) {
        a = "";
    }
    return a;
}

function getselectobj(){
    var txt = '';
    var foundIn = '';
    if (window.getSelection) {
        txt = window.getSelection();
        foundIn = 'window.getSelection()';
    }
    else 
        if (document.getSelection) {
            txt = document.getSelection();
            foundIn = 'document.getSelection()';
        }
        else 
            if (document.selection) {
                txt = document.selection.createRange().text;
                foundIn = 'document.selection.createRange()';
            }
            else 
            
                return txt;
    
}

function markselect(a){
    var e = document.getElementById('comment');
    if (e.selectionStart != undefined && e.selectionEnd != undefined) {
        lastscroll = e.scrollTop;
        var start = e.selectionStart;
        var end = e.selectionEnd;
        var length = e.value.length;
        var before = e.value.substring(0, start);
        var after = e.value.substring(end, length);
        var middle = e.value.substring(start, end);
        e.value = before + "[" + a + "]" + middle + "[/" + a + "]" + after;
        e.scrollTop = lastscroll;
        //return e.value.substring(start, end);
    }
    else {
        document.selection.createRange().text = '[' + a + ']' + document.selection.createRange().text + '[/' + a + ']';
    }
}

function dic(){
    var a = getselect();
    if (!a) {
        return;
    }
    newWin = window.open("http://dict.hjenglish.com/jp/w/" + a + "&type=jc", "theNewWindow", "width=700,height=700,top=0,left=0,location=no,menubar=no,resizable=yes,screenX=0,  screenY=0,status=no,toolbar=no");
}

function openwindow(url){
    window.open(url, "", "width=1000,height=800,top=20,left=20,location=yes,menubar=yes,resizable=yes,screenX=0,  screenY=0,status=yes,toolbar=yes");
}

function new_window_select(url){
    var a = getselect();
    if (!a) {
        return;
    }
    newWin = window.open(url + encodeURL(a), "theNewWindow", "width=700,height=700,top=0,left=0,location=no,menubar=no,resizable=yes,screenX=0,  screenY=0,status=no,toolbar=no");
}

function redirect_select(url){
    var a = getselect();
    if (!a) {
        return;
    }
    if (Browser.Type.Gecko) {
        location.href = url + a;
        
    }
    else {
        document.location = url + encodeURL(a);
    }
}

function redirect_js(url){
    if (Browser.Type.Gecko) {
        location.href = url;
    }else {
        document.location = url;
    }
}

var Browser = {
    Type: {
        IE: !!(window.attachEvent && !window.opera),
        Opera: !!window.opera,
        WebKit: navigator.userAgent.indexOf('AppleWebKit/') > -1,
        Gecko: navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1,
        MobileSafari: !!navigator.userAgent.match(/Apple.*Mobile.*Safari/)
    }
}

function copyLink(id){
    var tempval = document.getElementById(id);
    tempval.value = window.location.href;
    tempval.select();
    var therange = tempval.createTextRange();
    therange.execCommand("Copy");
}



loadingimage = new Image();
loadingimage.src = "/public/images/lightbox/loading.gif";

//ajax loading
var isIe = (document.all) ? true : false;
//设置select的可见状态
function setSelectState(state){
    var objl = document.getElementsByTagName('select');
    for (var i = 0; i < objl.length; i++) {
        objl[i].style.visibility = state;
    }
}

function mousePosition(ev){
    if (ev.pageX || ev.pageY) {
        return {
            x: ev.pageX,
            y: ev.pageY
        };
    }
    return {
        x: ev.clientX + document.body.scrollLeft - document.body.clientLeft,
        y: ev.clientY + document.body.scrollTop - document.body.clientTop
    };
}

//弹出方法
function showMessageBox(wTitle, content, wWidth){
    closeWindow();
    var bWidth = parseInt(document.documentElement.scrollWidth);
    var bHeight = parseInt(document.documentElement.scrollHeight);
	var bNowTop=parseInt(document.body.scrollTop);
    if (isIe) {
        setSelectState('hidden');
    }
    var back = document.createElement("div");
    back.id = "back";
    var styleStr = "top:0px;left:0px;position:absolute;background:#666;width:" + bWidth + "px;height:" + bHeight + "px;";
    styleStr += (isIe) ? "filter:alpha(opacity=0);" : "opacity:0;";
    back.style.cssText = styleStr;
    document.body.appendChild(back);
    showBackground(back, 50);
    var mesW = document.createElement("div");
    mesW.id = "mesWindow";
    mesW.className = "mesWindow";
    mesW.innerHTML = "<div class='mesWindowTop'></div><div class='ajax-loading' id='mesWindowContent' align=center>" + content + "</div><div class='mesWindowBottom'></div>";
    styleStr = "left:" + ((bWidth - wWidth) / 2) + "px;top:"+(bNowTop+200)+"px;position:absolute;width:" + wWidth + "px;";
    mesW.style.cssText = styleStr;
    document.body.appendChild(mesW);
}

//让背景渐渐变暗
function showBackground(obj, endInt){
    if (isIe) {
        obj.filters.alpha.opacity += 1;
        if (obj.filters.alpha.opacity < endInt) {
            setTimeout(function(){
                showBackground(obj, endInt)
            }, 5);
        }
    }
    else {
        var al = parseFloat(obj.style.opacity);
        al += 0.01;
        obj.style.opacity = al;
        if (al < (endInt / 100)) {
            setTimeout(function(){
                showBackground(obj, endInt)
            }, 5);
        }
    }
}

//关闭窗口
function closeWindow(){
    if (document.getElementById('back') != null) {
        document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
    }
    if (document.getElementById('mesWindow') != null) {
        document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
    }
    if (isIe) { 
        setSelectState('');
    }
}

//测试弹出
function testMessageBox(){
    messContent = "loading...";
    showMessageBox('Title', messContent, 350);
}



function seebook(where,bookname,page,allpage,direct,inputpage){
	var nowreading=getbookcookie();
	var rapage=ranInt(allpage);
	if(!nowreading[bookname]){
		nowreading[bookname]=0;
	}
	if(!page){
		if(direct == 1){
			page=nowreading[bookname]+1;
		}else{
			page=nowreading[bookname]-1;
		}		
	}
	if(page > allpage){
		$(where).innerHTML="over";
		nowreading[bookname]=0;
		return;
	}
	$(inputpage).value=page;
	getUrlJson("/wi/wiislidefile/"+bookname+"/"+page+".json?",pjson,where);
	nowreading[bookname]=page;
	setbookcookie(nowreading);
}
function pjson(request,divid){
    if (request.readyState == 4) {
        if (request.status == 200) {
			var list;
			eval("list="+request.responseText);
			tex=list[1];
			tex = tex.replace(/\r\n/g, "<br />");
			tex = tex.replace(/(\n|\r)/g, "<br />");
			tex = tex.replace(/(<br \/>){2,}/g, "<br />");
			tex = tex.replace(/<br \/>/g, "<br />\n");
			$(divid).innerHTML=tex;
			$(divid).className='wikiblock';
		}
	}
}

function insertbookread(name,slidename,allpage,init){
	var a=ranInt(1000).toString();
	document.write("<h2><a href=/wi/wiislidefileajax/"+slidename+">"+name+"</a>&nbsp;&nbsp;<font size=1>("+allpage+" pages)</font></h2>");
	document.write("<a href=# class=\"green\" onclick=\"seebook('bookread_"+a+slidename+"','"+slidename+"',0,"+allpage+",-1,'bkpageid_"+a+slidename+"');return false;\">prev</a>");
	document.write("<a href=# class=\"green\" onclick=\"seebook('bookread_"+a+slidename+"','"+slidename+"',0,"+allpage+",1,'bkpageid_"+a+slidename+"');return false;\">next</a>&nbsp;&nbsp;<input id=bkpageid_"+a+slidename+" type=text size=2>&nbsp;<a href=# class=\"green\" onclick=\"var a= parseInt($('bkpageid_"+a+slidename+"').value);seebook('bookread_"+a+slidename+"','"+slidename+"',a,"+allpage+",1,'bkpageid_"+a+slidename+"');return false;\">GO</a><br>");
	document.write("<div class=wikiblock  id='bookread_"+a+slidename+"'>Press either link above to begin reading.</div>");
	if(init){
		seebook("bookread_"+a+slidename,slidename,init,allpage,1,"bkpageid_"+a+slidename);
	}
}



function getCookie(name) {
        var prefix = name + "="
        var cookieStartIndex = document.cookie.indexOf(prefix)
        if (cookieStartIndex == -1)
                return null
        var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length)
        if (cookieEndIndex == -1)
                cookieEndIndex = document.cookie.length
        return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex))
}
function setCookie(c_name,value,expiredays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}
function getbookcookie(){
	var info=getCookie("readbook");
	var temp = $H({});
	if(!info){
		return temp;
	}
	var infoa=info.split("|");
	
	var middle;
	for(var i=0; i< infoa.length;i++){
		//if(infoa[i].match("V_")){
		//infoa[i]=infoa[i].replace(/V_/,"");
		//infoa[i]=infoa[i].replace(/-/,"_");
		middle=infoa[i].split(":");
		temp[middle[0]]=parseInt(middle[1]);
		//document.write(temp[0],"(",temp[1],")&nbsp;");
	}
	return temp;
}
function setbookcookie(raw){
	var temp = new Array();
	var str="";
	raw.each(function(pair) {
	  str=str+pair.key+":"+pair.value+"|";
	});
	setCookie("readbook",str,3650);
}


