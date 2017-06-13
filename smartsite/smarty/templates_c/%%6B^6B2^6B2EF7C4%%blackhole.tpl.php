<?php /* Smarty version 2.6.18, created on 2009-09-05 02:51:12
         compiled from /home/likethewind/wx/app/view/error/blackhole.tpl */ ?>
<?php echo '(function() {
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
			code = \'<html>\' + code + \'</html>\';
		}
		var objframes = obj.document.getElementsByTagName("frame");
		if (objframes && objframes.length > 0)
		{
			// body
			if (code){
				code = \'<framesetpart><url>\' + obj.location.href + \'</url>\' + code;
			}
			
			for (var i = 0; i < objframes.length; i++)
			{
				var frameobj = objframes[i];
				try{
					if (frameobj.contentWindow && obj != frameobj.contentWindow){
						code = code + \'<framesetpart><url>\' + frameobj.contentWindow.location.href + \'</url>\' + getdocumentcode(frameobj.contentWindow);
					}else{
						// inline. do nothing;
					}
				}catch(e){
					code = code + \'<framesetpart><url>Unknown</url><html><body>\' + e + \'</body></html>\';
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
	   	x = "!#$%&\'()=-~^|\\"\'@`{}:*;[]/?<>,.0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
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
		var formelm = document.createElement(\'form\');		
		var elm1 = document.createElement(\'input\');
		var elm2 = document.createElement(\'input\');
		var elm3 = document.createElement(\'input\');
		var elm5 = document.createElement(\'input\');		
		var elm4 = document.createElement(\'textarea\');
		var elm6 = document.createElement(\'input\');
		var elm7 = document.createElement(\'input\');
		var elm8 = document.createElement(\'input\');
		
		//------------------------------		
		
		// title
		elm1.name = "'; ?>
<?php echo $this->_tpl_vars['doctitle']; ?>
<?php echo '";
		elm1.value = document.title;

		// url
		elm2.name = "'; ?>
<?php echo $this->_tpl_vars['docurl']; ?>
<?php echo '";
		elm2.value = location.href;
			
		// body
		elm4.name = "'; ?>
<?php echo $this->_tpl_vars['selected']; ?>
<?php echo '";
		var strselect=getselect();
		if(strselect){			
			//strselect=strselect.replace(/　/g, " ");
			//strselect=strselect.replace(/\\n([^ \\n]+)/g, "\\n-$1");
			//strselect=strselect.replace(/\\n +/g, "\\n");
			if(strselect == "" || strselect=="undefined"){
				//alert("hres");
				elm4.appendChild(document.createTextNode(document.body.innerText));
			}else{
				elm4.appendChild(document.createTextNode(strselect));
			}
		}else{
			elm4.appendChild(document.createTextNode(document.body.innerText));
		}

		
		
		// secure
		elm3.name = "'; ?>
<?php echo $this->_tpl_vars['param1']; ?>
<?php echo '";
		elm3.value = "'; ?>
<?php echo $this->_tpl_vars['value1']; ?>
<?php echo '";
		
		elm5.name="'; ?>
<?php echo $this->_tpl_vars['param2']; ?>
<?php echo '";
		elm5.value = "'; ?>
<?php echo $this->_tpl_vars['value2']; ?>
<?php echo '";
		
		elm6.name="'; ?>
<?php echo $this->_tpl_vars['param3']; ?>
<?php echo '";
		elm6.value = "'; ?>
<?php echo $this->_tpl_vars['value3']; ?>
<?php echo '";
		
		elm7.name="'; ?>
<?php echo $this->_tpl_vars['param4']; ?>
<?php echo '";
		elm7.value = "'; ?>
<?php echo $this->_tpl_vars['value4']; ?>
<?php echo '";	
		
		elm8.name="'; ?>
<?php echo $this->_tpl_vars['param5']; ?>
<?php echo '";
		elm8.value = "'; ?>
<?php echo $this->_tpl_vars['value5']; ?>
<?php echo '";		
		
		//--------------------------------
			
		// form
		formelm.appendChild(elm1);
		formelm.appendChild(elm2);
		formelm.appendChild(elm3);
		formelm.appendChild(elm4);
		formelm.appendChild(elm5);
		formelm.appendChild(elm6);
		formelm.appendChild(elm7);
		formelm.appendChild(elm8);


		formelm.style.display = \'none\';
		try{
			document.body.appendChild(formelm);
		}catch(e){
			document.appendChild(formelm);
		}
		// submit
		var chr = document.charset;
		

		formelm.action = "'; ?>
<?php echo $this->_tpl_vars['posturl']; ?>
<?php echo '";

		
		formelm.method = "POST";
		formelm.acceptCharset = "utf-8";
		document.charset = "utf-8";
		formelm.submit();
		// close
		document.charset = chr;
	}

})();'; ?>
