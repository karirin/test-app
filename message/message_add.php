<?php
require_once('../config.php');
require_once('../function.php');
try {

    $date = new DateTime();
    $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

    $message_text = $_POST['text'];
    $message_image = $_FILES['image'];
    $user_id = $_SESSION['user_id'];
    $destination_user_id = $_POST['destination_user_id'];

    if ($message_text == '') {
        if ($message_image['name'] == '') {
            set_flash('danger', 'メッセージ内容が未記入です');
            reload();
        }
    }

    if ($message_image['size'] > 0) {
        if ($message_image['size'] > 1000000) {
            set_flash('danger', '画像が大きすぎます');
            reload();
        } else {
            move_uploaded_file($message_image['tmp_name'], './image/' . $message_image['name']);
        }
    }

    $message_text = htmlspecialchars($message_text, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

    $dsn = 'mysql:dbname=db;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'INSERT INTO message(text,image,user_id,destination_user_id,created_at) VALUES (?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $message_text;
    $data[] = $message_image['name'];
    $data[] = $user_id;
    $data[] = $destination_user_id;
    $data[] = $date->format('Y-m-d H:i:s');
    $stmt->execute($data);
    $dbh = null;

    if (!check_relation_message($user_id, $destination_user_id)) {
        insert_message($user_id, $destination_user_id);
    }
    //_debug('$sql');
    insert_message_count($user_id,$destination_user_id);
    set_flash('sucsess', 'メッセージを送信しました');
    header('Location:../message/message.php?user_id=' . $destination_user_id . '');
} catch (Exception $e) {
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

<a href="post_index.php">戻る</a>