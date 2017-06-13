{include file="_share/_head_simple.tpl"}


{$info|escape}
<form method = GET>
Host<input type=text name=host value="{if $get.host}{$get.host|escape}{else}db4free.net{/if}">Port<input type=text name=port value="{if $get.port}{$get.port|escape}{else}3306{/if}">
User<input type=text name=user value="{if $get.user}{$get.user|escape}{else}greedisok{/if}">Pass<input type=text name=pass value="{if $get.pass}{$get.pass|escape}{else}greedisok{/if}">
DB<input type=text name=db value="{if $get.db}{$get.db|escape}{else}greedisok{/if}">

<input type=submit name=submit>

</form>


{if $table_list}
<hr>
{foreach from=$table_list item=item}
<a href="{$rooturl}&t={$item|escape}">{$item|escape}</a><br>
{/foreach}
{/if}
{if $table_detail}
<hr>
insert into {$get.t}
({foreach from=$table_detail item=item}{$item.name|escape},{/foreach}
)
values({foreach from=$table_detail item=item}'{$item.name|escape}',{/foreach}
)
{/if}
<br>
<a href=#php>PHP</a> / <a href=#java>JAVA</a>  / <a href=#perl>Perl</a> / <a href=#csharp>C#</a>
/ <a href=#hibernate>hibernate</a>/ <a href=#form>form</a>/ <a href=#table>Table</a>


<a name=php></a>
{if $table_detail}
<hr><b>PHP</b>
<pre>
class {$get.t|bigcase} {ldelim}
{foreach from=$table_detail item=item}
	private ${$item.name|escape};
{/foreach}
{foreach from=$table_detail item=item}    
	public function get{$item.name|bigcase}() {ldelim}
		return $this->{$item.name};
	{rdelim}
	public function set{$item.name|bigcase}(${$item.name}) {ldelim}
		$this->{$item.name} = ${$item.name};
	{rdelim}
{/foreach}
{rdelim}
</pre>
{/if}


<a name=java></a>
{if $table_detail}
<hr><b>JAVA</b>
<pre>
public class {$get.t|bigcase} {ldelim}
{foreach from=$table_detail item=item}
	private String {$item.name|escape};
{/foreach}
{foreach from=$table_detail item=item}    
	public String get{$item.name|bigcase}() {ldelim}
		return {$item.name};
	{rdelim}
	public void set{$item.name|bigcase}(String {$item.name}) {ldelim}
		this.{$item.name} = {$item.name};
	{rdelim}
{/foreach}
{rdelim}
 
</pre>
{/if}


<a name=perl></a>
{if $table_detail}
<hr><b>Perl</b>
<pre>
//{$get.t|bigcase}.pm
package {$get.t|bigcase};
{literal}
sub new{
    my $class = shift;
    my $self = {};
    return bless $self, $class;
}
{/literal}
{foreach from=$table_detail item=item}    
sub get{$item.name|bigcase}{ldelim}
 	my $self = shift;
	return $self->{ldelim}{$item.name}{rdelim};
{rdelim}
sub set{$item.name|bigcase}{ldelim}
	my $self = shift;
	$self->{ldelim}{$item.name}{rdelim} = shift;
{rdelim}
{/foreach}

 
</pre>
{/if}


<a name=csharp></a>
{if $table_detail}
<hr><b>C#</b>
<pre>
public class {$get.t|bigcase} {ldelim}
{foreach from=$table_detail item=item}
	private string {$item.name|escape};
{/foreach}
{foreach from=$table_detail item=item}    
	public string {$item.name|bigcase}() {ldelim}	
		get {ldelim} return {$item.name}; {rdelim}
		set {ldelim} {$item.name}=value; {rdelim}
	{rdelim}	
{/foreach}
{rdelim}
 
</pre>
{/if}

<a name=hibernate></a>
{if $table_detail}
<hr><b>hibernate</b>
<pre>
&lt;hibernate-mapping&gt;  
    &lt;class name="{$get.t|bigcase}" table="{$get.t}" lazy="false"&gt;  
    &lt;id name="id"&gt;  
     &lt;generator class="identity"/&gt;  
     &lt;/id&gt;
{foreach from=$table_detail item=item}
        &lt;property name="{$item.name}"/&gt;
{/foreach}               
    &lt;/class&gt;  
&lt;/hibernate-mapping&gt; 
</pre>
{/if}


<a name=form></a>
{if $table_detail}
<hr><b>Form</b>
<pre>
{foreach from=$table_detail item=item}
{$item.name|bigcase} : &lt;input type=text name="{$item.name}"&gt;
{/foreach}
</pre>
{/if}

<a name=table></a>
{if $table_detail}
<hr><b>Table</b>
<pre>
&lt;table border=1&gt;
&lt;tr&gt;{foreach from=$table_detail item=item}&lt;th&gt;{$item.name|bigcase}&lt;/th&gt;{/foreach}&lt;/tr&gt;
&lt;tr&gt;{foreach from=$table_detail item=item}&lt;td&gt;{$item.name}&lt;/td&gt;{/foreach}&lt;/tr&gt;
&lt;/table&gt;
</pre>
{/if}




{include file="_share/_foot_simple.tpl"}