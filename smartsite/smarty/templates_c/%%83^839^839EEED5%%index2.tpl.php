<?php /* Smarty version 2.6.18, created on 2009-11-02 10:56:05
         compiled from /home/likethewind/wx/app/view/relation/index2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/likethewind/wx/app/view/relation/index2.tpl', 1, false),array('modifier', 'urlencode', '/home/likethewind/wx/app/view/relation/index2.tpl', 75, false),array('modifier', 'nl2br', '/home/likethewind/wx/app/view/relation/index2.tpl', 75, false),)), $this); ?>
<title>Relation <?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['level']; ?>
</title>
<?php echo '
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="/public/js/suggest.js"></script> 

<style type="text/css"> 
      <!--
        .dropdown {
          position: absolute;
          background-color: #FFFFFF;
          border: 1px solid #CCCCFF;
          width: 252px;
        }
        .dropdown div {
          padding: 1px;
          display: block;
          width: 250px;
          overflow: hidden;
          white-space: nowrap;
        }
        .dropdown div.select{
          color: #FFFFFF;
          background-color: #3366FF;
        }
        .dropdown div.over{
          background-color: #99CCFF;
        }
        -->
    </style>
    
    <script type="text/javascript" language="javascript"> 
    <!--
      var list = [ '; ?>
<?php $_from = $this->_tpl_vars['words']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>'<?php echo $this->_tpl_vars['item']; ?>
', <?php endforeach; endif; unset($_from); ?><?php echo ' \'ROOT\'];
 
      var start = function(){
      	 new Suggest.Local("text", "suggest", list, {ignoreCase: true,prefix: false, highlight: true});
     	 new Suggest.Local("text2", "suggest2", list, {ignoreCase: true, prefix: false, highlight: true});
      };
     
      window.addEventListener ?
        window.addEventListener(\'load\', start, false) :
        window.attachEvent(\'onload\', start);
    //-->
    </script> 
    
'; ?>


<form  method=POST>
<table>
<tr><td>
<div style="margin-left:30px; margin-top:4px;"> 
<input id="text" type=text name=word1 value="<?php if ($this->_tpl_vars['get']['word']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['get']['word'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['word1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" autocomplete="off" size="40" style="display: block"/>
<div id="suggest" class="dropdown"></div> 
</div> </td>
<td>
<div style="margin-left:30px; margin-top:4px;"> 
<input id="text2" type="text" name="word2" value="" autocomplete="off" size="40" style="display: block"/> 
<div id="suggest2" class="dropdown"></div> 
</div>  </td>
<td>
<textarea name=relation></textarea>
<input type=submit>
<input type=hidden name=type value=add>
<input type=hidden name=who value="<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

</td>
</tr>
<table>
</form>

<?php if ($this->_tpl_vars['frwords']): ?>
<h3>forward related</h3>
<table border=1>
<?php $_from = $this->_tpl_vars['frwords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
<tr><td><a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['get']['word'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> -> (<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['relation'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
) -> <a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['word'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a> <a target=_blank href="/filecms/relation2/edit/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">→</a></td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<?php if ($this->_tpl_vars['brwords']): ?>
<h3>backward related</h3>
<table border=1>
<?php $_from = $this->_tpl_vars['brwords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
<tr><td><a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['word'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</a> -> (<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['relation'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
) -> <a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['get']['word'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['get']['word'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><a target=_blank href="/filecms/relation2/edit/<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">→</a></td></tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>

<h3>words</h3>
<hr>
<?php $_from = $this->_tpl_vars['words']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
<a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><a target=_blank href="http://www.google.com/search?hl=zh-CN&btnG=Google+搜索&lr=lang_zh-CN|lang_zh-TW&q=<?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
">→</a>&nbsp;&nbsp;
<?php endforeach; endif; unset($_from); ?>


<h3>all</h3>
<hr>
<?php $_from = $this->_tpl_vars['all']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
<a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word1'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word1'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> -> (<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['relation'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
) -><a href="?who=<?php echo ((is_array($_tmp=$this->_tpl_vars['who'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&type=relation&word=<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word2'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['word2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><br>
<?php endforeach; endif; unset($_from); ?>


<hr>
<a target=_blank href=/filecms/relation2>CRUD <?php echo $this->_tpl_vars['level']; ?>
</a>

<form method=POST action='/filecms/relation2/search'><input type=text name=key size=30 value=""><input type=submit value="検索"></form> 