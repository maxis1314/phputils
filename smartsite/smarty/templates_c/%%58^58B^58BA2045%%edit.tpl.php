<?php /* Smarty version 2.6.18, created on 2017-06-13 18:51:39
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/scaffold/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/scaffold/edit.tpl', 7, false),array('function', 'cycle', 'F:\\git\\phputils\\smartsite/app/view/scaffold/edit.tpl', 12, false),)), $this); ?>
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

<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 Edit</h2>

<form method=POST>
<table>
<?php $_from = $this->_tpl_vars['table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['col']):
        $this->_foreach['foo']['iteration']++;
?>
<?php echo smarty_function_cycle(array('values' => "#ffffff, #f0f0f0",'assign' => 'tr_color'), $this);?>

<?php if ($this->_tpl_vars['col']['name'] == 'id'): ?>
<input type=hidden name="data[id]" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
<?php elseif ($this->_tpl_vars['col']['name'] == 'ip' || $this->_tpl_vars['col']['name'] == 'created' || $this->_tpl_vars['col']['name'] == 'modified'): ?>
<?php else: ?>
	<tr><td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=$this->_tpl_vars['col']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
	<?php $this->assign('value', ($this->_tpl_vars['col']['name'])); ?>
	<?php if ($this->_tpl_vars['col']['type'] == 'text' || $this->_tpl_vars['col']['type'] == 'blob' || $this->_tpl_vars['col']['type'] == 'longtext'): ?>
		<textarea name="data[<?php echo $this->_tpl_vars['value']; ?>
]" cols="<?php if ($this->_tpl_vars['get']['bigtextarea']): ?>100<?php else: ?>50<?php endif; ?>" rows="<?php if ($this->_tpl_vars['get']['bigtextarea']): ?>30<?php else: ?>4<?php endif; ?>" ><?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea><a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/edit/<?php echo $this->_tpl_vars['data']['id']; ?>
/?bigtextarea=1>Big</a>		
	<?php else: ?>
		<input type=text name="data[<?php echo $this->_tpl_vars['value']; ?>
]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size=50>		
	<?php endif; ?>
	<font color=red><?php echo ((is_array($_tmp=$this->_tpl_vars['error_field'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</font>
	</td></tr>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>
<br>
<input type="submit" value="Save" />
</form>

</div>
<br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/show/<?php echo $this->_tpl_vars['data']['id']; ?>
/>Show</a><br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/add/>Add</a><br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/add/<?php echo $this->_tpl_vars['data']['id']; ?>
/>Copy Add</a><br>
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