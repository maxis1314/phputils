<?php /* Smarty version 2.6.18, created on 2009-11-27 12:19:45
         compiled from /home/likethewind/wx/app/view/code/xml2form.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h2>Turn XML to input form with all check function automatically</h2>
<textarea rows=50 cols=80>
<?php echo $this->_tpl_vars['str']; ?>

</textarea>
<br>Results in Japanese:<br>
<iframe width=600 height=1100 
scrolling="no" border="0" frameborder="0"
src="/in/x2f/contact/jp"></iframe> 
<br>Results in English:<br>
<iframe width=600 height=1100 
scrolling="no" border="0" frameborder="0"
src="/in/x2f/contact"></iframe>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>