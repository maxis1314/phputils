<?php /* Smarty version 2.6.18, created on 2009-10-16 17:47:15
         compiled from /home/likethewind/wx/app/view/pj/detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/likethewind/wx/app/view/pj/detail.tpl', 4, false),)), $this); ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script src="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/public/js/jquery.cookie.js" type="text/javascript"></script>
<h2>Project <?php echo ((is_array($_tmp=$this->_tpl_vars['get']['project'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
<iframe width=1000 height=300 src=/pj/gantt?project=<?php echo ((is_array($_tmp=$this->_tpl_vars['get']['project'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
></iframe><br>

<?php if ($this->_tpl_vars['get']['member']): ?>
<a href=/pj/detail?project=<?php echo ((is_array($_tmp=$this->_tpl_vars['get']['project'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
>Hide Members' Gantt</a><br>
<?php else: ?>
<a href=/pj/detail?project=<?php echo ((is_array($_tmp=$this->_tpl_vars['get']['project'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&member=1>Show Members' Gantt</a><br>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<iframe width=1000 height=250 SCROLLING=yes src=/pj/gantt?member=<?php echo $this->_tpl_vars['item']; ?>
 title="<?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
's info"></iframe><br>
<?php endforeach; endif; unset($_from); ?>


<table border=1>
<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr>
<td><a href=# onclick="redirect_back('/filecms/pjtask/edit/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/')"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['stage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date_start'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
~<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date_end'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
(<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['percent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
%)</td>
<td><a href=/pj/member?member=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['member'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['member'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>