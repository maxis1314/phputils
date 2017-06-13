<?php /* Smarty version 2.6.18, created on 2017-06-13 18:58:15
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/quick/picture.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/quick/picture.tpl', 11, false),array('modifier', 'replace', 'F:\\git\\phputils\\smartsite/app/view/quick/picture.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript" src="/public/data/lightbox/prototype.js"></script>
<script type="text/javascript" src="/public/data/lightbox/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="/public/data/lightbox/lightbox.js"></script>
<link rel="stylesheet" href="/public/data/lightbox/lightbox.css" type="text/css" media="screen" />
'; ?>

<h2>Albums</h2>

<?php $_from = $this->_tpl_vars['piclist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['custid']):
        $this->_foreach['foo']['iteration']++;
?>
<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['custid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" rel="lightbox[plants]"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['custid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" alt="Plants: <?php echo $this->_foreach['foo']['iteration']; ?>
/<?php echo $this->_foreach['foo']['total']; ?>
 thumb" width="240" height="150"></a>
<?php endforeach; endif; unset($_from); ?><br>
<?php echo ((is_array($_tmp=$this->_tpl_vars['foot'])) ? $this->_run_mod_handler('replace', true, $_tmp, '<br>', '') : smarty_modifier_replace($_tmp, '<br>', '')); ?>

<br>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>