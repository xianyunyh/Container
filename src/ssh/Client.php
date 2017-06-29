<?php
$host   = "127.0.0.1";
$port   = "12000";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, $host, $port) or die('connect failed');

$data = "hello \r\n";

if (false !== socket_write($socket, $data, strlen($data))) {
    while ($out = socket_read($socket, 1024)) {
        echo "接受的内容为:", $out;
    }
}

socket_close($socket);
