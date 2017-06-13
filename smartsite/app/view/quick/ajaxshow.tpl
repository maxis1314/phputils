<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="{$v.prefix}/public/js/jquery.js" type="text/javascript"></script>
</head>
{literal}
	<script type="text/javascript">
		
		$(function(){
			
			$.ajax({
		    url: '/quick/blogshow/{/literal}{$id}{literal}.xml',
		    type: 'GET',
		    dataType: 'xml',
		    timeout: 1000,
		    error: function(){
		        alert("please try again");
		    },
		    success: function(xml){
		    	$("#accordion").html("");
		        $(xml).find("entity").each(function(){		           	
		        	var id = $(this).find("id").text();
		            var title = $(this).find("title").text();
		            var content = $(this).find("content").text();					
		            $("#accordion").html($("#accordion").html()+"<div><h3><a href=/quick/ajaxshow/"+id+">"+title+"</a></h3><div>"+content+"</div></div>");
		        });
		        
		       
		    }
		    
		    });
		});
	</script>

{/literal}	
	
<body>
<div id="accordion">
<img src=/public/image/ajax-loading.gif>
</div>

</body>
</html>

