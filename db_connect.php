<?php
function db_connect()
{
  if ($_SERVER["HTTP_HOST"] == "localhost") {
    $dsn = 'mysql:dbname=test;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  } else {
    $dsn = 'mysql:dbname=heroku_d33dd522762d436;host=us-cdbr-east-06.cleardb.net;charset=utf8';
    $user = 'b887ae3d903441';
    $password = 'f44fbd74';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  }
}