<?php
session_start();
session_regenerate_id(true);
require('config.php');

$current_user = get_user($_SESSION['staff_code']);

// post送信されていた場合
if(!empty($_POST['withdraw'])){
  change_delete_flg($current_user,1);

 //セッション削除
  session_destroy();
  $_SESSION = array();
  header("Location:login_form.php");
  exit();
}

require('head.php');
?>

<body>
  <?php require('header.php'); ?>

      <form action="" method="post">
        <button class="btn red" name="withdraw" value="withdraw" type="submit">退会する</button>
      </form>

