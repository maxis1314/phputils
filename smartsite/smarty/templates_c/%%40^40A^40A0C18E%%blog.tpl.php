<?php /* Smarty version 2.6.18, created on 2009-07-02 20:51:16
         compiled from /home/.escort/likethewind/wx/app/view/quick/blog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 58, false),array('modifier', 'escape', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 61, false),array('modifier', 'substr2', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 67, false),array('modifier', 'wikinoshow', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 67, false),array('modifier', 'nl2br', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 67, false),array('modifier', 'replace', '/home/.escort/likethewind/wx/app/view/quick/blog.tpl', 83, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript" src="/public/js/sorttable.js"></script> 
<script type="text/javascript">
function deleteRow(sRowId,dataid)
{
  jqRow = $("tr#" + sRowId);
  if (window.confirm("are you sure?"))
  {
        jqRow.fadeOut("slow", function()
        {
           $.get(\'/quick/blogdelete/\'+dataid);
           jqRow.remove();
           //window.alert("Record delete");
        });

   }
}

function filtertable(term, _id, cellNr){
	var suche = term.value.toLowerCase();
	var table = document.getElementById(_id);
	var ele;	
	for (var r = 1; r < table.rows.length; r++){
		ele = table.rows[r].cells[cellNr].innerHTML.replace(/&lt;[^&gt;]+&gt;/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
			table.rows[r].style.display = \'\';
		else table.rows[r].style.display = \'none\';
	}
}
</script>
<style type="text/css"> 
th, td {
  padding: 3px !important;
}
 
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style> 

'; ?>



<form>
	Search:<input name="filter" onkeyup="filtertable(this, 'filtertableid', 2)" type="text">&nbsp;&nbsp;&nbsp;<a href="/quick/">Change View</a>
</form>

<table class="sortable" id="filtertableid">
<tr><th>ID</th><th>TITLE</th><th>CONTENT</th>
</tr>
<?php $_from = $this->_tpl_vars['blogpage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
<?php echo smarty_function_cycle(array('values' => "#ffffff, #f0f0f0",'assign' => 'tr_color'), $this);?>

<tr id="row-<?php echo $this->_foreach['foo']['iteration']; ?>
">
<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
</td>
<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
<a  target=_blank href="/quick/blogshow/<?php echo $this->_tpl_vars['custid']['id']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
</td>
<td style="background-color:<?php echo $this->_tpl_vars['tr_color']; ?>
;">
<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['content'])) ? $this->_run_mod_handler('substr2', true, $_tmp, 0, 120) : smarty_modifier_substr2($_tmp, 0, 120)))) ? $this->_run_mod_handler('wikinoshow', true, $_tmp) : smarty_modifier_wikinoshow($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>


<br>
<a href="#" onclick='$("p#blogp<?php echo $this->_foreach['foo']['iteration']; ?>
").slideToggle("slow");return false;'>More</a>&nbsp;
<a href='javascript:deleteRow("row-<?php echo $this->_foreach['foo']['iteration']; ?>
","<?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
");'>delete</a>
<p id="blogp<?php echo $this->_foreach['foo']['iteration']; ?>
" style="display:none">
<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['content'])) ? $this->_run_mod_handler('substr2', true, $_tmp, 120, 240) : smarty_modifier_substr2($_tmp, 120, 240)))) ? $this->_run_mod_handler('wikinoshow', true, $_tmp) : smarty_modifier_wikinoshow($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
...<br>
<a target=_blank href="/quick/blogshow/<?php echo $this->_tpl_vars['custid']['id']; ?>
/">Detail</a>
<a href="#" onclick='$("p#blogp<?php echo $this->_foreach['foo']['iteration']; ?>
:visible").slideUp("slow");return false;'>Close</a>
</p>

</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<?php echo ((is_array($_tmp=$this->_tpl_vars['pagefoot'])) ? $this->_run_mod_handler('replace', true, $_tmp, '<br>', '') : smarty_modifier_replace($_tmp, '<br>', '')); ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>