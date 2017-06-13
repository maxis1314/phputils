<?php /* Smarty version 2.6.18, created on 2017-06-13 18:23:37
         compiled from F:%5Cgit%5Cphputils%5Cwx/app/view/_share/404.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substr2', 'F:\\git\\phputils\\wx/app/view/_share/404.tpl', 101, false),array('modifier', 'escape', 'F:\\git\\phputils\\wx/app/view/_share/404.tpl', 101, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Error</title>
    <?php echo '
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
    '; ?>

 </head>
<body style="text-align:center;">

<div id="content">
    <form id="form1" runat="server">
        <div class="box">
            <h3>Your request could not be completed.</h3>
            <p><font color=brown size=4><pre><?php echo $this->_tpl_vars['url'][0]; ?>
<?php echo $this->_tpl_vars['error']; ?>
</pre></font></p>
            <p><?php if ($this->_tpl_vars['error_trace']): ?>
			    <table>
			    <tr><th>File</th><th>Line</th><th>Func</th></tr>
			    <?php $_from = $this->_tpl_vars['error_trace']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
			    <tr><td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['file'])) ? $this->_run_mod_handler('substr2', true, $_tmp, 29) : smarty_modifier_substr2($_tmp, 29)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['line'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['function'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			    <tr>
			    <?php endforeach; endif; unset($_from); ?>
			    </table>
			    <?php endif; ?>
		    </p>
        </div>
    </form>
    
</div>
    
</body>
</html>