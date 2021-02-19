<?php 
function dbConnect()
{
  $dsn = 'mysql:dbname=heroku_91d4d2da72d9c6e;host=us-cdbr-east-03.cleardb.com;charset=utf8';
  $user = 'b2eddc9d906427';
  $password = 'b7d1bed6';
  $option = array(

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );

  $dbh = new PDO($dsn, $user, $password, $option);
  return $dbh;
}
?>