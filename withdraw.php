<?php
require_once('config.php');
$current_user = get_user($_SESSION['user_id']);

// post送信されていた場合
if(!empty($_POST['withdraw'])){
  change_delete_flg($current_user['id'],1);

 //セッション削除
  session_destroy();
  $_SESSION = array();
  header("Location:/user_login/user_top.php");
  exit();
}
?>

<body>
    <form action="#" method="post">
        <button class="btn red" name="withdraw" value="withdraw" type="submit">退会する</button>
    </form>

</body>
<?php require_once('footer.php'); ?>