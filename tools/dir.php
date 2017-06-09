<?php
error_reporting(E_ERROR);
$dir = $argv[1]?$argv[1]:"test";
$search = $argv[2]?$argv[2]:"";
$to = $argv[3]?$argv[3]:"";
$files = listDir($dir);
echo $dir;
echo $search;
echo $to;

foreach($files['lists'] as $one){
    $subdir = $one['name'];    
    if(strpos($subdir,$search)!== false){    
        echo $subdir,"\n";
        $subfiles = listDir("$dir/$subdir/");        
        foreach($subfiles['lists'] as $two){
            $subname  = $two['name'];
            if(strpos($subname,".mp4")!== false){
                rename("$dir/$subdir/$subname", "$to/$subname");
            }
        }
    }
}
