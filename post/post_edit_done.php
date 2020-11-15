<?php 
require_once('../config.php'); 

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

$dsn = 'mysql:dbname=db;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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