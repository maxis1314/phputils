<?php /* Smarty version 2.6.18, created on 2017-06-13 18:51:46
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/scaffold/show.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/scaffold/show.tpl', 7, false),array('modifier', 'replace', 'F:\\git\\phputils\\smartsite/app/view/scaffold/show.tpl', 16, false),array('modifier', 'nl2br', 'F:\\git\\phputils\\smartsite/app/view/scaffold/show.tpl', 16, false),array('modifier', 'urlencode', 'F:\\git\\phputils\\smartsite/app/view/scaffold/show.tpl', 18, false),array('function', 'cycle', 'F:\\git\\phputils\\smartsite/app/view/scaffold/show.tpl', 11, false),)), $this); ?>
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
>&lt;&lt;</a><?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 Show<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/show/<?php echo $this->_tpl_vars['after']; ?>
>&gt;&gt;</a></h2>

<table> 
<?php $_from = $this->_tpl_vars['table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['col']):
        $this->_foreach['foo']['iteration']++;
?>
<?php echo smarty_function_cycle(array('values' => "#ffffff, #f0f0f0",'assign' => 'tr_color'), $this);?>

<?php if ($this->_tpl_vars['col']['name'] != 'id'): ?>
<tr><td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=$this->_tpl_vars['col']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
<?php $this->assign('value', ($this->_tpl_vars['col']['name'])); ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '&nbsp;') : smarty_modifier_replace($_tmp, ' ', '&nbsp;')))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

<?php if ($this->_tpl_vars['value'] == 'url'): ?>
	&nbsp;<a target=_blank href="/self/error/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
">-&gt;</a>
<?php endif; ?>
</p></td>
</tr>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

</table>

<br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/edit/<?php echo $this->_tpl_vars['data']['id']; ?>
/>Edit</a><br>
<a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/edit/<?php echo $this->_tpl_vars['data']['id']; ?>
/?bigtextarea=1>Edit in Big textarea</a><br>
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