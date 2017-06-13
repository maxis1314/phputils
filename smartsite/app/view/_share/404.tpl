<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Error</title>
    {literal}
    <style type="text/css">
    body 
    {
        font-family: verdana, arial, helvetica, sans-serif;
        background-color: #aaa;
        text-align: center;
    }
    	
    .box 
    {
        margin: auto;
        margin-top: 150px;
        padding: 25px 20px 20px 125px;
        font-size: 12px;
        line-height: 1.5em;
        color: #333;
        background: url(/public/attention_mark.gif) #fff no-repeat 22px 43px;
        border: solid 1px #777;
        width: 450px;
        text-align: left;
    }
    .box h3 
    {
        margin: -25px -20px 20px -125px;
	    line-height: 28px;
	    padding-left: 12px;
	    font-size: 14px;
	    font-weight: bold;
	    color: #fff;
	    background-color: #777;
    }

    label
    {
        vertical-align: 2px;
    }
    /* Tables */
	table {
		background: #fff;
		border:1px solid #ccc;
		border-right:0;
		clear: both;
		color: #333;
		margin-bottom: 10px;
		width: 100%;
	}
	th {
		background: #f2f2f2;
		border:1px solid #bbb;
		border-top: 1px solid #fff;
		border-left: 1px solid #fff;
		text-align: center;
	}
	th a {
		background:#f2f2f2;
		display: block;
		padding: 2px 4px;
		text-decoration: none;
	}
	th a:hover {
		background: #ccc;
		color: #333;
		text-decoration: none;
	}
	table tr td {
		background: #fff;
		border-right: 1px solid #ccc;
		padding: 4px;
		text-align: left;
		vertical-align: top;
	}
	table tr.altrow td {
		background: #f4f4f4;
	}
	td.actions {
		text-align: center;
		white-space: nowrap;
	}
	td.actions a {
		margin: 0px 6px;
	}
    </style>
    {/literal}
 </head>
<body style="text-align:center;">

<div id="content">
    <form id="form1" runat="server">
        <div class="box">
            <h3>Your request could not be completed.</h3>
            <p><font color=brown size=4><pre>{$url[0]}{$error}</pre></font></p>
            <p>{if $error_trace}
			    <table>
			    <tr><th>File</th><th>Line</th><th>Func</th></tr>
			    {foreach name=foo from=$error_trace item=item}
			    <tr><td>{$item.file|substr2:29|escape}</td>
			    <td>{$item.line|escape}</td>
			    <td>{$item.function|escape}</td>
			    <tr>
			    {/foreach}
			    </table>
			    {/if}
		    </p>
        </div>
    </form>
    
</div>
    
</body>
</html>