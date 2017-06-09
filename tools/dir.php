<?php
error_reporting(E_ERROR);
$dir = $argv[1]?$argv[1]:"test";
$search = $argv[2]?$argv[2]:"";
$to = $argv[3]?$argv[3]:"";
$files = listDir($dir);
echo 'DIR:',$dir,"\n";
echo 'Search:',$search,"\n";
echo 'To:',$to,"\n";

foreach($files['lists'] as $one){
    $subdir = $one['name'];    
    if(strpos($subdir,$search)!== false){    
        
        $subfiles = listDir("$dir/$subdir/");        
        foreach($subfiles['lists'] as $two){
            $subname  = $two['name'];
            if(strpos($subname,".wmv")!== false){
                echo "move $dir/$subdir/$subname to $to/$subname\n";
                rename("$dir/$subdir/$subname", "$to/$subname");
            }
        }
    }
}


function listDir($dir){
    if(!file_exists($dir)||!is_dir($dir)){
        return '';
    }
    $dirList=array('dirNum'=>0,'fileNum'=>0,'lists'=>'');
    $dir=opendir($dir);
    $i=0;
    while($file=readdir($dir)){
        if($file!=='.'&&$file!=='..'){
            $dirList['lists'][$i]['name']=$file;
            if(is_dir($file)){
                $dirList['lists'][$i]['isDir']=true;
                $dirList['dirNum']++;
            }else{
                $dirList['lists'][$i]['isDir']=false;
                $dirList['fileNum']++;
            }
            $i++;
        };
    };
    closedir($dir);
    return $dirList;
}