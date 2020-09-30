<?php
require_once('../config.php'); 
?>
<?php

try
{
    
$post_text=$_POST['text'];
$post_gazou_name=$_POST['gazou_name'];
$user_id=$_SESSION['user_id'];

$post_text=htmlspecialchars($post_text,ENT_QUOTES,'UTF-8');
$user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'INSERT INTO post(text,gazou,user_id) VALUES (?,?,?)';
$stmt = $dbh -> prepare($sql);
$data[] = $post_text;
$data[] = $post_gazou_name;
$data[] = $user_id;

$stmt -> execute($data);

$dbh = null;

header('Location:post_index.php');

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

<a href="post_index.php">戻る</a>
