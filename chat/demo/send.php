<?php
//redis_key =  app_name + room_id + username

$send_info = array(
    "game_name" => $room_info['game_name'],
    "username" => $room_info['username'],
    "type" => 'begin_live', #����
    "time" => date("H:i:s")
);
$this->redis->publish('chat-34332', json_encode($send_info)); //��34332���������˷�
$this->redis->publish('chat-34332-iyangyi', json_encode($send_info));��34332�����iyangyi��