<?php /* Smarty version 2.6.18, created on 2010-06-15 23:27:39
         compiled from /home/likethewind/wx/app/view/qiye/index.tpl */ ?>
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
	  
	  <td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
	  <td><a href=/qiye/detail/<?php echo $this->_tpl_vars['item']['name']; ?>
/>详细</a></td>
	  <td><a target=_blank href=/qiye/top/<?php echo $this->_tpl_vars['item']['name']; ?>
/>查看动态网页</a></td>
	  <td>添加
	  	<select onchange="window.open(this.options[this.selectedIndex].value)"> 
	  	<option value="/qiyedb/">一览</option>   
	  	<option value="/qiyedb/add/?name=<?php echo $this->_tpl_vars['item']['name']; ?>
&type=news">新闻</option>     
	  	<option value="/qiyedb/add/?name=<?php echo $this->_tpl_vars['item']['name']; ?>
&type=public">公告 </option>
	  	<option value="/qiyedb/add/?name=<?php echo $this->_tpl_vars['item']['name']; ?>
&type=pic">图片 </option> 
	  	<option value="/qiyedb/add/?name=<?php echo $this->_tpl_vars['item']['name']; ?>
&type=link">链接 </option>  
	  	</select>
	  </td>
	  <td><a target=_blank href=/qiye/savetohtml/<?php echo $this->_tpl_vars['item']['name']; ?>
/>同步</a></td>
	  
	  </tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
<?php endif; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>