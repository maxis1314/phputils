<?php /* Smarty version 2.6.18, created on 2009-09-27 20:44:02
         compiled from /home/likethewind/wx/app/view/search/cn.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/likethewind/wx/app/view/search/cn.tpl', 5, false),array('modifier', 'urlencode', '/home/likethewind/wx/app/view/search/cn.tpl', 20, false),array('modifier', 'nl2br', '/home/likethewind/wx/app/view/search/cn.tpl', 26, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2>Search Engine</h2>
<form method=GET>
<input type=text name=key id=key value="<?php echo ((is_array($_tmp=$this->_tpl_vars['keyw'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="输入关键字进行检索"><input type=submit value="検索">
<br>

<?php if (isset ( $this->_tpl_vars['result'] )): ?>
<?php if (count ( $this->_tpl_vars['result'] ) > 0): ?>
<table> 
<tr> 
  <td nowrap>&nbsp;<span id=sd>&nbsp;<b>Mim134.com</b>&nbsp;</span></td> 
  <td align=right nowrap><font size=-1><b><?php echo ((is_array($_tmp=$this->_tpl_vars['keyw'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</b> 的检索结果 <b><?php echo $this->_tpl_vars['page']*10; ?>
</b> - <b><?php echo $this->_tpl_vars['page']*10+10; ?>
</b> 件  (<b><?php echo $this->_tpl_vars['consumeTime']; ?>
</b> 秒)&nbsp;</font></td> 
</tr> 
</table> 
    	<?php $_from = $this->_tpl_vars['result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>

	       
			
		<h3><a href="/out/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['link'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
" target=_blank>
<?php echo $this->_tpl_vars['custid']['title']; ?>
</a></h3>

<table border=1 cellpadding=0 cellspacing=0 width=600>
<tr>
<td class=j>
<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['description'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

<font size=-1>&nbsp;
<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target=_blank><?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
<br>
<span class=a>

<a href="http://<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['host'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"  target=_blank><?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['host'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></span> &nbsp;-&nbsp;<nobr>人気:<span class=rank><?php echo $this->_tpl_vars['custid']['num']; ?>
</span></td>
</tr></table>

        <?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['page'] > 0): ?><a href="?key=<?php echo ((is_array($_tmp=$this->_tpl_vars['keyw'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&page=<?php echo $this->_tpl_vars['page']-1; ?>
">←</a>&nbsp;<?php endif; ?><?php echo $this->_tpl_vars['page']+1; ?>
<?php if ($this->_tpl_vars['has_next']): ?>&nbsp;<a href="?key=<?php echo ((is_array($_tmp=$this->_tpl_vars['keyw'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&page=<?php echo $this->_tpl_vars['page']+1; ?>
">→</a><?php endif; ?>
<?php else: ?>
找不到与 <b><?php echo ((is_array($_tmp=$this->_tpl_vars['keyw'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</b> 相关的网页
<?php endif; ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>