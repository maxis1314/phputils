<?php /* Smarty version 2.6.18, created on 2009-09-11 02:53:21
         compiled from /home/likethewind/wx/app/view/flash/flex.tpl */ ?>
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
<param name="movie" value="/data/flex/FXVideo_Example.swf" /> 
<param name="quality" value="high" /> 
<param name="bgcolor" value="#000000" /> 
<param name="allowfullscreen" value="true" /> 
<param name="flashvars" value="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&var1='; ?>
<?php echo $this->_tpl_vars['videoUrl']; ?>
<?php echo '&streamType=vod&autoStart=false&DS_Status=true" /> 

<embed src="/data/flex/FXVideo_Example.swf" width="'; ?>
<?php echo $this->_tpl_vars['width']; ?>
<?php echo '" height="'; ?>
<?php echo $this->_tpl_vars['height']; ?>
<?php echo '" id="videoPlayer" quality="high" bgcolor="#000000" name="videoPlayer" allowfullscreen="true" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="&videoWidth=&videoHeight=&dsControl=manual&dsSensitivity=1&var1='; ?>
<?php echo $this->_tpl_vars['videoUrl']; ?>
<?php echo '&streamType=vod&autoStart=false&DS_Status=true" type="application/x-shockwave-flash" > </embed>
</object>


'; ?>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_share/_foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>