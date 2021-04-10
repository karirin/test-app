<?php
require_once('../config.php'); 

try
{

$date = new DateTime();
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));
    
$post_text=$_POST['text'];
$post_image_name=$_FILES['image_name'];
$user_id=$_SESSION['user_id'];


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
$user_id=htmlspecialchars($user_id,ENT_QUOTES,'UTF-8');

$dbh = dbConnect();
$sql = 'INSERT INTO post(text,image,user_id,created_at) VALUES (?,?,?,?)';
$stmt = $dbh -> prepare($sql);
$data[] = $post_text;
$data[] = $post_image_name['name'];
$data[] = $user_id;
$data[] = $date->format('Y-m-d H:i:s');
$stmt -> execute($data);
$dbh = null;

set_flash('sucsess','投稿しました');
header('Location:../user_login/user_top.php?type=main&page_id=current_user');

}   
catch (Exception $e)
{
print'ただいま障害により大変ご迷惑をお掛けしております。';
exit();
}

?>

<a href="post_index.php">戻る</a>