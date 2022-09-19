<?php
require_once('../config_2.php');

try {

    $date = new DateTime();
    $date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

    $test_text = $_POST['text'];
    $test_priority = $_POST['priority'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];


    if ($test_text == '') {
        set_flash('danger', '投稿内容が未記入です');
        //reload();
    }

    $test_text = htmlspecialchars($test_text, ENT_QUOTES, 'UTF-8');
    $user_id = htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8');

    $dbh = db_connect();
    $sql = 'INSERT INTO test(text,priority,progress,post_id,user_id,created_at) VALUES (?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $test_text;
    $data[] = $test_priority;
    $data[] = '未実施';
    $data[] = $post_id;
    $data[] = $user_id;
    $data[] = $date->format('Y-m-d H:i:s');
    $stmt->execute($data);
    $dbh = null;

    set_flash('sucsess', '投稿しました');
    header('Location:../test/test_disp.php?post_id=' . $post_id . '&user_id=' . $user_id);
} catch (Exception $e) {
    error_log($e, 3, "../../php/error.log");
    _debug('投稿失敗しました');
    exit();
}

?>

<a href="post_index.php">戻る</a>