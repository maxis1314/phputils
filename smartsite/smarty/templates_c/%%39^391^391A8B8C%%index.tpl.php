<?php /* Smarty version 2.6.18, created on 2009-08-30 07:00:00
         compiled from /home/.escort/likethewind/wx/app/view/flash/index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<object width="'; ?>
<?php echo $this->_tpl_vars['width']; ?>
<?php echo '" height="'; ?>
<?php echo $this->_tpl_vars['height']; ?>
<?php echo '" id="videoPlayer" name="videoPlayer" type="application/x-shockwave-flash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" >
<param name="movie" value="/data/player/videoPlayer.swf" /> 
<param name="quality" value="high" /> 
<param name="bgcolor" value="#000000" /> 
<param name="allowfullscreen" value="true" /> 
<param name="flashvars" value="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&serverURL='; ?>
<?php echo $this->_tpl_vars['videoUrl']; ?>
<?php echo '&streamType=vod&autoStart=false&DS_Status=true" /> 

<embed src="/data/player/videoPlayer.swf" width="'; ?>
<?php echo $this->_tpl_vars['width']; ?>
<?php echo '" height="'; ?>
<?php echo $this->_tpl_vars['height']; ?>
<?php echo '" id="videoPlayer" quality="high" bgcolor="#000000" name="videoPlayer" allowfullscreen="true" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&serverURL='; ?>
<?php echo $this->_tpl_vars['videoUrl']; ?>
<?php echo '&streamType=vod&autoStart=false&DS_Status=true" type="application/x-shockwave-flash" > </embed>
</object>


'; ?>

 <?php $_from = $this->_tpl_vars['allVideo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['col']):
        $this->_foreach['foo']['iteration']++;
?>
 <a href=/flash/index/<?php echo $this->_tpl_vars['col']['id']; ?>
><?php echo $this->_tpl_vars['col']['name']; ?>
</a><br>
 <?php endforeach; endif; unset($_from); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>