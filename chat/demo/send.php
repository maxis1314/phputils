<?php
//redis_key =  app_name + room_id + username

$redis = new Redis();                   //redis对象
$redis->connect("localhost","6379"); //连接redis服务器
     
$send_info = array(
    "r_id" => 1,
    "user_name" => 'addd',
    "nick_name" => 'robot',
    "type" => 'message',
    "content" => 'caodan',
    "time" => date("H:i:s")
);
$redis->publish('chat-123', json_encode($send_info)); //向34332房间所有人发
$redis->publish('chat-123-298', json_encode($send_info));//向34332房间的iyangyi发


echo "msg sent";