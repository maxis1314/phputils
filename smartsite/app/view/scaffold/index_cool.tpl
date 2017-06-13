{literal}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Switch Display Optionswith CSS &amp; jQuery - by Soh Tanaka</title>
<script type="text/javascript" src="/public/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 
	$("a.switch_thumb").toggle(function(){
	  $(this).addClass("swap"); 
	  $("ul.display").fadeOut("fast", function() {
	  	$(this).fadeIn("fast").addClass("thumb_view"); 
		 });
	  }, function () {
      $(this).removeClass("swap");
	  $("ul.display").fadeOut("fast", function() {
	  	$(this).fadeIn("fast").removeClass("thumb_view");
		});
	}); 

});
</script>

<style type="text/css">
body {
	margin: 0;
	padding: 50px 0 0;
	font: 10px normal Verdana, Arial, Helvetica, sans-serif;
	background: #111 url(/public/data/any/body_bg.jpg) no-repeat center top;
	color: #fff;
}
* {
	margin: 0;
	padding: 0;
}

img {
	border: none;
}
h1 {
	font: 5em normal Georgia, 'Times New Roman', Times, serif;
	text-align:center;
	margin-bottom: 20px;
}
h1 span { 	color: #e7ff61; }
h1 small{
	font: 0.2em normal Verdana, Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	letter-spacing: 1.5em;
	display: block;
	color: #ccc;
}

.container {
	width: 758px;
	margin: 0 auto;
	padding-bottom: 100px;
	overflow: hidden;
}
ul.display {
	float: left;
	width: 756px;
	margin: 0;
	padding: 0;
	list-style: none;
	border-top: 1px solid #333;
	border-right: 1px solid #333;
	background: #222;
}
ul.display li {
	float: left;
	width: 754px;
	padding: 10px 0;
	margin: 0;
	border-top: 1px solid #111;
	border-right: 1px solid #111;
	border-bottom: 1px solid #333;
	border-left: 1px solid #333;
}
ul.display li a {
	color: #e7ff61;
	text-decoration: none;
}
ul.display li .content_block {
	padding: 0 10px;
}
ul.display li .content_block h2 {
	margin: 0;
	padding: 5px;
	font-weight: normal;
	font-size: 1.7em;

}
ul.display li .content_block p {
	margin: 0;
	padding: 5px 5px 5px 245px;
	font-size: 1.2em;
}
ul.display li .content_block a img{
	padding: 5px;
	border: 2px solid #ccc;
	background: #fff;
	margin: 0 15px 0 0;
	float: left;
}

ul.thumb_view li{
	width: 250px;
}
ul.thumb_view li h2 {
	display: inline;
}
ul.thumb_view li p{
	display: none;
}
ul.thumb_view li .content_block a img {
	margin: 0 0 10px;
}


a.switch_thumb {
	width: 122px;
	height: 26px;
	line-height: 26px;
	padding: 0;
	margin: 10px 0;
	display: block;
	background: url(/public/data/any/switch.gif) no-repeat;
	outline: none;
	text-indent: -9999px;
}
a:hover.switch_thumb {
	filter:alpha(opacity=75);
	opacity:.75;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
}
a.swap { background-position: left bottom; }
.page{padding:2px;font-weight:bolder;font-size:12px;}
.page a{border:1px solid #ccc;padding:0 5px 0 5px;margin:2px;text-decoration:none;color:#333;}
.page span{padding:0 5px 0 5px;margin:2px;background:#09f;color:#fff;border:1px solid #09c;}


</style>
</head>

<body>

<h1>Switch <span>Display Options</span><small>with CSS &amp; jQuery</small></h1>

<script type="text/javascript">
function CheckedAll()
{
	if($("input:checkbox[name='selectids[]']:eq(0)").attr('checked')){
		$("input:checkbox[name='selectids[]']").attr('checked', false);
	}else{
		$("input:checkbox[name='selectids[]']").attr('checked', true);
	}
}
function deleteRow(sRowId,dataid)
{
  jqRow = $("li#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           $.get('/{/literal}{$v.control|escape}{literal}/delete/'+dataid);
           jqRow.remove();
           //window.alert("Record delete");
        });

   }
}


</script>	
{/literal}
<div class="container">

<a href="#" class="switch_thumb">Switch Thumb</a> 

<form method=POST action='/{$v.control}/search'><input type=text name=key size=30 value="{$post.key|escape}"><input type=submit value="検索"></form>
<form id="myform" method=POST action='/{$v.control}/deletemulti'>
<ul class="display">
	{foreach name=foo from=$list item=item}
    <li id=row-{$smarty.foreach.foo.iteration}>
      <div class="content_block">   
       <input type=checkbox name="selectids[]" value="{$item.id|escape}">       
       <br>
       {foreach from=$table item=col}
       {assign var='value' value=`$col.name`}
       {if $value!="created" && $value!="modified"}
       		{if $post.key}
	       		{$value}:{$item.$value|substr2:0:6000|escape|nl2br|hilight:$post.key}
	       	{else}
	       		{$value}:{$item.$value|substr2:0:54|escape|nl2br}
	       	{/if}
	       	<br>
	   {/if}
       {/foreach}
      
       [<a href="{$v.prefix}/{$v.control}/show/{$item.id}">詳細</a>,<a href="{$v.prefix}/{$v.control}/edit/{$item.id}">編集</a>,
       <a href='javascript:deleteRow("row-{$smarty.foreach.foo.iteration}","{$item.id|escape}");'>削除</a>]	  
   	</div>
   </li>
   {/foreach}
</ul>


<input type=button onClick='CheckedAll();' value="全部選択"><input type=submit value="選択したものを削除">
</form>
{$foot|replace:'<br>':''}
<br><a href="{$v.prefix}/{$v.control}/add">追加</a>
<br><a href="{$v.prefix}/{$v.control}/Download">ダウンロード　CSV</a>


{literal}
<div style="text-align:center; padding: 20px 0; display: block;float: left;">Powered by hpx</div>
</div>

</body>
</html>



{/literal}
