<?php
$host   = "127.0.0.1";
$port   = "12000";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, $host, $port);
socket_listen($socket);
$count = 0;
//阻塞

do {
    if (($msgsock = socket_accept($socket)) < 0) {
        echo socket_strerror($msgsock) . "\n";
        break;
    } else {
        //发到客户端
        $msg = "测试成功！\n";
        socket_write($msgsock, $msg, strlen($msg));
        echo "测试成功了啊\n";
        $buf      = socket_read($msgsock, 8192);
        $talkback = "收到的信息:$buf\n";
        echo $talkback;
        if (++$count >= 5) {
            break;
        }
        ;

    }
    //echo $buf;
    socket_close($msgsock);

} while (true);
socket_close($sock);
