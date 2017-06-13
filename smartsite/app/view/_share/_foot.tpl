
			
			
			</div>
			
			<div id="desna_rubrika" class="drag">
				<h3>Recent articles</h3>
				<p>
				{foreach from=$blog item=custid}				
				<a href="/quick/blogshow/{$custid.id}/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> {$custid.title|escape}</a>
				{/foreach}
				<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
				</p>
    	
				<div id="podaci">
    				<p>Validate > <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | 
					<a href="http://validator.w3.org/check?uri=referer">XHTML 1.0 Strict!</a></p>
    				<p>&copy; Designed by <a href="/in/contact">HPX</a>
					</p>
					<div class="drop" title="Target A">Another Black Hole●</div>	
    			</div>
			</div>

			<div id="lijeva_rubrika"  class="drag">
				<p><b>Recent Comments</b><br />
				{foreach name=foo from=$comment item=item}
				<a href="/quick/blogshow/{$item.content_id|urlencode}"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> {$item.comment|substr2:0:20|escape}</a><br>
				{/foreach}
				<a href="/quick/blog/"><img src="/public/data/layout1/strelica2.gif" width="3px" height="5px" alt="" /> more..</a><br>
				</p>
								
			</div>
		</div>
	</div>

</body>
</html>
{literal}
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17725205-1']);
  _gaq.push(['_setDomainName', '.mim1314.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
{/literal}