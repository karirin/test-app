<?php
require_once('header.php');
require('config.php');
require_once('function.php');

$current_user = get_user($_SESSION['staff_code']);

// post送信されていた場合
if(!empty($_POST['withdraw'])){
  change_delete_flg($current_user['code'],1);

 //セッション削除
  session_destroy();
  $_SESSION = array();
  header("Location:/staff_login/staff_top.php");
  exit();
}

require('head.php');
?>

<body>
      <form action="" method="post">
        <button class="btn red" name="withdraw" value="withdraw" type="submit">退会する</button>
      </form>

</body>