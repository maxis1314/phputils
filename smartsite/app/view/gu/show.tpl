{include file="_share/_head_simple.tpl"}
<META HTTP-EQUIV="Refresh" CONTENT="20; URL=/gu/sync/{$data.guid}">

<h3><a href="{$v.prefix}/gu/sync/{$data.guid}">Show</a></h3>
<a href={$v.prefix}/gu/edit/{$data.guid}>Edit</a><br>
<a href={$v.prefix}/gu/?showdetail=1>List</a>
<a href=#pic>PIC</a>
<table>


<tr><td>
guid
</td>
<td><pre>
{$data.guid|escape}
+{$upjiaoliang|suji}/-{$downjiaoliang|suji}
{$upjiaoliang-$downjiaoliang|suji}/{$gulianghe|suji}
</pre>
</td></tr>


<tr><td>
guin
</td>
<td><pre>
{$data.guin|escape} X {$data.gushu|escape} = {$data.guin*$data.gushu|suji}
</pre>
</td></tr>

<tr><td>
gunow
</td>
<td><pre>
{$data.gunow|escape}({$data.fududown|escape},{$data.fuduup|escape})
</pre>
</td></tr>
<tr><td>
danwei
</td>
<td><pre>
{$data.danwei|escape}
</pre>
</td></tr>
<tr><td>
fenxi
</td>
<td><pre>
{$data.fenxi|escape}
</pre>
</td></tr>

<tr><td>
comment
</td>
<td><pre>
{$data.comment|escape}
</pre>
</td></tr>


PREDIT[{$preditdown}~{$preditup}]({$preditup-$preditdown|suji})
<table border=1>
<tr>
<th>ID</th>
<th>GUID</th>
<th>GUSHU</th>
<th>GUIN</th>
<th>GUNOW</th>
<th>SUNYI</th>
<th>SUNYI%</th>
<th>GUJIAOLV</th>
<th>BS</th>
<th>Predit</th>
</tr>
 {foreach name=foo from=$data2 item=item}
  <tr>
   {cycle values="#ffffff, #f0f0f0" assign="tr_color"}
             
   <td style="background-color:{$tr_color};"><a target=_blank href="http://stocks.finance.yahoo.co.jp/stocks/detail/?code={$item.guid|escape}">{$item.date|escape}</a>
   <br>{$item.gujiao*$item.gunow|suji}
   </td>
             
   <td style="background-color:{$tr_color};"><a target=_blank href="http://money.www.infoseek.co.jp/MnStock/{$item.guid|escape}/schart/">{$item.guid|escape}</a></td>
             
   <td style="background-color:{$tr_color};">{$item.gushu|suji}</td>
             
   <td style="background-color:{$tr_color};">{$item.guin|suji}</td>
             
   <td style="background-color:{$tr_color};">{if $item.gubian>=0}<font color=green><b>{/if}{$item.gunow|suji}({$item.gubian}/{$item.gubianlv}){if $item.gubian>0}</b></font>{/if}
   <br>
   JF({$item.guxiao|suji}~{$item.guda|suji})
   <br>
   FD({$item.fududown|suji}~{$item.fuduup|suji})<br>
   D{$item.gunow-$item.fududown|suji}:U{$item.fuduup-$item.gunow|suji}
   </td>
   <td style="background-color:{$tr_color};">{$item.sunyi|suji}<br>({$item.sunyi/$item.gushu|suji})</td>
   <td style="background-color:{$tr_color};">{if $item.sunyilv>10}<font color=red>{/if}{$item.sunyilv|suji}{if $item.sunyilv>10}</font>{/if}%</td>
             
   <td style="background-color:{$tr_color};">{$item.gujiaolv|escape}%({$item.gujiao|suji}/{$item.guliang|suji})</td>
   <td style="background-color:{$tr_color};">B:{$item.buyleft*$item.gunow|suji}<br>
	  	S:{$item.sellleft*$item.gunow|suji}<br>
		B-S:{$item.buyleft*$item.gunow-$item.sellleft*$item.gunow|suji}</td>
      
<td style="background-color:{$tr_color};">asi:{$item.preditdown|suji}~{$item.preditup|suji}</td> 
  </tr>
  
   {/foreach}
 
</table>
<a name=pic>
<br>
JG<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$y}&cht=lc"><br>
JL<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$x}&cht=lc"><br>
FU<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$z}&cht=lc"><br>
BS<img src="http://chart.apis.google.com/chart?chs=250x150&chd=t:{$z}&cht=lc">
<br>{$x}<br>{$y}


<br>
<a href={$v.prefix}/gu/edit/{$data.guid}>Edit</a><br>
<a href={$v.prefix}/gu/>List</a>

<br><br><br><br><br>

<table border=1>
{foreach name=foo from=$data2 item=item}
<tr><td>{$item.date|escape}<br>
<img src="/public/gu/{$item.guid|escape}-{$item.date|escape}.png"></td></tr>
{/foreach}
</table>


{include file="_share/_foot_simple.tpl"}