<?php require_once('../function.php'); ?>

<!-- <div class="count_label">お気に入り</div>
<span class="count_num"><?= current(get_user_count('favorite',$_SESSION['staff_code'])) ?></span> -->

<?php
$page_type = $_GET['type'];

switch ($page_type) {
  case 'main':
    $posts = get_posts($page_user['id'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($page_user['id'],'favorite',0);
  break;
}

if($page_type === 'main' || $page_type === 'favorites' )
require_once('post_list.php')

?>