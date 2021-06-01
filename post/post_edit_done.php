<?php 
require_once('../config_2.php');

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

image_check($post_image_name);

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