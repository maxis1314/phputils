<hr>
{foreach from=$tables item=custid}
<a href="{$v.prefix}/{$cmspath}/{$custid|urlencode}">{$custid|escape}</a>&nbsp;/&nbsp;
{/foreach}

	</div><!-- end content -->
		</div><!-- end inner -->
	</div><!-- end outer -->
 	<div id="footer"><h1>copyrights&copy;HPX</h1></div>
</div><!-- end container -->
</body></html>
