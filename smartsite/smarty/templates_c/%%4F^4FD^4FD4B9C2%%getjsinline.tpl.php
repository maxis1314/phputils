<?php /* Smarty version 2.6.18, created on 2009-08-30 17:35:06
         compiled from /home/.escort/likethewind/wx/app/view/error/getjsinline.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', '/home/.escort/likethewind/wx/app/view/error/getjsinline.tpl', 49, false),)), $this); ?>
<?php echo '(function() {

document.title="fangyi";

var linkElem = document.createElement(\'link\');
linkElem.rel=\'stylesheet\';
linkElem.type=\'text/css\';
linkElem.href=\'http://localhost:5558/rubythings.css\';
document.getElementsByTagName(\'head\')[0].appendChild(linkElem);

function getselect(){
    var a = "";//.toUpperCase();
    try {
        var selecter = window.getSelection();
        return selecter;
    }catch (err) {
        var selecter = document.selection.createRange();
        return selecter.text;
    }
    /*a = a.toString().replace(/ /g, "");
    if (a.length > 20) {
        a = "";
    /}*/
    return a;
}

function setframe(evt){
	var selected=getselect();
	settext(selected);
}

function settext(text){
	if(text){		
		parent.frames["iframe3g4454"].location.href=\'http://localhost:5558/self/admin/rubyinline/\'+encodeURI(text)+\'/'; ?>
<?php echo $this->_tpl_vars['url'][0]; ?>
<?php echo '/?min=1\';
		return;
	}
}


function callfromchild(){
	alert("333");
}



var x= document.body.innerHTML;
'; ?>

<?php $_from = $this->_tpl_vars['replace']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
x=x.replace(/<?php echo $this->_tpl_vars['item'][1]; ?>
/g,"<ruby><rb><font color=blue><?php echo $this->_tpl_vars['item'][1]; ?>
</font></rb><rp></rp><rt><a target=_blank href='http://localhost:5558/self/admin/rubyinline/<?php echo ((is_array($_tmp=$this->_tpl_vars['item'][1])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
/jp/'><font color=red><?php echo $this->_tpl_vars['item'][0]; ?>
</font></a></rt><rp></rp></ruby>");
<?php endforeach; endif; unset($_from); ?>


<?php if (! $this->_tpl_vars['url'][0]): ?>
document.body.innerHTML=x;
<?php else: ?>
<?php echo '
document.body.innerHTML="";

//otherthing
var maindiv = document.createElement("div");
var mydiv = document.createElement("div");
var iframe = document.createElement("iframe");
iframe.name="iframe3g4454";
iframe.width=1000;
iframe.height=700;
iframe.src="http://localhost:5558/self/admin/rubyinline/?min=1";
mydiv.appendChild(iframe);
maindiv.id="main3g4454";
mydiv.id="navigation3g4454";
maindiv.innerHTML=x+"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";

document.body.appendChild(maindiv);
document.body.appendChild(mydiv);

document.body.onmouseup = function (evt) { setframe(evt); };

'; ?>

<?php endif; ?>

<?php echo '
})();'; ?>
