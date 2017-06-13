<?php
function get_search_keyword($word){
	$key="";
	$wordsraw = split(" ", $word);
	$words=$wordsraw;
	foreach($wordsraw as $value){
		if(strlen($value)>20){
			extendword3($words,$value);
	    }else{
			extendword3($words,$value);
	    }
	}
	$wordnum=count($words);
	foreach($words as $value){
		if(! $words_hash[$value]){
			$not_empty_word[]='"'.$value.'"';
			$not_empty_word2[]=$value;
		}
		$words_hash[$value]=1;
	}
	if($wordnum && $not_empty_word){
		$key =  implode(",", $not_empty_word);
	}
	return $key;
}
function extendword3(&$ra_word,$str){
	$ra=subString_UTF8($str, 0, 100);
	$lenth=count($ra);
	//$str=mb_convert_encoding($str, "utf-8", "gb2312");

	$i=0;
	while($i+2<=$lenth){
		//$substr=mb_convert_encoding($substr,"gb2312", "utf-8");
		$ra_word[]=$ra[$i].$ra[$i+1];
		$i+=1;
	}

	$i=0;
	while($i+3<=$lenth){
		//$substr=mb_convert_encoding($substr,"gb2312", "utf-8");
		$ra_word[]=$ra[$i].$ra[$i+1].$ra[$i+2];
		$i+=1;
	}

	$i=0;
	while($i+4<=$lenth){
		//$substr=mb_convert_encoding($substr,"gb2312", "utf-8");
		$ra_word[]=$ra[$i].$ra[$i+1].$ra[$i+2].$ra[$i+3];
		$i+=1;
	}
}


function getTagCloud($tags,$url="") {
    // $tags is the array
   	$str="";
    #arsort($tags);
   
    $max_size = 250; // max font size in %
    $min_size = 100; // min font size in %
   
    // largest and smallest array values
    $max_qty = max(array_values($tags));
    $min_qty = min(array_values($tags));
   
    // find the range of values
    $spread = $max_qty - $min_qty;
    if ($spread == 0) { // we don't want to divide by zero
            $spread = 1;
    }
   
    // set the font-size increment
    $step = ($max_size - $min_size) / ($spread);
   
   	$str=$str.'<ul class="tagcloud">';
    foreach ($tags as $key => $value) {
    	$size = round($min_size + (($value - $min_qty) * $step));
    	$str=$str.'<li><a title="Search Result for '.htmlspecialchars($key).'" href="'.$url.urlencode($key).'" class="tag" style="font-size:'.$size.'%">'.htmlspecialchars($key).'</a>';
    	$str=$str.' <span class="count">('.$value.')</span></li>';
   }
    $str=$str.'</ul>';
    return $str;
}

function subString_UTF8($str, $start, $lenth){
	$len = strlen($str);
	$r = array();
	$n = 0;
	$m = 0;
	for($i = 0; $i < $len; $i++) {
	$x = substr($str, $i, 1);
	$a = base_convert(ord($x), 10, 2);
	$a = substr('00000000'.$a, -8);
	if ($n < $start){
	if (substr($a, 0, 1) == 0) {
	}elseif (substr($a, 0, 3) == 110) {
	$i += 1;
	}elseif (substr($a, 0, 4) == 1110) {
	$i += 2;
	}
	$n++;
	}else{
	if (substr($a, 0, 1) == 0) {
	$r[] = substr($str, $i, 1);
	}elseif (substr($a, 0, 3) == 110) {
	$r[] = substr($str, $i, 2);
	$i += 1;
	}elseif (substr($a, 0, 4) == 1110) {
	$r[] = substr($str, $i, 3);
	$i += 2;
	}else{
	$r[] = '';
	}
	if (++$m >= $lenth){
	break;
	}
	} 
	}
	return $r;
} // End subString_UTF8


?>