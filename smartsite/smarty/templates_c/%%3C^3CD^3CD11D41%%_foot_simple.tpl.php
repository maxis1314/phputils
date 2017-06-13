<?php /* Smarty version 2.6.18, created on 2009-07-09 00:26:07
         compiled from _share/_foot_simple.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', '_share/_foot_simple.tpl', 3, false),array('modifier', 'escape', '_share/_foot_simple.tpl', 3, false),)), $this); ?>
<hr>
<?php $_from = $this->_tpl_vars['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['custid']):
?>
<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['cmspath']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['custid'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['custid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>&nbsp;/&nbsp;
<?php endforeach; endif; unset($_from); ?>

	</div><!-- end content -->
		</div><!-- end inner -->
	</div><!-- end outer -->
 	<div id="footer"><h1>copyrights&copy;HPX</h1></div>
</div><!-- end container -->
</body></html>