{include file="_share/_head_simple.tpl"}


<a target=_blank href=/public/template/index.html>模板一览</a>

{if !empty($list)}
	<table border=1>
	{foreach name=foo from=$list item=item}
	  <tr>
	  
	  <td>{$item.name}</td>
	  <td><a href=/qiye/detail/{$item.name}/>详细</a></td>
	  <td><a target=_blank href=/qiye/top/{$item.name}/>查看动态网页</a></td>
	  <td>添加
	  	<select onchange="window.open(this.options[this.selectedIndex].value)"> 
	  	<option value="/qiyedb/">一览</option>   
	  	<option value="/qiyedb/qiye/add/?name={$item.name}&type=news">新闻</option>     
	  	<option value="/qiyedb/qiye/add/?name={$item.name}&type=public">公告 </option>
	  	<option value="/qiyedb/qiye/add/?name={$item.name}&type=pic">图片 </option> 
	  	<option value="/qiyedb/qiye/add/?name={$item.name}&type=link">链接 </option>  
	  	</select>
	  </td>
	  <td><a target=_blank href=/qiye/savetohtml/{$item.name}/>同步</a></td>
	  <td><a target=_blank href=/qiyedb/qiye/search?key={$item.name}>DB</a></td>
	  </tr>
	{/foreach}
	</table>
{/if}


{include file="_share/_foot_simple.tpl"}