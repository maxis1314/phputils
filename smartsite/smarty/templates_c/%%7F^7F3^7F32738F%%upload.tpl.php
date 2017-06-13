<?php /* Smarty version 2.6.18, created on 2009-02-23 01:17:21
         compiled from /home/.escort/likethewind/wx/app/view/scaffold/upload.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/scaffold/upload.tpl', 5, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


 <?php $_from = $this->_tpl_vars['resultsave']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br>
 <?php endforeach; endif; unset($_from); ?>

<form name="form1" id="form1" enctype="multipart/form-data" method="post">
        <input type="file" name="userfile" />
        <input type="submit" name="upload" />
</form>


<br>
<a href=/<?php echo $this->_tpl_vars['v']['control']; ?>
/>List</a>
<br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>