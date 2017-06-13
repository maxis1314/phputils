<title>Relation {$level}</title>
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
<input type=text name=relation>
<input type=submit>
<input type=hidden name=type value=add></td>
</tr>
<table>
</form>

{if $rwords}
<h3>related</h3>
<hr>
{foreach name=foo from=$rwords item=item}
<a href="?type=relation&word={$item|urlencode}">{$item}</a><a target=_blank href="http://www.google.com/search?hl=zh-CN&btnG=Google+搜索&lr=lang_zh-CN|lang_zh-TW&q={$item|urlencode}">→</a>&nbsp;&nbsp;
{/foreach}
{/if}

<h3>all</h3>
<hr>
{foreach name=foo from=$words item=item}
<a href="?type=relation&word={$item|urlencode}">{$item}</a><a target=_blank href="http://www.google.com/search?hl=zh-CN&btnG=Google+搜索&lr=lang_zh-CN|lang_zh-TW&q={$item|urlencode}">→</a>&nbsp;&nbsp;
{/foreach}





<hr>
<a target=_blank href=/filecms/relation>CRUD {$level}</a>