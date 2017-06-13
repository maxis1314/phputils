{include file="_share/_head.tpl"}

{literal}
<object width="{/literal}{$width}{literal}" height="{/literal}{$height}{literal}" id="videoPlayer" name="videoPlayer" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" >
<param name="movie" value="/data/flex/FXVideo_Example.swf" /> 
<param name="quality" value="high" /> 
<param name="bgcolor" value="#000000" /> 
<param name="allowfullscreen" value="true" /> 
<param name="flashvars" value="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&var1={/literal}{$videoUrl}{literal}&streamType=vod&autoStart=false&DS_Status=true" /> 

<embed src="/data/flex/FXVideo_Example.swf" width="{/literal}{$width}{literal}" height="{/literal}{$height}{literal}" id="videoPlayer" quality="high" bgcolor="#000000" name="videoPlayer" allowfullscreen="true" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&var1={/literal}{$videoUrl}{literal}&streamType=vod&autoStart=false&DS_Status=true" type="application/x-shockwave-flash" > </embed>
</object>


{/literal}


{include file="_share/_foot.tpl"}