<?php
require("dbcenter.php");
$dbconfig = get_db_config($config_name);

if(!isset($dbconfig)){
    die("attack");
}
if(!isset($primkey)){
    $primkey="id";
}
if(!isset($database)){
    $database="awesome";
}
//first 
include_once('Datagrid.php');
//settings

class myclass extends Datagrid{
    
    //rewrite this function to custom   table body 
    public function extendField($name,$fieldHtml,$value=null) {
        if($name=="1111project"){
            $category=array('企业福利平台','SC04','SC05');
            $fieldHtml= "
            <select name='project' id='type'>";
            foreach($category as $one){
                if($value  == $one){
                    $fieldHtml.="<option value='$one' selected>$one</option>";
                }else{
                    $fieldHtml.="<option value='$one'>$one</option>";
                }
            }           
            $fieldHtml.="</select>";
        }
        if($name=="person"){
            $category=array('陈振刚','汪士美','曾德发','沈雨后','汤红平','全体');
            $fieldHtml= "
            <select name='person' id='type'>";
            foreach($category as $one){
                if($value  == $one){
                    $fieldHtml.="<option value='$one' selected>$one</option>";
                }else{
                    $fieldHtml.="<option value='$one'>$one</option>";
                }
            }           
            $fieldHtml.="</select>";
        }
        if($name=='when'){
            return '<input type="text" name="start_at" id="datepicker" value="'.$value.'" size="20"  />';
        }
        if($name=='end_at'){
            return '<input type="text" name="end_at" id="datepicker2" value="'.$value.'" size="20"  />';
        }
        if($name=='content'){
            return '<textarea name="content" rows=20 cols=60>'.$value.'</textarea>';
        }
        return $fieldHtml;
    }
}




$gridObj=new myclass($dbconfig[0],$dbconfig[1],$dbconfig[2],$dbconfig[3],"utf8");
//$gridObj=new Datagrid("localhost","wuser","sichang0923",$database,"utf8");
$gridObj->tables="$table_name";
$gridObj->formPrimkey="$primkey";

$gridObj->pageRow=20;


//$gridObj->displayTableTitle=false;	//no display Table Title
//$gridObj->displayOrder=false;		//no display order 
//$gridObj->displayTableHeader=false;	//no display Table Header
$gridObj->displaySearch=true;		//no display Search part
//$gridObj->displayControl=false;		//no display Control colums
//$gridObj->displayTableFooter=false;	//no display Footer 


$disallowed = array("delete");
if(isset($_GET['datagrid_action']) || isset($_POST['datagrid_action'])){
    $action = isset($_GET['datagrid_action'])?$_GET['datagrid_action']:$_POST['datagrid_action'];
    if(in_array($action,$disallowed)){
        //die("you are now allowed for this action");
    }
}



$table_info = $gridObj->getTableInfo($gridObj->tables);
$keystruct = $table_info[0];
//unset($keystruct[$gridObj->formPrimkey]);
$fields = array();
$display=array();
foreach(array_keys($keystruct) as $one){
        if($one){
		$fields[]="`$one`";
		$display[$one]=$one;
	}
}
/*
//start map
$display['name']='名字';
$display['memo']='备注';
$display['column1']='热量';
$display['column2']='蛋白质';
$display['column3']='脂肪';
$display['column4']='碳水化合物';
$display['column5']='膳食纤维';
$display['column6']='维生素A';
$display['column7']='维生素C';
$display['column8']='维生素E';
$display['column9']='胡萝卜素';
$display['column10']='维生素B1';
$display['column11']='维生素B2';
$display['column12']='烟酸';
$display['column13']='胆固醇';
$display['column14']='镁';
$display['column15']='钙';
$display['column16']='铁';
$display['column17']='锌';
$display['column18']='铜';
$display['column19']='锰';
$display['column20']='钾';
$display['column21']='磷';
$display['column22']='钠';
$display['column23']='硒';
//end map
*/

$display=array();
/*$display['project']='Project';
$display['task']='Task';
$display['person']='Person';
$display['detail']='Detail';
$display['start_at']='Start Date';
$display['end_at']='End Date';
$display['hours']='Cost(Hour)';
$display['percent']='Progress';*/

$gridObj->fieldDisplays=$display;

//$gridObj->fields=array_keys($display);
$gridObj->fields=$fields;

$gridObj->title= $gridObj->tables."";
//$gridObj->searchFields=array("project"=>"Project",'task'=>'Task','person'=>'Person');
//$gridObj->searchFields=$table_info[0];
$gridObj->formTable=$gridObj->tables;
$gridObj->formFields=$display;
$gridHtml=$gridObj->display();



//second
/*
$viewObj=new Dataview();
$viewObj->sql="SELECT * FROM `customer` left join `user` on user_id=cus_userid";
$viewObj->fieldDisplays=array("cus_name"=>"Customer","user_name"=>"User","cus_pic"=>"Pictrue","cus_address"=>"Address","cus_phone"=>"Phone");
$viewHtml=$viewObj->display();
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
<title><?php echo $gridObj->title; ?></title>
<script type="text/javascript"> 
	if(getCookie('style_css')!=null){
		document.write('<link type="text/css" rel="stylesheet" href="css/'+getCookie('style_css')+'.css" />');
	}else{
		document.write('<link type="text/css" rel="stylesheet" href="css/bluedream.css" />');
	} 
	
	function SetCookie(name,value)
	{
	    var Days = 30;  
	    var exp  = new Date();    //new Date("December 31, 9998");
	    exp.setTime(exp.getTime() + Days*24*60*60*1000);
	    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
	function getCookie(name)
	{
	    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
	     if(arr != null) return unescape(arr[2]); return null;

	}
</script> 
 
 <body  >

<table      >
  <tr>
    <td><a href="?" >数据列表</a> / <a href="?datagrid_action=new" >Add</a>
 </td>
  </tr>
</table>
<hr>
<?php 
echo $gridHtml;
?>
<p><p>

<?php 
//echo $viewHtml;
?>
</body>
</html>
