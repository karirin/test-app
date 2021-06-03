<?php

function db_connect()
{
  $dsn = 'mysql:dbname=db;host=localhost;charset=utf8';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn,$user,$password);
  $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

function _debug( $data, $clear_log = false ) {
    $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
    if( $clear_log ){
      file_put_contents($uri_debug_file, print_r('', true));
    }
    file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
  }

class User
{
    public function __construct($user_id) {
      $this->id = $user_id;
    }
    $id=$this->id;

  }

//インスタンスの生成
$user = new User(0);

_debug($user->id);
?>