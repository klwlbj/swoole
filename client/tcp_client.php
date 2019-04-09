<?php
//连接swoole tcp 服务
$client= new swoole_client(SWOOLE_SOCK_TCP);
if(!$client->connect('127.0.0.1',9501)){
    echo'fail';
    exit;
}

//php cli常量
fwrite(STDOUT,'please print:');
$msg = trim(fgets(STDOUT));
//发送给tcp server
$client->send($msg);
//接收来自server的数据
$result= $client->recv();
echo $result;