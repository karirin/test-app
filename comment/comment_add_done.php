<?php
session_start();
@session_regenerate_id(true);

require_once('../db_connect.php');
require_once('../function.php');

if(isset($_SESSION['flash'])){
    $flash_messages = $_SESSION['flash']['message'];
    $flash_type = $_SESSION['flash']['type'];
    }
    unset($_SESSION['flash']);
  
  $error_messages = array();

try
{
  
$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
    
$comment_text=$_POST['text'];
$comment_image_name=$_FILES['image_name'];
if(!empty($_POST['comment_id']))
{
$comment_id=$_POST['comment_id'];
}
$user_id=$_SESSION['user_id'];
$post_id=$_POST['id'];

if($comment_text=='')
{
    set_flash('danger','コメントが空です');
    reload();
} 

if($comment_image_name['size']>0)
{
    if($comment_image_name['size']>1000000)
    {
        set_flash('danger','画像が大きすぎます');
        reload();
    }
    else
    {
        move_uploaded_file($comment_image_name['tmp_name'],'./image/'.$comment_image_name['name']);

    }
}

$comment_text=htmlspecialchars($comment_text,ENT_QUOTES,'UTF-8');
$user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

$dbh = dbConnect();
$sql = 'INSERT INTO comment(text,image,user_id,created_at,post_id,comment_id) VALUES (?,?,?,?,?,?)';
$stmt = $dbh -> prepare($sql);
$data[] = $comment_text;
$data[] = $comment_image_name['name'];
$data[] = $user_id;
$data[] = $date->format('Y-m-d H:i:s');
$data[] = $post_id;
if(!empty($comment_id))
{
$data[] = $comment_id;
} 
else 
{
$data[] = '';
}
$stmt -> execute($data);
$dbh = null;

set_flash('sucsess','コメントを追加しました');
reload();

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}
