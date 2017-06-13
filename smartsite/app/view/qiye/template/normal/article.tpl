<html> 
<head> 
<title>{$qiye.title}</title> 
<meta name="description" content="{$qiye.desc}"> 
<meta name=keywords content="{$qiye.meta}"> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 


{literal}
<style type="text/css"> 
A {
	TEXT-DECORATION: none;color:#333333;
}
A:link {
	COLOR: #333333
}
A:visited {
	COLOR: #333333
}
A:hover {
	COLOR: #ff0000; TEXT-DECORATION: underline;
}

BODY {
    background-color:#CFDCE4;
}

TD {
   FONT-SIZE: 12px; color:#000000;
}

.LmSplit { margin-left:5px;margin-right:5px; }

/* ｵｼｺｽﾀｸﾑｽ｡｢ﾗﾖｷ逸｡｡｢ﾎﾄﾗﾖﾐﾐｸﾟｿﾘﾖﾆ */
.LanMu {font-size:12px;color: #74AF0F; line-height:40px; padding-left:10px;}

/* ｵｼｺｽﾀｸﾎﾄﾗﾖﾑｽ */
A.LanMuText:link { font-size:13px;color: #ffffff; text-decoration: none }
A.LanMuText:visited { font-size:13px;color: #ffffff; text-decoration: none }
A.LanMuText:active { font-size:13px;color: #ffffff; text-decoration: none }
A.LanMuText:hover { font-size:13px;color: #9BDFF2; text-decoration: underline}

/* ｶｼｶｵｼｺｽﾀｸ(ｼｴﾗﾓﾀｸﾄｿ)ﾎﾄﾗﾖﾑｽ */
A.SubLanMuText:link { font-size:12px;color: #333333; text-decoration: none}
A.SubLanMuText:visited { font-size:12px;color: #333333; text-decoration: none}
A.SubLanMuText:active { font-size:12px;color: #333333; text-decoration: none}
A.SubLanMuText:hover { font-size:12px;color: #94647C; text-decoration: none}

/* ﾍｾﾎｻﾖﾃｵｼｺｽﾎﾄﾗﾖﾑｽ */
A.WebPosLink:link { font-size:13px;color: #666666; text-decoration: none }
A.WebPosLink:visited { font-size:13px;color: #666666; text-decoration: none }
A.WebPosLink:active { font-size:13px;color: #666666; text-decoration: none }
A.WebPosLink:hover { font-size:13px;color: #94647C; text-decoration: underline}
.WebPosText {
  color:#666666;font-size:13px;padding-left:8px;
}


/* ﾖﾐｲｿﾇ鯢ｰｾｰﾑｽｶｨﾒ */
.MiddleFrame {
  color:#333333;padding-left:24px; padding-tottom:1px;
}
.MiddleFrame Span {
  FILTER: Glow(Color=#ffffff,Strength=1);height:14px;
}

.MiddleBody {
  PADDING-Left: 2px;PADDING-Right: 2px;
   
}

/* ﾍｾｹﾌｶｨｹｦﾄﾜﾇ鯡菠�ｽ｣ｬﾓﾃﾔﾚﾊ菠�ﾃｻｧﾃ﨧�ﾜﾂ */
.WebInputStyle 
{
 background-color:#FBFBFA;
 /*  BACKGROUND-Image: url(bg022.jpg); */
 color:#343434;
 font-size:12px;
 border-left:#565554 1px solid;
 border-top:#565554 1px solid;
 border-right:#E4E4E4 1px solid;
 border-bottom:#E4E4E4 1px solid;
 width:100px;
 height:20px;
}

/* ﾍｾｹﾌｶｨEmailｶｩﾔﾄﾊ菠�ｽ*/
.WebInputStyle_DY 
{
 background-color:#FBFBFA;
 /*  BACKGROUND-Image: url(bg022.jpg); */
 color:#343434;
 font-size:12px;
 border-left:#565554 1px solid;
 border-top:#565554 1px solid;
 border-right:#E4E4E4 1px solid;
 border-bottom:#E4E4E4 1px solid;
 width:140px;
 height:20px;
}

/* ﾍｾｹﾌｶｨｹｦﾄﾜﾇ魏ｴﾅ･ﾍｳﾒｻﾑｽ */
.WebButtonStyle 
{
  background-color:#F1F1F1;
 /*  BACKGROUND-Image: url(bg022.jpg); */
 color:#343434;
 font-size:12px;
 border-left:#EFEFEF 1px solid;
 border-top:#EFEFEF 1px solid;
 border-right:#363636 1px solid;
 border-bottom:#363636 1px solid;
}

/* ﾗ隯ﾂﾎﾄﾕﾂﾁﾐｱ桒鰉ｽ｣ｺﾗﾖﾌ衽ﾕﾉｫ｡｢ﾁﾐｱ槢ﾐｸﾟ */
.NewAList {
   color:#666666;line-height:180%;
}
.ArticleListChar {
   color:#666666;
}
.FrameAList {
   color:#999999;
}

/* ﾊﾗﾒｳﾓｰﾆｬﾏ�ｸﾋﾔﾍｼﾎﾄﾗﾖﾑｽ */
A.MovieTitleStyle { font-size:12px;color: #000000;font-weight:bold;text-decoration: none }
A.MovieTitleStyle:visited { font-size:12px;color: #000000;font-weight:bold;text-decoration: none }
A.MovieTitleStyle:active { font-size:12px;color: #000000;font-weight:bold;text-decoration: none }
A.MovieTitleStyle:hover { font-size:12px;color: #ff0000;font-weight:bold;text-decoration: underline}

A.MovieTitleStyle2 { font-size:12px;color: #000000; text-decoration: none }
A.MovieTitleStyle2:visited { font-size:12px;color: #000000;text-decoration: none }
A.MovieTitleStyle2:active { font-size:12px;color: #000000;text-decoration: none }
A.MovieTitleStyle2:hover { font-size:12px;color: #ff0000;text-decoration: underline}

.MovieSmallChar {
   color:#d4d4d4;font-size:11px;
}
.MovieTextStyle {
   color:#666666;line-height:160%;
}

.LeftTitle {
	font-size: 13x;
	color: #104566;
    padding-top:6px;
    padding-left:30px;
}
.LeftTitle Span {
  FILTER: DropShadow(Color=#ffffff, OffX=2, OffY=1, Positive=1); COLOR: #104566; height:1px;
}

.LeftBody {
    color: #422D0E;
	padding-left:2px;
    padding-right:3px;
    padding-top:2px;
    border-left:#CCCCCC 1px solid;
    border-right:#CCCCCC 1px solid;
    border-bottom:#CCCCCC 1px solid;
}
.LeftMoreLink { font-size:12px;color:#333333;padding-right:5px; padding-top:5px; }

A.LeftMoreLink:link { font-size:12px;color: #333333; text-decoration: none }
A.LeftMoreLink:visited { font-size:12px;color: #333333;text-decoration: none }
A.LeftMoreLink:active { font-size:12px;color: #333333;text-decoration: none }
A.LeftMoreLink:hover { font-size:12px;color: #ff0000;text-decoration: underline}


.CenterMoreLink { font-size:12px;color:#333333;padding-right:15px; }

A.CenterMoreLink:link { font-size:12px;color: #333333; text-decoration: none }
A.CenterMoreLink:visited { font-size:12px;color: #333333;text-decoration: none }
A.CenterMoreLink:active { font-size:12px;color: #333333;text-decoration: none }
A.CenterMoreLink:hover { font-size:12px;color: #ff0000;text-decoration: underline}

.RightMoreLink { font-size:12px;color:#333333;padding-right:5px; padding-top:5px;}

A.RightMoreLink:link { font-size:12px;color: #333333; text-decoration: none }
A.RightMoreLink:visited { font-size:12px;color: #333333;text-decoration: none }
A.RightMoreLink:active { font-size:12px;color: #333333;text-decoration: none }
A.RightMoreLink:hover { font-size:12px;color: #ff0000;text-decoration: underline}

</style> 
{/literal} 
 </head> 
<body  text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> 
 
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr> 
    <td height="40" background="/public/template/normal/bg03.jpg" id="webmainmenu" class="LanMu"><a class="LanMuText" href="/qiye/top/{$qiye.name}">网站首页</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057453" href="/qiye/other/{$qiye.name}/jianjie/" target="">公司简介</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057454" href="/qiye/other/{$qiye.name}/tupian/" target="">公司图片</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057455" href="/qiye/other/{$qiye.name}/dongtai/" target="">企业动态</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057456" href="/qiye/other/{$qiye.name}/chanping/" target="">产品展示</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057457" href="/qiye/other/{$qiye.name}/zhaopin/" target="">人才招聘</a> <img src='/public/template/normal/lmsplit.gif' class='LmSplit' align=absmiddle> <a class="LanMuText" id="lm9057458" href="/qiye/other/{$qiye.name}/liuyan/" target="">联系我们</a></td>  
  </tr> 
  <tr> 
    <td height="172" background="{$qiye.opt1}"><font size=6>{$qiye.title}</font></td> 
  </tr> 
</table> 
<table width="778" height="700" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr> 
    <td width="205" valign="top" bgcolor="#FFFFFF"> 
	
	
	<table width="205" border="0" cellpadding="0" cellspacing="0"> 
      <tr><td> 
       <table width="100%" border="0" cellpadding="0" cellspacing="0" background="/public/template/normal/left01.gif"> 
      <tr> 
        <td height="33"  class="LeftTitle"><span>网站公告</span></td> 
		 <td align="right" class="LeftMoreLink">更多>></td> 
      </tr></table> 
      </tr> 
      <tr> 
        <td  class="LeftBody"><table  width='100%' cellspacing=0 cellpadding=3 border=0>


{foreach name=foo from=$list item=item}
				{if $item.type eq "public"}
				<td valign=top> 	  
				  <a href=/qiye/article/{$item.id}/{$qiye.name}/>{$item.title}</a>
				  </td></tr>
				{/if}
				{/foreach}

</table> 
</td> 
      </tr> 
      <tr> 
        <td height="5"></td> 
      </tr> 
    </table> 
	
	<table width="205" border="0" cellpadding="0" cellspacing="0"> 
      <tr><td> 
       <table width="100%" border="0" cellpadding="0" cellspacing="0" background="/public/template/normal/left01.gif"> 
      <tr> 
       <td height="33"  class="LeftTitle"><span>图片广告</span></td> 
		 <td align="right" class="LeftMoreLink"></td> 
      </tr></table> 
      </tr> 
      <tr> 
        <td class="LeftBody"><table  width='100%' cellspacing=0 cellpadding=0 border=0><tr><td valign=top><table  width='100%' cellspacing=0 cellpadding=3 border=0>

{foreach name=foo from=$list item=item}
				{if $item.type eq "picad"}
				<td > 	  
				  <a href=/qiye/article/{$item.id}/{$qiye.name}/>{$item.title}</a>
				  </td></tr>
				{/if}
				{/foreach}
</table><td></tr></table></td> 
      </tr> 
      <tr> 
        <td height="5"></td> 
      </tr> 
    </table> 
	
	<table width="205" border="0" cellpadding="0" cellspacing="0"> 
      <tr><td> 
       <table width="100%" border="0" cellpadding="0" cellspacing="0" background="/public/template/normal/left01.gif"> 
      <tr> 
       <td height="33"  class="LeftTitle"><span>友情链接</span></td> 
		 <td align="right" class="LeftMoreLink">更多>></td> 
      </tr></table> 
      </tr> 
      <tr> 
        <td  class="LeftBody"><table  width='100%' cellspacing=0 cellpadding=0 border=0><tr><td align="center" valign=""><table  width='100%' cellspacing=0 cellpadding=3 border=0>


{foreach name=foo from=$list item=item}
				{if $item.type eq "link"}
				<td valign=top> 	  
				  <a href=/qiye/article/{$item.id}/{$qiye.name}/>{$item.title}</a>
				  </td></tr>
				{/if}
				{/foreach}

</table></td></tr></table></td> 
      </tr> 
      <tr> 
        <td height="5"></td> 
      </tr> 
    </table> 
	</td> 
    <td align="center" valign="top" bgcolor="#FFFFFF"> 
	<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1"> 
		   <!--TheDangStr_Start--> 
           <tr><td height="24" valign="middle" class='WebPosText'>当前位置：<a href="/qiye/top/{$qiye.name}" class="WebPosLink">首页</a> > {$article.title}</td></tr> 
		   <!--TheDangStr_End--> 
           <tr><td align="center" valign="middle"><table width='98%' height='97%' border=0 cellspacing=1 cellpadding=6 style='line-height:170%;'><td valign=top></td></tr></table><table width='98%' border=0 cellspacing=0 cellpadding=0 height=2>
<tr><td> {$article.content} </td></tr></table></td></tr> 
      </table> 
	  </td> 
  </tr> 
</table> 
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr> 
    <td height="10"><img src="/public/template/normal/img02.gif"></td> 
  </tr> 
  <tr> 
    <td height="110" align="center" valign="top"><table border=0 width='90%' align=center cellspacing=0 cellpadding=0><tr><td height=6></td></tr><tr><td align=center><table border=0 align=center cellspacing=1 cellpadding=0 bgcolor='#3a5846' style="color:#2c5858;font-family:宋体;font-size:12;font-weight:bold"><tr><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>0</td><td align=center width=13 bgcolor='#88cca4'>1</td></tr></table></td></tr></table><table width=100% align=center border=0 cellspacing=0 cellpadding=0><tr><td height=3></td></tr><tr><td align=center width='100%' class="webpb" style='line-height:180%;'><span align=center>版权所有(c) 2007-2010 {$qiye.title}<br>地址：{$qiye.addr}<br>{$qiye.contact}</span><br>本站由MIM提供技术支持<br></td></tr><tr><td height=3></td></tr></table></td> 
  </tr> 
</table> 
 
</body> 
</html> 