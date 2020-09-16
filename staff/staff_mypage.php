<?php require_once('../function.php'); ?>

<?php
$page_type = $_GET['type'];

switch ($page_type) {
  case 'main':
    $posts = get_posts($_SESSION['staff_code'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($_SESSION['staff_code'],'favorite',0);
  break;
}

?>

<?php if($page_type === 'main' || $page_type === 'favorites' ) require_once('../post_list.php') ?>