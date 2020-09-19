<?php
require_once('config.php');

  $comment_data = $_POST['comment_data'];

  // バリデーションOKならDB更新処理
  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "UPDATE mst_staff
            SET   profile = :comment_data,
            WHERE id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':comment_data' => $comment_data,
                         ':user_id' => $user_id));
    set_flash('sucsess','プロフィールを更新しました');
    echo json_encode('sucsess');
  } catch (\Exception $e) {
    debug('プロフィール更新失敗');
    set_flash('error',ERR_MSG1);
  }
}
