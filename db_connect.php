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
    $dsn = 'mysql:dbname=heroku_ac4c0431a893f79;host=us-cdbr-east-06.cleardb.net;charset=utf8';
    $user = 'bbd6112b286a22';
    $password = 'd468d50c';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  }
}