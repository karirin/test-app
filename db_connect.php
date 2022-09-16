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
    $dsn = 'mysql:dbname=heroku_e2fdebc6d9c4e72;host=us-cdbr-east-06.cleardb.net;charset=utf8';
    $user = 'b1cb04accddbd8';
    $password = '62537c22';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  }
}