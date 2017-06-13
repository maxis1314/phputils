<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
 <meta http-equiv="content-style-type" content="text/css" />

<script src="/addition/jquery.js" type="text/javascript"></script>
</head>

<body>
<h2>Upload file</h2>

{if $result == 1 || $get.sync}
upload sucessfully! Seed: {$download|escape}<br>
you can download <a href=/uploadfile/{$download|escape}>here</a>

{literal}
<script language="javascript">
$(document).ready(function() {
  save();
});

function save(){
	var param={		
		cmd: 'edit',
		page: '{/literal}{$get.where|escape}{literal}',		
    	msg: '{/literal}*http://localhost:5558/self/admin/upload?where=FILE/UPLOAD&sync=1\n\n{foreach name=foo from=$list item=item}|{$item|escape}|[[http://{$env.HTTP_HOST}/self/admin/download/?d={$item|escape}]]|[[http://{$env.HTTP_HOST}/uploadfile/{$item|escape}]]|\n{/foreach}{literal}',
    	write: "ページの更新",
    	notimestamp: 1,
    	encode_hint: "ふ",
    };
	$.post("/index.php",param);
}
</script>
{/literal}

{/if}
{if $result == 2}
upload failed please check your file!<br>
{/if}

<form name="form1" id="form1" enctype="multipart/form-data" method="post">
        <input type="file" name="userfile" />
        <input type="submit" name="upload" />
</form>


{foreach name=foo from=$list item=item}
[[http://{$env.HTTP_HOST}/self/admin/download/?d={$item|escape}]]<br><br>
{/foreach}



</body>
</html>