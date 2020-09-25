<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<?php
require_once('config.php');

  if(isset($_POST)){
  
  $current_user = get_user($_SESSION['user_id']);
  $comment_data = $_POST['comment_data'];
  $user_id = $_POST['user_id'];

  $profile_user_id = $_POST['page_id'] ?: $current_user['id'];

  try {
    $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $sql = "UPDATE user
            SET profile = :comment_data
            WHERE id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':comment_data' => $comment_data,
                         ':user_id' => $user_id));
    set_flash('sucsess','プロフィールを更新しました');
    echo json_encode('sucsess');
  } catch (\Exception $e) {
    set_flash('error',ERR_MSG1);
  }
  }