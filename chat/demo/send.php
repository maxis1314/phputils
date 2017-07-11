<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
<?php
//redis_key =  app_name + room_id + username
error_reporting(E_ERROR);
if($_POST['type']=='send'){
    $redis = new Redis();                   //redis����
    $redis->connect("localhost","6379"); //����redis������


    $send_info = array(
        "r_id" => 1,
        "user_name" => 'addd',
        "nick_name" => 'robot',
        "type" => 'message',
        "content" => $_POST['msg'],
        "time" => date("H:i:s")
    );
    $redis->publish($_POST['room'], json_encode($send_info)); //��34332���������˷�
    if($_POST['pid']){
        $redis->publish($_POST['room'].'-'.$_POST['pid'], json_encode($send_info));//��34332�����iyangyi��
    }
    echo "msg sent";
}elseif($_POST['type']=='show'){
    $redis = new Redis();                   //redis����
    $redis->connect("localhost","6379"); //����redis������
    $a = $redis->zRange('chat:room:123:online_list', 0, 1000);
    var_dump($a);
    
}elseif($_POST['type']=='clear'){
    $redis = new Redis();                   //redis����
    $redis->connect("localhost","6379"); //����redis������
    $a = $redis->zDeleteRangeByRank('chat:room:123:online_list', 0, 1000);
    var_dump($a);
    
}elseif($_POST['type']=='refresh'){
    $redis = new Redis();                   //redis����
    $redis->connect("localhost","6379"); //����redis������
    $send_info = array(
        "r_id" => 1,
        "user_name" => 'addd',
        "nick_name" => 'robot',
        "type" => 'refresh',
        "content" => 'refresh',
        "time" => date("H:i:s")
    );
    $redis->publish($_POST['room'], json_encode($send_info)); 
    
}



?>

<form method=post>
<input type=hidden name=type value='send'>
ROOM:<input type=text name=room value='chat-123'>
PID:<input type=text name=pid>
MSG:<input type=text name=msg>
<input type=submit>
</form>
<form method=post>
<input type=hidden name=type value='show'>
<input type=submit value=show>
</form>
<form method=post>
<input type=hidden name=type value='clear'>
<input type=submit value=clear>
</form>
<form method=post>
ROOM:<input type=text name=room value='chat-123'>
<input type=hidden name=type value='refresh'>
<input type=submit value=refresh>
</form>