<?php
require_once("/home/likethewind/hpx1011.unibeing.net/lib/DBInst.php");
//word,url,num  

   $strings = file("/home/likethewind/perl/urlinfofr.csv");
   $i=0;
   $str="(0,0,0,0)"; 
   foreach ($strings as $line) {$i++;
	   $pieces = explode(",", $line);
	   $pieces[0]=str_replace("'", "", $pieces[0]);
	   $pieces[0]=chop($pieces[0]);
	   $pieces[1]=str_replace("'", "", $pieces[1]);
	   $pieces[1]=chop($pieces[1]);
	   $pieces[2]=str_replace("'", "", $pieces[2]);
	   $pieces[2]=chop($pieces[2]);
	   $pieces[3]=str_replace("'", "", $pieces[3]);
	   $pieces[3]=chop($pieces[3]);
	   $str.=",('$pieces[0]','$pieces[1]','$pieces[2]','$pieces[3]')";
	   if($i%1000==0){
	   	   echo $i,"\n";
	   	   $db->update("insert ignore into url_infofr(url,title,keyw,chaset) values $str");
	   	   sleep(1);
		   $str="(0,0,0,0)";
	   }
   }
   if($str != "(0,0,0,0)"){
  	   	   $db->update("insert ignore into url_infofr(url,title,keyw,chaset) values$str");
   }
   
?>
