<?php
if (!empty($_POST['search_user'])){
    $hoge = $_POST['search_input'];
    header("Location:user_list.php?type=search&query=${hoge}");
  }
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../function.php');
require_once('../post_process.php');
?>
<body>
<?php
print'<div class="col-8 offset-2">';
if(basename($_SERVER['PHP_SELF']) === 'user_list.php'){
print '<a href="user_list.php?type=all">ユーザー一覧<br/><br/></a>';
}
print'<form method="post" action="#" class="search_container">';
print'<input type="text" name="search_input" placeholder="ユーザー検索">';
print'<input type="submit" name="search_user">';
print'</form>';

$page_type = $_GET['type'];
$current_user = get_user($_SESSION['user_id']);

switch ($page_type) {
    case 'all';
    $users = get_users('all','');
    break;

    case 'search':
    $users = get_users('search',$_GET['query']);
    break;
  }

foreach((array)$users as $user):
  _debug($user);
  _debug($users);
$user = current($user);
$user = get_user($user);
print'<a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$user['id'].'&type=main" class="user_link">';
print'<div class="user">';
print'<div class="user_info">';
if(!empty($user['image'])):
print'<img src="/user/image/'.$user['image'].'">';
endif;
print'<div class="user_name">';
print''.$user['name'].'';
print'</div>';
print'</div>';
print'<div class="user_profile">';
print''.$user['profile'].'';
print'</div>';
print'<div class="direct_message">';
print'<a href="../message/message.php?user_id='.$user['id'].'">DM</a>';
print'</div>';
print'</div>';
print'</a>';
endforeach
?>

<br />
<?php
print'<a href="../user_login/user_top.php?user_id='.$_SESSION['user_id'].'&type=main">トップメニューへ</a><br />';
print'</div>';
?>

</body>
<?php require_once('../footer.php'); ?>
