<?php /* Smarty version 2.6.18, created on 2017-06-13 18:55:20
         compiled from F:%5Cgit%5Cphputils%5Csmartsite/app/view/scaffold/code.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'F:\\git\\phputils\\smartsite/app/view/scaffold/code.tpl', 11, false),array('modifier', 'bigcase', 'F:\\git\\phputils\\smartsite/app/view/scaffold/code.tpl', 25, false),)), $this); ?>
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


<?php if ($this->_tpl_vars['table_detail']): ?>
<hr>
insert into <?php echo $this->_tpl_vars['table_name']; ?>

(<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
,<?php endforeach; endif; unset($_from); ?>
)
values(<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>'<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',<?php endforeach; endif; unset($_from); ?>
)
<?php endif; ?>
<br>
<a href=#php>PHP</a> / <a href=#java>JAVA</a>  / <a href=#perl>Perl</a> / <a href=#csharp>C#</a>
/ <a href=#hibernate>hibernate</a>/ <a href=#form>form</a>/ <a href=#table>Table</a>


<a name=php></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>PHP</b>
<pre>
class <?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
 {
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	private $<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
;
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
	public function get<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
() {
		return $this-><?php echo $this->_tpl_vars['item']['name']; ?>
;
	}
	public function set<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
($<?php echo $this->_tpl_vars['item']['name']; ?>
) {
		$this-><?php echo $this->_tpl_vars['item']['name']; ?>
 = $<?php echo $this->_tpl_vars['item']['name']; ?>
;
	}
<?php endforeach; endif; unset($_from); ?>
}
</pre>
<?php endif; ?>


<a name=java></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>JAVA</b>
<pre>
public class <?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
 {
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	private String <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
;
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
	public String get<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
() {
		return <?php echo $this->_tpl_vars['item']['name']; ?>
;
	}
	public void set<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
(String <?php echo $this->_tpl_vars['item']['name']; ?>
) {
		this.<?php echo $this->_tpl_vars['item']['name']; ?>
 = <?php echo $this->_tpl_vars['item']['name']; ?>
;
	}
<?php endforeach; endif; unset($_from); ?>
}
 
</pre>
<?php endif; ?>


<a name=perl></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>Perl</b>
<pre>
//<?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
.pm
package <?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
;
<?php echo '
sub new{
    my $class = shift;
    my $self = {};
    return bless $self, $class;
}
'; ?>

<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
sub get<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
{
 	my $self = shift;
	return $self->{<?php echo $this->_tpl_vars['item']['name']; ?>
};
}
sub set<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
{
	my $self = shift;
	$self->{<?php echo $this->_tpl_vars['item']['name']; ?>
} = shift;
}
<?php endforeach; endif; unset($_from); ?>

 
</pre>
<?php endif; ?>


<a name=csharp></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>C#</b>
<pre>
public class <?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
 {
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	private string <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
;
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
	public string <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
() {	
		get { return <?php echo $this->_tpl_vars['item']['name']; ?>
; }
		set { <?php echo $this->_tpl_vars['item']['name']; ?>
=value; }
	}	
<?php endforeach; endif; unset($_from); ?>
}
 
</pre>
<?php endif; ?>

<a name=hibernate></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>hibernate</b>
<pre>
&lt;hibernate-mapping&gt;  
    &lt;class name="<?php echo ((is_array($_tmp=$this->_tpl_vars['table_name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
" table="<?php echo $this->_tpl_vars['table_name']; ?>
" lazy="false"&gt;  
    &lt;id name="id"&gt;  
     &lt;generator class="identity"/&gt;  
     &lt;/id&gt;
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        &lt;property name="<?php echo $this->_tpl_vars['item']['name']; ?>
"/&gt;
<?php endforeach; endif; unset($_from); ?>               
    &lt;/class&gt;  
&lt;/hibernate-mapping&gt; 
</pre>
<?php endif; ?>


<a name=form></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>Form</b>
<pre>
<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
 : &lt;input type=text name="<?php echo $this->_tpl_vars['item']['name']; ?>
"&gt;
<?php endforeach; endif; unset($_from); ?>
</pre>
<?php endif; ?>

<a name=table></a>
<?php if ($this->_tpl_vars['table_detail']): ?>
<hr><b>Table</b>
<pre>
&lt;table border=1&gt;
&lt;tr&gt;<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>&lt;th&gt;<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('bigcase', true, $_tmp) : smarty_modifier_bigcase($_tmp)); ?>
&lt;/th&gt;<?php endforeach; endif; unset($_from); ?>&lt;/tr&gt;
&lt;tr&gt;<?php $_from = $this->_tpl_vars['table_detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>&lt;td&gt;<?php echo $this->_tpl_vars['item']['name']; ?>
&lt;/td&gt;<?php endforeach; endif; unset($_from); ?>&lt;/tr&gt;
&lt;/table&gt;
</pre>
<?php endif; ?>




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