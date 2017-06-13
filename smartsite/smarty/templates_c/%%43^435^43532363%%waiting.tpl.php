<?php /* Smarty version 2.6.18, created on 2009-02-18 23:51:59
         compiled from /home/.escort/likethewind/wx/app/view/quick/waiting.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/quick/waiting.tpl', 18, false),array('modifier', 'substr', '/home/.escort/likethewind/wx/app/view/quick/waiting.tpl', 19, false),array('modifier', 'wikinoshow', '/home/.escort/likethewind/wx/app/view/quick/waiting.tpl', 19, false),array('modifier', 'nl2br', '/home/.escort/likethewind/wx/app/view/quick/waiting.tpl', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
	<script type="text/javascript">
		$(function(){
			// Accordion
			$("#accordion").accordion({ header: "h3" });
		});
	</script>

'; ?>
	
	
<!-- Accordion -->
	

<div id="accordion">
	<?php $_from = $this->_tpl_vars['blog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
	<div>
		<h3><a href="#"><?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></h3>
		<div><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['content'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 120) : substr($_tmp, 0, 120)))) ? $this->_run_mod_handler('wikinoshow', true, $_tmp) : smarty_modifier_wikinoshow($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
	


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>