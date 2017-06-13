<?php /* Smarty version 2.6.18, created on 2009-08-12 20:24:24
         compiled from /home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'bigcase', '/home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl', 7, false),array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl', 7, false),array('modifier', 'urlencode', '/home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl', 16, false),array('modifier', 'replace', '/home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl', 26, false),array('function', 'cycle', '/home/.escort/likethewind/wx/app/view/scaffold/showdetail.tpl', 12, false),)), $this); ?>
<?php if ($this->_tpl_vars['simple']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<h2><a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/show/<?php echo $this->_tpl_vars['before']; ?>
>&lt;&lt;</a><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 Show<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/show/<?php echo $this->_tpl_vars['after']; ?>
>&gt;&gt;</a></h2>

<table> 
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
<?php if (is_scalar ( $this->_tpl_vars['value'] )): ?>
<?php echo smarty_function_cycle(array('values' => "#ffffff, #f0f0f0",'assign' => 'tr_color'), $this);?>

<tr><td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

<?php if ($this->_tpl_vars['key'] == 'url'): ?>
	&nbsp;<a target=_blank href="/self/error/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['v'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
">-&gt;</a>
<?php endif; ?>
</td>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>
<br>

<?php $_from = $this->_tpl_vars['manyothers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tablename']):
?>
<br><br>
<h2><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tablename'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'many_', "") : smarty_modifier_replace($_tmp, 'many_', "")))) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
</h2><hr>
    <table border=1>
    <?php if (count ( $this->_tpl_vars['data'][$this->_tpl_vars['tablename']] ) > 0): ?>
    	<tr>
    	<?php $_from = $this->_tpl_vars['data'][$this->_tpl_vars['tablename']][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
	 	  <th><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
		<?php endforeach; endif; unset($_from); ?>
		</tr>
		<?php $_from = $this->_tpl_vars['data'][$this->_tpl_vars['tablename']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<?php echo smarty_function_cycle(array('values' => "#ffffff, #f0f0f0",'assign' => 'tr_color'), $this);?>

		<tr><?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['value2']):
?>		  
	 	  <td  style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=$this->_tpl_vars['value2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php if ($this->_tpl_vars['key2'] == 'id'): ?> <a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['cmspath']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['tablename'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'many_', "") : smarty_modifier_replace($_tmp, 'many_', "")); ?>
/showdetail/<?php echo ((is_array($_tmp=$this->_tpl_vars['value2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">[Detail]<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['cmspath']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['tablename'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'many_', "") : smarty_modifier_replace($_tmp, 'many_', "")); ?>
/add/">[Add]</a><?php endif; ?></td>
		<?php endforeach; endif; unset($_from); ?></tr>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>	
	<table>
<?php endforeach; endif; unset($_from); ?>

<br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/edit/<?php echo $this->_tpl_vars['data']['id']; ?>
>Edit</a><br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/>List</a>

<?php if ($this->_tpl_vars['simple']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

