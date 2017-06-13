<?php /* Smarty version 2.6.18, created on 2010-06-13 22:48:08
         compiled from /home/likethewind/wx/app/view/qiye/detail.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if (! empty ( $this->_tpl_vars['list'] )): ?>
	<table border=1>
	<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
	  <tr>
	  
	  <td><?php echo $this->_tpl_vars['item']['type']; ?>
</td>
	  <td><?php echo $this->_tpl_vars['item']['content']; ?>
</td>
	  <td><?php echo $this->_tpl_vars['item']['ut']; ?>
</td>
	  <td><?php echo $this->_tpl_vars['item']['ct']; ?>
</td>
	  <td><a target=_blank href=/qiyedb/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
>编辑</td>
	  </tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>