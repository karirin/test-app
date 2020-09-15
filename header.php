<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['code'])) {
    $current_user = get_user($_SESSION['code']);
  }else{
    $current_user = 'guest';
  } 
if(isset($_SESSION['login'])==false)
{
    print'<a href="../staff_login/staff_login.php">ログイン</a>';
    print'<a href="../staff/staff_add.php">新規登録</a>';
}
else
{
    print'<a href="../staff/staff_list.php">ユーザー一覧</a>';
    print'<a href="../product/pro_list.php">投稿一覧</a>';
    print'<a href="../product/pro_add.php">投稿</a>';
    print'<a href="../staff_login/staff_logout.php">ログアウト</a>';
}
?>