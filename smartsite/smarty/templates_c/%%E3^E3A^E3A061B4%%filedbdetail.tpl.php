<?php /* Smarty version 2.6.18, created on 2009-02-23 18:31:55
         compiled from /home/.escort/likethewind/wx/app/view/quick/filedbdetail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/quick/filedbdetail.tpl', 16, false),array('modifier', 'nl2br', '/home/.escort/likethewind/wx/app/view/quick/filedbdetail.tpl', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
		#bounce { padding: 0.4em; }
		#bounce h3 { margin: 0; padding: 0.4em; text-align: center; }
	</style>


'; ?>


<br>
<div id="blogdiv">


	<div id="bounce" class="ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all"><?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
	<p>
	
	<?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['content'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<br>		
	<br><br><br>

	
	</p>
	</div>

</div>

<br>
<a href="/quick/filedb/">more ..</a>
<br><br><br>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    