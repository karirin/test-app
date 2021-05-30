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
$post_id = $_POST['id'];
$post_text = $_POST['text'];
$post_image_name_old = $_POST['image_name_old'];
$post_image_name = $_FILES['image_name'];

if($post_text=='')
{
    set_flash('danger','投稿内容が未記入です');
    reload();
}

if($post_image_name['size']>0)
{
    if($post_image_name['size']>1000000)
    {
        set_flash('danger','画像が大きすぎます');
        reload();
    }
    else
    {
        move_uploaded_file($post_image_name['tmp_name'],'./image/'.$post_image_name['name']);

    }
}

$post_text=htmlspecialchars($post_text,ENT_QUOTES,'UTF-8');
$post_id=htmlspecialchars($post_id,ENT_QUOTES,'UTF-8');

$dbh = db_connect();
$sql = 'UPDATE post SET text=?,image=? WHERE id=?';
$stmt = $dbh -> prepare($sql);
$data[] = $post_text;
$data[] = $post_image_name['name'];
$data[] = $post_id;
$stmt -> execute($data);

$dbh = null;

if($post_image_name_old!='' && $post_image_name_old!=$post_image_name['name'])
{
    unlink('./image/'.$post_image_name_old);
}
}
catch (Exception $e)
{
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

set_flash('sucsess','更新しました');
reload();

require_once('../footer.php');
?>