<?php require_once('../function.php'); ?>

<?php
$page_type = $_GET['type'];
print'<a href="staff_top.php?type=main">自分の投稿</a>';
print'<a href="staff_top.php?type=favorites">いいねした投稿</a>';

$current_user=get_user($_SESSION['staff_code']);

switch ($page_type) {
  case 'main':
    $posts = get_posts($current_user['code'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($current_user['code'],'favorite',0);
    break;
}


//お気に入りの投稿が見れない
?>

<?php if($page_type === 'main' || $page_type === 'favorites' ) require_once('../post_list.php') ?>

<?php print'<br />'.$current_user['name'].'';?>