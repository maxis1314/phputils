<?php /* Smarty version 2.6.18, created on 2009-09-05 02:50:53
         compiled from /home/likethewind/wx/app/view/error/jslist.tpl */ ?>
<?php echo '
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript">
function addfavorite()
{
	if (document.all){ 
		window.external.addFavorite(\'http://www.ijavascript.cn\',\'ijavascript.cn\');
	}else if (window.sidebar){ 
		window.sidebar.addPanel(\'Dnew.cn\', \'http://www.ijavascript.cn\', ""); 
	}
} 
</script>
<a href=\'javascript:(function(){var%20s=document.createElement("scr"+"ipt");s.charset="UTF-8";s.language="javascr"+"ipt";s.type="text/javascr"+"ipt";var%20d=new%20Date;s.src="http://wx.mim1314.com/error/blackhole/?type=ruby&add=1&other=1&gongsi=0&d="+d.getMilliseconds();document.body.appendChild(s)})();\'>右键添加到收藏夹</a>


'; ?>