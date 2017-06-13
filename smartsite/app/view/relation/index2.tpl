<title>Relation {$who|escape} {$level}</title>
{literal}
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
      var list = [ {/literal}{foreach name=foo from=$words item=item}'{$item}', {/foreach}{literal} 'ROOT'];
 
      var start = function(){
      	 new Suggest.Local("text", "suggest", list, {ignoreCase: true,prefix: false, highlight: true});
     	 new Suggest.Local("text2", "suggest2", list, {ignoreCase: true, prefix: false, highlight: true});
      };
     
      window.addEventListener ?
        window.addEventListener('load', start, false) :
        window.attachEvent('onload', start);
    //-->
    </script> 
    
{/literal}

<form  method=POST>
<table>
<tr><td>
<div style="margin-left:30px; margin-top:4px;"> 
<input id="text" type=text name=word1 value="{if $get.word}{$get.word|escape}{else}{$post.word1|escape}{/if}" autocomplete="off" size="40" style="display: block"/>
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
<input type=hidden name=who value="{$who|escape}">

</td>
</tr>
<table>
</form>

{if $frwords}
<h3>forward related</h3>
<table border=1>
{foreach name=foo from=$frwords item=item}
<tr><td><a href="?who={$who|urlencode}&type=relation&word={$item.word|urlencode}">{$get.word|escape}</a> -> ({$item.relation|nl2br}) -> <a href="?who={$who|urlencode}&type=relation&word={$item.word|urlencode}">{$item.word|escape|nl2br}</a> <a target=_blank href="/filecms/relation2/edit/{$item.id|escape}">→</a></td></tr>
{/foreach}
</table>
{/if}

{if $brwords}
<h3>backward related</h3>
<table border=1>
{foreach name=foo from=$brwords item=item}
<tr><td><a href="?who={$who|urlencode}&type=relation&word={$item.word|urlencode}">{$item.word|escape|nl2br}</a> -> ({$item.relation|nl2br}) -> <a href="?who={$who|urlencode}&type=relation&word={$get.word|urlencode}">{$get.word|escape}</a><a target=_blank href="/filecms/relation2/edit/{$item.id|escape}">→</a></td></tr>
{/foreach}
</table>
{/if}

<h3>words</h3>
<hr>
{foreach name=foo from=$words item=item}
<a href="?who={$who|urlencode}&type=relation&word={$item|urlencode}">{$item|escape}</a><a target=_blank href="http://www.google.com/search?hl=zh-CN&btnG=Google+搜索&lr=lang_zh-CN|lang_zh-TW&q={$item|urlencode}">→</a>&nbsp;&nbsp;
{/foreach}


<h3>all</h3>
<hr>
{foreach name=foo from=$all item=item}
<a href="?who={$who|urlencode}&type=relation&word={$item.word1|urlencode}">{$item.word1|escape}</a> -> ({$item.relation|escape}) -><a href="?who={$who|urlencode}&type=relation&word={$item.word2|urlencode}">{$item.word2|escape}</a><br>
{/foreach}


<hr>
<a target=_blank href=/filecms/relation2>CRUD {$level}</a>

<form method=POST action='/filecms/relation2/search'><input type=text name=key size=30 value=""><input type=submit value="検索"></form> 