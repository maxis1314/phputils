<?php /* Smarty version 2.6.18, created on 2017-06-13 18:50:41
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/scaffold/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 24, false),array('modifier', 'urlencode', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 45, false),array('modifier', 'substr2', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 62, false),array('modifier', 'nl2br', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 62, false),array('modifier', 'hilight', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 62, false),array('modifier', 'replace', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 82, false),array('function', 'cycle', 'F:\\git\\phputils\\smartsite/app/view/scaffold/index.tpl', 52, false),)), $this); ?>
<?php if ($this->_tpl_vars['simple']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php echo '
<script type="text/javascript">
function CheckedAll()
{
	if($("input:checkbox[name=\'selectids[]\']:eq(0)").attr(\'checked\')){
		$("input:checkbox[name=\'selectids[]\']").attr(\'checked\', false);
	}else{
		$("input:checkbox[name=\'selectids[]\']").attr(\'checked\', true);
	}
}
function deleteRow(sRowId,dataid)
{
  jqRow = $("tr#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           $.get(\''; ?>
<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['control'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo '/delete/\'+dataid);
           jqRow.remove();
           //window.alert("Record delete");
        });

   }
}


</script>	
'; ?>

<h2>Scaffold　デモ&nbsp;<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/code" target=_blank>Code</a></h2>


<form method=POST action='<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/search'><input type=text name=key size=30 value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post']['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><input type=submit value="検索"><a href=<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/form>Advanced Search</a></form>
<form id="myform" method=POST action='<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/deletemulti'>
<table>
   <tr>
   	  <th></th>
   	   <?php $_from = $this->_tpl_vars['table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['col']):
        $this->_foreach['foo']['iteration']++;
?>
   	   <?php if ($this->_tpl_vars['col']['name'] != 'created' && $this->_tpl_vars['col']['name'] != 'modified'): ?>
       <th><a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/?order=<?php echo ((is_array($_tmp=$this->_tpl_vars['col']['name'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['col']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></th>
       <?php endif; ?>
	   <?php endforeach; endif; unset($_from); ?>
	   <th>Operate</th>
   </tr>
     <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
      <tr id=row-<?php echo $this->_foreach['foo']['iteration']; ?>
>
       <?php echo smarty_function_cycle(array('values' => "#f0f0f0,#ffffff",'assign' => 'tr_color'), $this);?>

       
       <td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
       <input type=checkbox name="selectids[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
       </td>
       
       <?php $_from = $this->_tpl_vars['table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['col']):
?>
       <?php $this->assign('value', ($this->_tpl_vars['col']['name'])); ?>
       <?php if ($this->_tpl_vars['value'] != 'created' && $this->_tpl_vars['value'] != 'modified'): ?>
       		<?php if ($this->_tpl_vars['post']['key']): ?>
	       		<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('substr2', true, $_tmp, 0, 6000) : smarty_modifier_substr2($_tmp, 0, 6000)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)))) ? $this->_run_mod_handler('hilight', true, $_tmp, $this->_tpl_vars['post']['key']) : smarty_modifier_hilight($_tmp, $this->_tpl_vars['post']['key'])); ?>

	       	<?php else: ?>
	       		<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('substr2', true, $_tmp, 0, 600) : smarty_modifier_substr2($_tmp, 0, 600)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

	       	<?php endif; ?>
	       	<?php if ($this->_tpl_vars['value'] == 'url'): ?>
	       		&nbsp;<a target=_blank href="/error/rd?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][$this->_tpl_vars['value']])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
">-&gt;</a>
	       	<?php endif; ?>
	       	</td>
	   <?php endif; ?>
       <?php endforeach; endif; unset($_from); ?>
       <td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
       [<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/show/<?php echo $this->_tpl_vars['item']['id']; ?>
/">詳細</a>,<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/showdetail/<?php echo $this->_tpl_vars['item']['id']; ?>
/">関連情報</a>,<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/edit/<?php echo $this->_tpl_vars['item']['id']; ?>
/">編集</a>,<a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/add/<?php echo $this->_tpl_vars['item']['id']; ?>
/">コピー追加</a>,
       <a href='javascript:deleteRow("row-<?php echo $this->_foreach['foo']['iteration']; ?>
","<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
");'>削除</a>]
	   </td>
      </tr>
   <?php endforeach; endif; unset($_from); ?>
   
   </table>
<input type=button onClick='CheckedAll();' value="全部選択"><input type=submit value="選択したものを削除">
</form>
<?php echo ((is_array($_tmp=$this->_tpl_vars['foot'])) ? $this->_run_mod_handler('replace', true, $_tmp, '<br>', '') : smarty_modifier_replace($_tmp, '<br>', '')); ?>

<br><a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/add">追加</a>
<br><a href="<?php echo $this->_tpl_vars['v']['prefix']; ?>
/<?php echo $this->_tpl_vars['v']['control']; ?>
/Download">ダウンロード　CSV</a>


<?php if ($this->_tpl_vars['simple']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot_simple.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>