{if $get.showdetail}
{include file="_share/_head_simple.tpl"}
{literal}
<script type="text/javascript" src="/public/js/sorttable.js"></script> 
<script type="text/javascript">

function filtertable(term, _id, cellNr){
	var suche = term.value.toLowerCase();
	var table = document.getElementById(_id);
	var ele;	
	for (var r = 1; r < table.rows.length; r++){
		ele = table.rows[r].cells[cellNr].innerHTML.replace(/&lt;[^&gt;]+&gt;/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
			table.rows[r].style.display = '';
		else table.rows[r].style.display = 'none';
	}
}
</script>
<style type="text/css"> 
th, td {
  padding: 3px !important;
}
 
/* Sortable tables */
table.sortable thead {
    background-color:#eee;
    color:#666666;
    font-weight: bold;
    cursor: default;
}
</style> 

{/literal}


<form>
	Search:<input name="filter" onkeyup="filtertable(this, 'filtertableid', 2)" type="text">
</form>




<table class="sortable" id="filtertableid">
<tr>
<th>ID</th>
<th>GUSHU</th>
<th>GUNOW</th>
<th>SUNYI</th>
<th>GUJIAOLV</th>
<th>PERPBR</th>
<th>BUY/SELL</th>
<th>Operate</th>
</tr>
 {foreach name=foo from=$list item=item}
  <tr>
   {cycle values="#ffffff, #f0f0f0" assign="tr_color"}
             
   <td style="background-color:{$tr_color};"><a href="{$v.prefix}/gu/sync/{$item.guid}">Detail</a>&nbsp;<a target=_blank href="http://smartchart.nikkei.co.jp/smartchart.aspx?Scode={$item.guid|escape}" alt="{$item.guming|escape}">{$item.guid|escape}</a>
   <br><a target=_blank href="http://stocks.finance.yahoo.co.jp/stocks/detail/?code={$item.guid|escape}">{$item.gunow*$item.gujiao|suji}</a>
   
   </td>
  

   <td style="background-color:{$tr_color};"><a href="{$v.prefix}/gu/show/{$item.guid}"><br>{$item.gushu|suji}&nbsp;</a><br>{$item.guin|suji}</td>
             
   <td style="background-color:{$tr_color};">
   {if $item.gubian>=0}<font color=green><b>{/if}{$item.gunow|suji}<br>({$item.gubian}/{$item.gubianlv}){if $item.gubian>0}</b></font>{/if}
   <br>
   JF({$item.guxiao|suji}~{$item.guda|suji})
   </td>
   <td style="background-color:{$tr_color};">
   		{$item.sunyi|suji}/({$item.sunyi/$item.gushu|suji})
   		({if $item.sunyilv>10 || $item.sunyi>2000}<font color=red>{/if}YL:{$item.sunyilv|suji}{if $item.sunyilv>10 || $item.sunyi>2000}</font>{/if}%)<br>
   		{$item.fududown|suji}~{$item.fuduup|suji}<br>
   		D{$item.gunow-$item.fududown|suji}:U{$item.fuduup-$item.gunow|suji}
   </td>
             
   <td style="background-color:{$tr_color};">
   		GJL:{$item.gujiaolv|escape}%<br>
   		JYL:{$item.gujiao|suji}<br>
   		ZL:{$item.guliang|suji}
   </td>   
   <td style="background-color:{$tr_color};">
		{$item.per}(0|-*)<br>{$item.pbr}(S)
   </td>
   <td style="background-color:{$tr_color};">
	  	B:{$item.buyleft*$item.gunow|suji}<br>
	  	S:{$item.sellleft*$item.gunow|suji}<br>
	  	{assign var=running_total value=`$item.buyleft-$item.sellleft`}
		B-S:{$running_total/$item.sellleft}
   </td>
      
      
   <td style="background-color:{$tr_color};">       
   [
   <a href="{$v.prefix}/gu/edit/{$item.guid}">{$item.fenxi}Edit</a>,
   <a href="{$v.prefix}/gu/delete/{$item.id}" onclick="return confirm(&#039;Are you sure?&#039;);">Delete</a>
   ]{$item.guming|escape}]
   {$item.comment|escape}
   </td>
  </tr>
   {/foreach}
  <tr><td></td><td>{$allziben|suji}</td><td>{$allziben+$allsunyi|suji}</td><td>{$allsunyi|suji}</td><td>{$allsunyi*100/$allziben}%</td><td></td></tr>
</table>
<br>

{$foot|replace:'<br>':''}
<br><a href="{$v.prefix}/gu/add">Add</a>
<a href="{$v.prefix}/gu/sync_all/">Sync</a>
<a href="{$v.prefix}/gu/showgraph/">Graph</a>
<form method=POST action='{$v.prefix}/gu/search'><input type=text name=key size=4 value="{$post.key|escape}"><input type=submit value="search"></form>



{include file="_share/_foot_simple.tpl"}
{else}
<title>{foreach from=$list item=item}{if $item.sunyi}{$item.sunyi|suji}:{/if}{/foreach}{$headtitle|suji}/{$allsunyi*100/$allziben}%</title>
<a href="/gu/index?showdetail=1">det</a>
{/if}
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>