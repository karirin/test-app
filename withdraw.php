<?php
require_once('config.php');
// post送信されていた場合
if(!empty($_POST['withdraw'])){
    $dbh = dbConnect();
    $sql = 'DELETE user FROM user WHERE user.id=?';
    $stmt = $dbh -> prepare($sql);
    $data[] = $_SESSION['user_id'];
    $stmt -> execute($data);
    
    $dbh = null;

  // セッション削除
  session_destroy();
  $_SESSION = array();
  header("Location:/user_login/user_top.php");
  exit();
}
?>
<div class="modal_withdraw"></div>
<div class="withdraw_process">
    <h4 class="center">本当に退会しますか？</h4>

    <form action="#" method="post">
    <div class="withdraw_btn">
        <button class="btn btn-outline-danger" name="withdraw" value="withdraw" type="submit">退会する</button>
        <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
        </div>
    </form>

</div>