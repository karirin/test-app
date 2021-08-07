<?php
session_start();
@session_regenerate_id(true);

require_once('../db_connect.php');
require_once('../function.php');

if (isset($_SESSION['flash'])) {
    $flash_messages = $_SESSION['flash']['message'];
    $flash_type = $_SESSION['flash']['type'];
}
unset($_SESSION['flash']);

$error_messages = array();

try {

    $date = new DateTime();
    $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

    $chat_text = $_POST['text'];
    $chat_image = $_FILES['image'];
    $user_id = $_SESSION['user_id'];
    $destination_user_id = $_POST['destination_user_id'];

    if ($chat_text == '') {
        if ($chat_image['name'] == '') {
            set_flash('danger', 'メッセージ内容が未記入です');
            reload();
        }
    }

    if ($chat_image['size'] > 0) {
        if ($chat_image['size'] > 1000000) {
            set_flash('danger', '画像が大きすぎます');
            reload();
        } else {
            move_uploaded_file($chat_image['tmp_name'], './image/' . $chat_image['name']);
        }
    }

    $chat_text = htmlspecialchars($chat_text, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

    $dbh = db_connect();
    $sql = 'INSERT INTO chat(text,image,user_id,created_at) VALUES (?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $chat_text;
    $data[] = $chat_image['name'];
    $data[] = $user_id;
    $data[] = $date->format('Y-m-d H:i:s');
    $stmt->execute($data);
    $dbh = null;

    set_flash('sucsess', '送信しました');
    reload();
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

<a href="post_index.php">戻る</a>