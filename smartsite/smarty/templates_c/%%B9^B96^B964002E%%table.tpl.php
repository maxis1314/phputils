<?php /* Smarty version 2.6.18, created on 2009-02-17 19:08:53
         compiled from /home/.escort/likethewind/wx/app/view/quick/table.tpl */ ?>
  <html>
  <head>
  <?php echo '
    <script type="text/javascript" src="/public/js/jquery.js"></script>
    <script type="text/javascript">
      // Your code goes here
	$(document).ready(function() {
	    $("li").not(":has(ul)")).css("background", "#eee" );
	   );


 });

	 
	 
	 
	 
	 
	 
	/*$.get(\'/\', function(){
			
  			myCallBack();
		});

	});*/	 
	function myCallBack(){
		alert();
	}	 
    </script>    
    <style type="text/css">
    .red { background: #0000FF }
    .blue { background: #00FF00 }
 	</style>
    
    '; ?>

  </head>
  <body>
    <ul id=orderedlist>
    	<li>a</li>
    	<li>b</li>
    	<li>c</li>
    </ul>
    <?php echo '
    
    <a href=# onclick="alert($("div#aaa p.s1").size());">size</a>
    <a href=# onclick=""></a>
    <a href=# onclick=""></a>
    <a href=# onclick=""></a>
    <a href=# onclick=""></a>
    <a href=# onclick=""></a>
    
    '; ?>

    <div id=aaa>
    	<p class="s1">fsdafsdafsd
    	</p>
    	<p class="s3">sdafsdfasdf
    	</p>
    	<p class="s3">fsdafasdf
    	</p>
    </div>
    
  </body>
  </html>