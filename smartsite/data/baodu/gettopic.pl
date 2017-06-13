#!/usr/bin/perl

use WWW::Mechanize;
use Data::Dump qw/dump/;
use Math::Random qw(random_set_seed_from_phrase random_uniform_integer);
use Encode qw/from_to/;
use URI::Escape;
use HTML::LinkExtractor;
use LWP::UserAgent;



my $mech = WWW::Mechanize->new();
$mech->agent_alias( 'Windows Mozilla' );
#$mech->get( 'http://localhost:5558/self/admin/test' );
#print $mech->content();exit;



my $topurl;


AGAIN:

$page=access('http://localhost:5558/self/filecms/counters/show/KogqvoI/value/?op=sub');


#$mech->follow_link( n => 3 );
#$mech->follow_link( text_regex => qr/download this/i );
$topurl='http://zhidao.baidu.com/browse/952?lm=0&pn='.$page;
print $topurl,"\n";
$mech->get($topurl);


my $ra_links=get_url_from_page($mech->content());
my @newurl;
my $urltitle= {};
foreach(@$ra_links){
	if($_->{href} =~ m/question/){
		my $urlforget='http://zhidao.baidu.com'.$_->{href};
		push @newurl,$urlforget;
		my $newstr=$_->{_TEXT};
		from_to($newstr,'gb2312','utf8');
		$urltitle{$urlforget}=$newstr;
		#tolog("monndayi.txt", $urlforget."\n".$newstr);
		access('http://localhost:5558/self/filecms/baoduriyu/add?subfromurl=1&data[flag]=1&data[url]='.$urlforget.'&data[title]='.$newstr);
		access('http://localhost:5558/self/admin/baodu');
	}
}

my $sleeptime=get_random_between(1,10);
print $sleeptime;
sleep $sleeptime;

goto AGAIN;		

sub postnew{
	my $mesh=shift;	
	my $question=shift;
	my $answer=shift;
	my $rh=$mech->get("http://zhidao.baidu.com/q?ct=17&pn=0&tn=ikask&rn=12&word=test4444444&cm=1&lm=394496");
	eval{
	$rh=$mech->submit_form(
	    form_name => 'ftiwen',
	    fields      => {
                queryword=>"test4444444",
				ct=>"22",
				cm=>"100001",
				tn=>"ikreplysubmit",
				cid=>"795",
				pid=>"",
				ti=>"test4444444",
				co=>"test44444444444444444444",
				ra=>"795",
				ClassLevel1=>"79",
				ClassLevel2=>"795",
				ClassLevel3=>"",
				mpn=>"0",
				mt=>"7%2C0%2C6%2C24%2C5%2C4%2C5%2C1%2C61%2C12%2C24%2C3%2C24%2C2%2C24%2C0%2C24%2C0%2C24%2C0%2C24%2C2%2C24%2C12%2C24%2C12%2C24%2C12%2C61%2C2%2C4%2C7%2C1%2C6%2C61%2C5%2C2%2C12%2C4%2C24%2C5%2C4%2C1%2C4%2C12446187503521",
	});
	};
	tolog("1ma.html", $mech->content(),1);
}

sub reply{
	my $mesh=shift;
	my $url=shift;
	my $answer=shift;
	my $rh=$mech->get($url);
	eval{
	$rh=$mech->submit_form(
	    form_name => 'fdf',
	    fields      => {
                #ct=>,
                #cm=>,
                #cid=>,
                #qid=>,
                #tn=>,
                co=>$answer,
	});
	};	
}

sub get_random_from_array{
	my $ra=shift;
	return $ra->[get_random_between(0,1*@$ra-1)];
}

sub get_random_between{
	my $from=shift;
	my $to=shift;
	my @num=random_uniform_integer(1, $from, $to);
	return $num[0];
}

sub tolog{
	my $filename=shift;
	my $content=shift;
	my $clear=shift;
	if($filename and $content){
		if($clear){
			open F, "> $filename";
		}else{
			open F, ">> $filename";
		}
		print F $content;
		print F "\n\n-----------------------------\n\n";
	}
}

sub get_url_from_page{
	my $page = shift;
	my $LX = new HTML::LinkExtractor(undef ,undef ,1);
    $LX->parse(\$page);
	my $ra =  $LX->links;

    return $ra;
}


sub access{
	my $url=shift;
	
	 # Create a user agent object
	 
	  $ua = LWP::UserAgent->new;
	  $ua->agent("MyApp/0.1 ");

	  # Create a request
	  my $req = HTTP::Request->new(GET => $url);
	  $req->content_type('application/x-www-form-urlencoded');
	  $req->content('query=libwww-perl&mode=dist');

	  # Pass request to the user agent and get a response back
	  my $res = $ua->request($req);

	  # Check the outcome of the response
	  if ($res->is_success) {
	      return $res->content;
	  }
	  else {
	      return $res->status_line;
	  }
}