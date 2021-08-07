<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use htdocs\Chat;

require_once 'C:\xampp\htdocs\vendor\autoload.php';

$server = IoServer::factory(new HttpServer(new WsServer(new Chat())), 8080);
$server->run();