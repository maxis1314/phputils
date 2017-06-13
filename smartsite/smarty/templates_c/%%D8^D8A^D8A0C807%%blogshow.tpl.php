<?php /* Smarty version 2.6.18, created on 2009-11-27 14:45:31
         compiled from /home/likethewind/wx/app/view/quick/blogshow.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/likethewind/wx/app/view/quick/blogshow.tpl', 44, false),array('modifier', 'wikishow', '/home/likethewind/wx/app/view/quick/blogshow.tpl', 60, false),array('modifier', 'nl2br', '/home/likethewind/wx/app/view/quick/blogshow.tpl', 60, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
		#bounce { padding: 0.4em; }
		#bounce h3 { margin: 0; padding: 0.4em; text-align: center; }
	</style>
	<script type="text/javascript">
	var rand='; ?>
<?php echo $this->_tpl_vars['rand']; ?>
<?php echo ';
	$(function() {
		$("#bounce").click(function() {
			if(rand%8==0){
				$("> :eq(0)", this).effect("bounce", {height:5});
			}
			if(rand%8==1){
				//$("> :eq(0)", this).toggle("puff");
				//$("> :eq(0)", this).toggle("fold");
				$("> :eq(0)", this).toggle("pulsate");			
			}
			if(rand%8==2){
				//$(this).effect("highlight");
				$("> :eq(0)", this).toggle("scale");				
			}
			if(rand%8==3){
				$("> :eq(0)", this).toggle("blind");
			}			
			if(rand%8==4){
				$("> :eq(0)", this).toggle("clip");
			}
			if(rand%8==5){
				$("> :eq(0)", this).toggle("drop");
			}
			if(rand%8==6){
				$("> :eq(0)", this).toggle("explode");
			}
			if(rand%8==7){
				$("> :eq(0)", this).toggle("slide");
			}
			rand++;			
		});
	});
	</script>

'; ?>

<div class="drag" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
<h2>
<a href="#" onclick='$("#blogdiv").slideToggle("slow");return false;'>
<?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

</a>
(Drop to Black Hole to delete)</h2>
</div>

<br>
<div id="blogdiv">


	<div id="bounce" class="ui-widget-content ui-corner-all">
	<h3 class="ui-widget-header ui-corner-all"><?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
(Click Me!!)</h3>
	<p>
	
	<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['detail']['content'])) ? $this->_run_mod_handler('wikishow', true, $_tmp) : smarty_modifier_wikishow($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<br>---<br>by <?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['nick'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br>				
	<br><br><br>
	<?php $_from = $this->_tpl_vars['commentblog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['custid']):
?>
	<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['custid']['comment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
<br>-------------------<br>
	<?php endforeach; endif; unset($_from); ?>
	

	</p>
	</div>

</div>
	<iframe width=550 height=500 
scrolling="no" border="0" frameborder="0"
src="/in/x2f/newreply/?father=<?php echo ((is_array($_tmp=$this->_tpl_vars['detail']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></iframe>

<br>
<a href="/quick/">more ..</a>
<br><br><br>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    