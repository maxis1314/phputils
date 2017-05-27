<?php


$all_list = get_files('.');

foreach($all_list as $one){
    if(preg_match('/^t_/',$one['name'])){
        echo "<h2><a href=$one[name]>$one[name]</a></h2>";
    }
}




function listDir($dirstr){
    if(!file_exists($dirstr)||!is_dir($dirstr)){
        return '';
    }
    $dirList=array('dirNum'=>0,'fileNum'=>0,'lists'=>'');
    $dir=opendir($dirstr);
    $i=0;
    while($file=readdir($dir)){
        if($file!=='.'&&$file!=='..' && !preg_match('/^\./',$file)){
            $dirList['lists'][$i]['name']=$file;
            if(is_dir("$dirstr/$file")){
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

function get_files($dir){
    $dirList=listDir($dir);//array('dirNum'=>0,'fileNum'=>0,'lists'=>'');
    $all_list = array();
    foreach($dirList['lists'] as $one){
        if(!$one['isDir']){
            $all_list[]=$one;
        }
    }  
   
    return $all_list;
}