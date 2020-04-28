<?php
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$serv->set([
    'worker_num' => 4,//worker进程数 cpu核数1-4倍
    'max_request' => 10000,
    'reactor_num' => 2,
    'open_cpu_affinity' => 1,
    'log_file' => '/data/log/swoole.log'
]);
//$fd客户端连接的唯一标示
//监听连接进入事件
//$reactor_id线程id
$serv->on('connect', function ($serv, $fd, $reactor_id) {
    echo "Client: {$reactor_id}-{$fd}-Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server:{$reactor_id}-{$fd} " . $data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();