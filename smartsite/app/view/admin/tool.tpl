<html>
<head>
 <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
 </head>
 <body>
 <form method=get>
 <input type=text name=word value="{$get.word|escape}">
 <input type=submit>
 </form>
 
 <table border=1>
 <tr><td>url encode</td><td>{$urlencode|escape}<a href="/self/temp/webspider?url={$urlencode}&start=&end=">Access</td></tr>
 <tr><td>url decode</td><td>{$urldecode|escape}</td></tr>
 <tr><td>md5</td><td>{$md5|escape}</td></tr>
 <tr><td>html</td><td>{$escape|escape}</td></tr>
 
 </table>