<?php
if (!empty($_POST['search_user'])){
    $hoge = $_POST['search_input'];
    header("Location:user_list.php?type=search&query=${hoge}");
  }
session_start();
session_regenerate_id(true);
?>
<?php require_once('../head.php'); ?>
<body>
<?php require_once('../function.php'); ?>
<?php
print '<a href="user_list.php?type=all">ユーザー一覧<br/><br/></a>';

print'<form method="post" action="#" class="search_container">';
print'<input type="text" name="search_input" placeholder="ユーザー検索">';
print'<input type="submit" name="search_user" value="&#xf002;">';
print'</form>';

$page_type = $_GET['type'];

switch ($page_type) {
    case 'all';
    $users = get_users('all','');
    break;

    case 'search':
    $users = get_users('search',$_GET['query']);
    break;
  }
 


foreach((array)$users as $user): 

 print'<br />';
 print '<a href="../user/user_disp.php?user_id='.$user['id'].'">'.$user['name'].'</a>'; 

endforeach
?>

<br />
<?php
print'<a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=main">トップメニューへ</a><br />';
?>
</body>
