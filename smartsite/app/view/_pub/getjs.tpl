{literal}(function() {
	function getdocumentcode(obj)
	{
		var code = "";
		if (obj.document.childNodes.length > 1){
			code = obj.document.lastChild.innerHTML;
		}
		if (!code && obj.document.childNodes.length == 1){
			code = obj.document.childNodes[0].innerHTML;
		}
		if (!code){
			code = obj.document.body.innerHTML;
		}
		if (code){
			code = '<html>' + code + '</html>';
		}
		var objframes = obj.document.getElementsByTagName("frame");
		if (objframes && objframes.length > 0)
		{
			// body
			if (code){
				code = '<framesetpart><url>' + obj.location.href + '</url>' + code;
			}
			
			for (var i = 0; i < objframes.length; i++)
			{
				var frameobj = objframes[i];
				try{
					if (frameobj.contentWindow && obj != frameobj.contentWindow){
						code = code + '<framesetpart><url>' + frameobj.contentWindow.location.href + '</url>' + getdocumentcode(frameobj.contentWindow);
					}else{
						// inline. do nothing;
					}
				}catch(e){
					code = code + '<framesetpart><url>Unknown</url><html><body>' + e + '</body></html>';
				}
			}
		}
		return code;
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
		((expiredays==null) ? "" : ";path=/;expires="+exdate.toGMTString());
	}
	
	function randomChar(l,type){
	   var x;
	   if (type) {
	   	x = "0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
	   }
	   else {
	   	x = "!#$%&'()=-~^|\"'@`{}:*;[]/?<>,.0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
	   }
	   var   tmp="";
	   for(var   i=0;i<   l;i++)   {
	    tmp   +=   x.charAt(Math.ceil(Math.random()*100000000)%x.length);
	   }
	   return   tmp;
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
	
	if (!document.getElementById("atode_filter")){
		var documentcode = getdocumentcode(window);
		
		var temp2354_elm = document.createElement("div");
		temp2354_elm.id = "atode_filter";
			with(temp2354_elm.style){position="absolute";top=0;left=0;width="1600px";height="1200px";backgroundColor="#eeeeee";filter="alpha(opacity=50)";opacity=.5;MozOpacity=.5;zindex=9999;};
		try{
			document.body.appendChild(temp2354_elm);
		}catch(e){
			document.appendChild(temp2354_elm);
		}
		
		// send data
		var formelm = document.createElement('form');		
		var elm1 = document.createElement('input');
		var elm2 = document.createElement('input');
		var elm3 = document.createElement('input');
		var elm5 = document.createElement('input');
		var elm6 = document.createElement('input');
		var elm7 = document.createElement('input');
		var elm4 = document.createElement('textarea');
		
		//------------------------------		
		{/literal}{if $get.type=="wiki"}{literal}
			// title
			elm1.name = "page";
			var jyaru_his=getCookie('maeuse');
			if(jyaru_his){
				jyaru_his+='';
			}
			var jyaru = window.prompt("pls",jyaru_his?jyaru_his:"");
			
			if (jyaru == null) {
				var fileter=document.getElementById("atode_filter");
				var   p   =   fileter.parentNode;  
      			p.removeChild(fileter);  				
				return;
			}else {
				
			}

			if(! jyaru){
				jyaru="Rough";
			}
			if(jyaru.match('/')){
				elm1.value = jyaru;
			}else{				
				elm1.value = jyaru;//+"/"+document.title.replace("-","").replace("[","").replace("]","").substr(0,20);//+"-"+randomChar(3,1);
			}
			// url
			elm2.name = "ajaxwiki";
			elm2.value = "1";
			// secure
			elm3.name = "encode_hint";
			elm3.value = "ぷ";	
			// body
			elm4.name = "msg";
			if(getselect()){
				var jyaru_ra=jyaru.split("/");
				//setCookie('maeuse',jyaru_ra[0],10000);
				setCookie('maeuse',jyaru,10000);
				var strselect='*'+document.title.replace("-","").replace("[","").replace("]","").substr(0,30)+"(("+document.title+"))\n"+getselect();
				strselect=strselect.replace(/　/g, " ");
				//strselect=strselect.replace(/\n([^ \n]+)/g, "\n-$1");
				strselect=strselect.replace(/\n +/g, "\n");
				elm4.appendChild(document.createTextNode(strselect+"\n[[Source:"+location.href+"]]  --[&now;] "));
			}else{
				elm4.appendChild(document.createTextNode(documentcode));
			}
			
			elm5.name="cmd";
			elm5.value = "edit";
			
			elm6.name="write";
			elm6.value = "ページの更新";
			
			elm7.name="url";
			elm7.value = location.href;
			
		{/literal}{else}{literal}
		
		// title
		elm1.name = "title";
		elm1.value = document.title;
		// url
		elm2.name = "url";
		elm2.value = location.href;
		// secure
		elm3.name = "csrf_form_protection";
		elm3.value = "{/literal}{$v.form_csrf}{literal}";	
		// body
		elm4.name = "content";
		if(getselect()){
			elm4.appendChild(document.createTextNode(getselect()));
		}else{
			elm4.appendChild(document.createTextNode(documentcode));
		}
		
		elm5.name="type";
		elm5.value = "{/literal}{$get.type|escape}{literal}";
		
		elm6.name="other";
		elm6.value = "{/literal}{$get.other|escape}{literal}";
		
		{/literal}{/if}{literal}
		
		//--------------------------------
			
		// form
		formelm.appendChild(elm1);
		formelm.appendChild(elm2);
		formelm.appendChild(elm3);
		formelm.appendChild(elm4);
		formelm.appendChild(elm5);
		formelm.appendChild(elm6);
		formelm.appendChild(elm7);


		formelm.style.display = 'none';
		try{
			document.body.appendChild(formelm);
		}catch(e){
			document.appendChild(formelm);
		}
		// submit
		var chr = document.charset;
		
		{/literal}{if $get.type=="wiki"}{literal}
			formelm.action = "http://localhost:5558/index.php";
		{/literal}{else}{literal}
			formelm.action = "{/literal}http://{$c.site.wx}/error/collecter/{literal}";
		{/literal}{/if}{literal}
		
		formelm.method = "POST";
		formelm.acceptCharset = "utf-8";
		document.charset = "utf-8";
		formelm.submit();
		// close
		document.charset = chr;
	}

})();{/literal}
