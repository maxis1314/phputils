<?php /* Smarty version 2.6.18, created on 2009-02-19 00:59:49
         compiled from /home/.escort/likethewind/wx/app/view/quick/galary.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substr', '/home/.escort/likethewind/wx/app/view/quick/galary.tpl', 24, false),array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/quick/galary.tpl', 24, false),array('modifier', 'nl2br', '/home/.escort/likethewind/wx/app/view/quick/galary.tpl', 28, false),)), $this); ?>
<?php echo '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>jQuery UI Example Page</title>
		<link type="text/css" href="/public/css/ui.all.css" rel="Stylesheet" />	
		<script type="text/javascript" src="/public/js/jquery.js"></script>
		<script type="text/javascript" src="/public/js/jquery-ui-personalized.js"></script>
		<script type="text/javascript">
			$(function(){
				// Tabs
				$(\'#tabs\').tabs();
			});
		</script>
'; ?>

	</head>
	<body>
	
		<!-- Tabs -->
		<h2 class="demoHeaders">Tabs</h2>
		<div id="tabs">
			<ul>
				<?php $_from = $this->_tpl_vars['blog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
				<li><a href="#tabs-<?php echo $this->_foreach['foo']['iteration']; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['title'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 12) : substr($_tmp, 0, 12)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>			
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<?php $_from = $this->_tpl_vars['blog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
			<div id="tabs-<?php echo $this->_foreach['foo']['iteration']; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['content'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	
	

	</body>
</html>

