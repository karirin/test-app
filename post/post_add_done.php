<?php
require_once('../config_2.php');

try {

    $date = new DateTime();
    $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

    $post_url = $_POST['url'];
    $app_format = $_POST['app_format'];
    $service = $_POST['service'];
    $test_request = $_POST['test_request'];
    $user_id = $_SESSION['user_id'];
    if (!empty($_FILES['image_name']['tmp_name'])) {
        $post_image = base64_encode(file_get_contents($_FILES['image_name']['tmp_name']));
    } else {
        $post_image = '';
    }

    $post_text = htmlspecialchars($post_text, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

    $dbh = db_connect();
    $sql = 'INSERT INTO post(url,image,app_format,service,test_request,user_id,created_at) VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $post_url;
    $data[] = $post_image;
    $data[] = $app_format;
    $data[] = $service;
    $data[] = $test_request;
    $data[] = $user_id;
    $data[] = $date->format('Y-m-d H:i:s');
    $stmt->execute($data);
    $dbh = null;

    set_flash('sucsess', '投稿しました');
    header('Location:../index.php?type=main&page_id=current_user&page_type=all');
} catch (Exception $e) {
    //error_log($e, 3, "../../php/error.log");
    _debug('投稿失敗しました');
    exit();
}

?>

<a href="post_index.php">戻る</a>