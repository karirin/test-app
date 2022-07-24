<?php
require_once('../config_2.php');

try {

    $date = new DateTime();
    $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

    $post_text = $_POST['text'];
    $post_image_name = $_FILES['image_name'];
    $user_id = $_SESSION['user_id'];


    if ($post_text == '') {
        set_flash('danger', '投稿内容が未記入です');
        reload();
    }

    image_check($post_image_name);

    $post_text = htmlspecialchars($post_text, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

    $dbh = db_connect();
    $sql = 'INSERT INTO post(text,image,user_id,created_at) VALUES (?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $post_text;
    $data[] = $post_image_name['name'];
    $data[] = $user_id;
    $data[] = $date->format('Y-m-d H:i:s');
    $stmt->execute($data);
    $dbh = null;

    set_flash('sucsess', '投稿しました');
    header('Location:../user_login/user_top.php?type=main&page_id=current_user');
} catch (Exception $e) {
    error_log($e, 3, "../../php/error.log");
    _debug('投稿失敗しました');
    exit();
}

?>

<a href="post_index.php">戻る</a>