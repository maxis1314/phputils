<?php
//redis_key =  app_name + room_id + username

$redis = new Redis();                   //redis����
$redis->connect("localhost","6379"); //����redis������
     
$send_info = array(
    "r_id" => 1,
    "user_name" => 'addd',
    "nick_name" => 'robot',
    "type" => 'message',
    "content" => 'caodan',
    "time" => date("H:i:s")
);
$redis->publish('chat-123', json_encode($send_info)); //��34332���������˷�
$redis->publish('chat-123-298', json_encode($send_info));//��34332�����iyangyi��


echo "msg sent";