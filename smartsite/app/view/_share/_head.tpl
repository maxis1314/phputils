<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{$v.prefix}/public/data/layout1/style.css" />
<link rel="stylesheet" type="text/css" href="{$v.prefix}/public/css/mini.css" />
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
<script src="{$v.prefix}/public/js/jquery.cookie.js" type="text/javascript"></script>
<script type="text/javascript" src="{$v.prefix}/public/js/jquery.event.drag.js"></script>
<script type="text/javascript" src="{$v.prefix}/public/js/jquery.event.drop.js"></script>
<script type="text/javascript" src="{$v.prefix}/public/js/jquery-ui-personalized.js"></script>

<link type="text/css" href="{$v.prefix}/public/css/ui.all.css" rel="Stylesheet" />	
		
<link rel="stylesheet" type="text/css" href="{$v.prefix}/public/css/drag.css" /> 

<title>Demo OF DIY PHP MVC Framework</title>

{literal}
<script type="text/javascript">

$(function(){
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$(".drag")
		.bind( "dragstart", function( event ){
			// ref the "dragged" element, make a copy
			var $drag = $( this ), $proxy = $drag.clone();
			// modify the "dragged" source element
			$drag.addClass("outline");
			// insert and return the "proxy" element		
			return $proxy.appendTo( document.body ).addClass("ghost");
			})
		.bind( "drag", function( event ){
			// update the "proxy" element position
			$( event.dragProxy ).css({
				left: event.offsetX, 
				top: event.offsetY
				});
			})
		.bind( "dragend", function( event ){
			// remove the "proxy" element
			$( event.dragProxy ).fadeOut( "normal", function(){
				$( this ).remove();
				});
			// if there is no drop AND the target was previously dropped 
			if ( !event.dropTarget && $(this).parent().is(".drop") ){
				// output details of the action
				$('#log').append('<div>Removed <b>'+ this.title +'</b> from <b>'+ this.parentNode.title +'</b></div>');
				// put it in it's original <div>
				$('#nodrop').append( this );
				}
			// restore to a normal state
			$( this ).removeClass("outline");	
			
			});
	$('.drop')
		.bind( "dropstart", function( event ){
			// don't drop in itself
			if ( this == event.dragTarget.parentNode ) return false;
			// activate the "drop" target element
			$( this ).addClass("active");
			})
		.bind( "drop", function( event ){
			// if there was a drop, move some data...
			var title=event.dragTarget.title;
			if (window.confirm("are you sure to delete this?")){
				$( this ).append( event.dragTarget );
				$.get('/quick/blogdelete/'+title);
			}
			})
		.bind( "dropend", function( event ){
			// deactivate the "drop" target element
			$( this ).removeClass("active");
			});
	// Datepicker
	$('#datepicker').datepicker({
		inline: true
	});
	
	$("#leavemessage").click(function() {
		if(!$("#messagetext").val()){
			alert("Message is empty!");
			return;
		}
		$.post('/error/contact/',{msg:$("#messagetext").val()});
		$("#messagediv").fadeOut("normal").show("normal").html("<h2>Thank you!</h2>");
	});
	
	$("#navigacija li a").hover(function() {
        $(this).stop().animate( {
			fontSize:"17px",
			paddingLeft:"10px",
			color:"red"
        }, 300);
    }, function() {
        $(this).stop().animate( {
			fontSize:"12px",
			paddingLeft:"0",
			color:"#fffff"
        }, 300);
    });
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
});



</script>
{/literal}
</head>
<body>
	<div id="bg">
		<div id="sadrzaj">
			<div id="toplinks">
				<a href="/quick">Home</a>
				<a href="/code/tool">Tools</a>
				<a target=_blank href="/demo/">Auto CMS Demo</a>				
				<a href="/quick/roadmap">Road MAP</a>
				<a href="/quick/contact">Contact</a>
				{if $session.login}
				<a href="/quick/logout">Logout</a>
				{else}
				<a href="/quick/reg">Register</a>
				<a href="/quick/login">Login</a>
				{/if}
			
			</div>

			<div id="zaglavlje">
				<div id="title">
					<a href="#">Dream will come true</a>
				</div>
				<div id="title_info" class="drop">
					<p><i>Enjoy Everyday:  Black Hole Here●(Drop to Delete)</i></p>
					<p><b><a href="#">Play more,Life is short.</a></b>															
					</p>
				</div>
			</div>

			<div id="navigacija">
				<ul>					
					<li><a href="/quick/myblog">My Blog</a></li>
					<li><a href="/quick/newblog">New Blog</a></li>										
					<li><a href="/quick/picture">Pictures</a></li>					
					<li><a href="/flash/flex/sample">Streaming</a></li>
					<li><a href="/chat">Live Chat</a></li>					
					<li><a href="#">Search Engine</a></li>
					
				</ul>
	
				<!-- Datepicker -->

				<div id="datepicker"></div>
				<br>

				
				<div class="lijevo">
					<div title="recent list">
					<b>Recent</b>
					<br>
					{foreach name=foo from=$blog item=custid}				
					<a href="#" onclick='$("p#headp{$smarty.foreach.foo.iteration}").slideToggle("slow");return false;'><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" />  {$custid.title|escape}</a><br>				
					<p id="headp{$smarty.foreach.foo.iteration}" style="display:none">
					{$custid.content|wikinoshow|nl2br}<br>
					<a href="#" onclick='$("p#headp{$smarty.foreach.foo.iteration}:visible").slideUp("slow");return false;'>close</a>							
					</p>
					{/foreach}
					<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
					<br>
					{foreach name=foo from=$comment item=item}
					<a href="/quick/blogshow/{$item.content_id|urlencode}"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> {$item.comment|substr2:0:20|escape}</a><br>
					{/foreach}
					<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
					</div>
					<br>
					<div id="messagediv">
					<h2>Contact:</h2>					
					<textarea id="messagetext" rows=3 cols=11></textarea>
					<input type=button id="leavemessage" value="Send">
					</div>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> 
					</p>
				</div>
			</div>

			<div id="clanci">
	
			