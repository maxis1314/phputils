{literal}

<script src="/public/js/jquery.js" type="text/javascript"></script>
 
 <script type="text/javascript">
 $(function() {
     $("#selectall").click(function() {
         alert();
     });
     $("#deselectall").click(function() {
     	$("input[@name='shareuser']").each(function() {
             alert();
         });
     });
 });
</script>

{/literal}

 <input type='checkbox' id='in-shareuser-10' name='shareuser[]' value='10' />UserA
 <input type='checkbox' id='in-shareuser-11' name='shareuser[]' value='11' />UserB
 <input type='checkbox' id='in-shareuser-12' name='shareuser[]' value='12' />UserC
  
 <input type="button" id="selectall" name="selectall" value="全选" />
 <input type="button" id="deselectall" name="deselectall" value="取消全选" />

