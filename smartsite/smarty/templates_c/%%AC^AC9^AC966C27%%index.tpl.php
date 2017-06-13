<?php /* Smarty version 2.6.18, created on 2017-06-13 18:30:40
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/quick/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/quick/index.tpl', 16, false),array('modifier', 'substr2', 'F:\\git\\phputils\\smartsite/app/view/quick/index.tpl', 17, false),array('modifier', 'wikinoshow', 'F:\\git\\phputils\\smartsite/app/view/quick/index.tpl', 17, false),array('modifier', 'urlencode', 'F:\\git\\phputils\\smartsite/app/view/quick/index.tpl', 19, false),array('modifier', 'replace', 'F:\\git\\phputils\\smartsite/app/view/quick/index.tpl', 25, false),)), $this); ?>
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
	
	
<a href="/quick/blog">Change View</a>
<div id="accordion">
	<?php $_from = $this->_tpl_vars['blogpage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
	<div>
		<h3><a href="#"><?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></h3>
		<div><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['content'])) ? $this->_run_mod_handler('substr2', true, $_tmp, 0, 600) : smarty_modifier_substr2($_tmp, 0, 600)))) ? $this->_run_mod_handler('wikinoshow', true, $_tmp) : smarty_modifier_wikinoshow($_tmp)); ?>

		<br>
		<a target=_blank href="/quick/blogshow/<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['id'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
">more...</a>
		</div>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>
<br>
<?php echo ((is_array($_tmp=$this->_tpl_vars['pagefoot'])) ? $this->_run_mod_handler('replace', true, $_tmp, '<br>', '') : smarty_modifier_replace($_tmp, '<br>', '')); ?>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>