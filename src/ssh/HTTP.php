<?php

$host   = "127.0.0.4";
$port   = "80";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_connect($socket, $host, $port) or die('connect failed');
//post 数据
$body = "a=1&b=2";
// 请求行
$header = "POST / HTTP/1.1\r\n";

/*请求头*/
$header .= "Host:127.0.0.4\r\n";
// 设置请求body的类型
$header .= "Content-Type: application/x-www-form-urlencoded \r\n"; //
$header .= "Connection: keep-alive\r\n";
$header .= "Content-Length:" . strlen($body) . "\r\n";
$header .= "\r\n"; //空行
//HTTP body
$header .= $body;
$out = '';
if (!socket_write($socket, $header, strlen($header))) {
    echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
} else {
    echo "发送HTTP请求的内容为:\r\n";
    echo $header;
    echo "\r\nHTTP请求结束\r\n\r\n\r\n";
}

while ($out = socket_read($socket, 8192)) {
    echo "HTTP Response相应的内容为:\r\n";
    echo $out;
}

echo "关闭SOCKET...\r\n";
socket_close($socket);
echo "关闭OK\r\n";
