<?php
//redis_key =  app_name + room_id + username

$send_info = array(
    "r_id" => 1,
    "user_name" => 'addd',
    "type" => 'public_message', #����
    "time" => date("H:i:s")
);
$this->redis->publish('chat-123', json_encode($send_info)); //��34332���������˷�
//$this->redis->publish('chat-34332-iyangyi', json_encode($send_info));��34332�����iyangyi��