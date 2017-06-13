<?php /* Smarty version 2.6.18, created on 2010-08-13 23:12:13
         compiled from _share/_foot.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '_share/_foot.tpl', 10, false),array('modifier', 'urlencode', '_share/_foot.tpl', 27, false),array('modifier', 'substr2', '_share/_foot.tpl', 27, false),)), $this); ?>

			
			
			</div>
			
			<div id="desna_rubrika" class="drag">
				<h3>Recent articles</h3>
				<p>
				<?php $_from = $this->_tpl_vars['blog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['custid']):
?>				
				<a href="/quick/blogshow/<?php echo $this->_tpl_vars['custid']['id']; ?>
/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> <?php echo ((is_array($_tmp=$this->_tpl_vars['custid']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
				<?php endforeach; endif; unset($_from); ?>
				<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
				</p>
    	
				<div id="podaci">
    				<p>Validate > <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | 
					<a href="http://validator.w3.org/check?uri=referer">XHTML 1.0 Strict!</a></p>
    				<p>&copy; Designed by <a href="/in/contact">HPX</a>
					</p>
					<div class="drop" title="Target A">Another Black Hole●</div>	
    			</div>
			</div>

			<div id="lijeva_rubrika"  class="drag">
				<p><b>Recent Comments</b><br />
				<?php $_from = $this->_tpl_vars['comment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
				<a href="/quick/blogshow/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['content_id'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['comment'])) ? $this->_run_mod_handler('substr2', true, $_tmp, 0, 20) : smarty_modifier_substr2($_tmp, 0, 20)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><br>
				<?php endforeach; endif; unset($_from); ?>
				<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
				</p>
								
			</div>
		</div>
	</div>

</body>
</html>
<?php echo '
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-17725205-1\']);
  _gaq.push([\'_setDomainName\', \'.mim1314.com\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
'; ?>