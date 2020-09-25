<?php
require_once('../config.php'); 
require_once('../header.php');
require_once('../head.php'); ?>
<body>

<?php

try
{
    
$post_name=$_POST['name'];
$post_address=$_POST['address'];
$post_time_start=$_POST['time_start'];
$post_time_end=$_POST['time_end'];
$post_gazou_name=$_POST['gazou_name'];
$user_id=$_SESSION['user_id'];

$post_name=htmlspecialchars($post_name,ENT_QUOTES,'UTF-8');
$post_address=htmlspecialchars($post_address,ENT_QUOTES,'UTF-8');
$post_time_start=htmlspecialchars($post_time_start,ENT_QUOTES,'UTF-8');
$post_time_end=htmlspecialchars($post_time_end,ENT_QUOTES,'UTF-8');
$user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO post(name,address,time_start,time_end,gazou,user_id) VALUES (?,?,?,?,?,?)';
$stmt = $dbh -> prepare($sql);
$data[] = $post_name;
$data[] = $post_address;
$data[] = $post_time_start;
$data[] = $post_time_end;
$data[] = $post_gazou_name;
$data[] = $user_id;
$stmt -> execute($data);

$dbh = null;

print 'カフェを追加しました。<br />';

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

<a href="post_list.php">戻る</a>
</body>
</html>