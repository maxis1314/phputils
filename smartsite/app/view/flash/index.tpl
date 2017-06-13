{include file="_share/_head.tpl"}

{literal}
<object width="{/literal}{$width}{literal}" height="{/literal}{$height}{literal}" id="videoPlayer" name="videoPlayer" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" >
<param name="movie" value="/data/player/videoPlayer.swf" /> 
<param name="quality" value="high" /> 
<param name="bgcolor" value="#000000" /> 
<param name="allowfullscreen" value="true" /> 
<param name="flashvars" value="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&serverURL={/literal}{$videoUrl}{literal}&streamType=vod&autoStart=false&DS_Status=true" /> 

<embed src="/data/player/videoPlayer.swf" width="{/literal}{$width}{literal}" height="{/literal}{$height}{literal}" id="videoPlayer" quality="high" bgcolor="#000000" name="videoPlayer" allowfullscreen="true" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&serverURL={/literal}{$videoUrl}{literal}&streamType=vod&autoStart=false&DS_Status=true" type="application/x-shockwave-flash" > </embed>
</object>


{/literal}
 {foreach name=foo from=$allVideo item=col}
 <a href=/flash/index/{$col.id}>{$col.name}</a><br>
 {/foreach}
{include file="_share/_foot.tpl"}