<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php
$current_user = get_user($_GET['user_id']);
$page_type = $_GET['type'];
?>
<div class="row">
<div class="col-4">
<?php
require_once('../function.php');
$page_type = $_GET['type'];
$current_user=get_user($_SESSION['user_id']);

switch ($page_type) {
  case 'all':
    $posts = get_posts($current_user['id'],'all',0);
  break;

  case 'main':
    $posts = get_posts($current_user['id'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($current_user['id'],'favorite',0);
  break;

  case 'follow':
    $users = get_users('follows',$current_user['id']);
  break;

  case 'follower':
    $users = get_users('followers',$current_user['id']);
    
  break;
}
?>

<div class="profile">
<div class="edit_profile_img">
<label>
<div class="fa-image_range">
<i class="far fa-image"></i>
</div>
<input type="file" name="image_name" id="edit_profile_img">
</label>
<img src="/user/image/<?= $current_user['image'] ?>" name="profile_image" class="editing_profile_img">
</div>
<img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
<h3 class="profile_name"><?= $current_user['name'] ?></h3>
<p class="comment"><?= $current_user['profile'] ?></p>
<input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
<div class="btn_flex">
<button class="btn btn-outline-primary profile_save" type="button">編集完了</button>
<button class="btn btn-outline-danger modal_close" type="button">キャンセル</button>
</div>
</div>
<button class="edit_btn" type="button" name="follow">プロフィール編集</button>


<div class="row profile_count">
<div class="col-4 offset-1">
<a href="usper_top.php?user_id=<?= $current_user['id'] ?>&type=main">投稿数<p><?= current(get_user_count('post',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $current_user['id'] ?>&type=favorites">お気に入り投稿<p><?= current(get_user_count('favorite',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $current_user['id'] ?>&type=follow">フォロー数<p><?= current(get_user_count('follow',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $current_user['id'] ?>&type=follower">フォロワー数<p><?= current(get_user_count('follower',$current_user['id'])) ?></p></a>
</div>
</div>
</div>

<div class="col-4">

<?php if($page_type === 'main'): ?>
  <h2><?= $current_user['name'] ?>さんの投稿</h2>
<?php elseif ($page_type === 'favorites'): ?>
  <h2>お気に入りの投稿</h2>
<?php elseif ($page_type === 'follow'): ?>
  <h2>フォローした人</h2>
<?php elseif ($page_type === 'follower'): ?>
  <h2>フォロワー</h2>
<?php endif; ?>

<?php
if(isset($posts)){
require_once('../post_list.php');
}else{
require_once('user_list.php');
}
?>
</div>
<div class="col-4">
  <h2>投稿</h2>
  <form method="post" action="../post/post_add_done.php" enctype="multipart/form-data">
  <textarea class="textarea form-control" placeholder="投稿内容を入力ください" name="text"></textarea>
  <div class="post_btn margin_top">
  <label>
  <i class="far fa-image"></i>
  <input type="file" name="image_name" class="myImage" accept="image/*" multiple>
  </label>
  <input type="submit" class="btn btn-outline-dark" value="OK">
  </div>
  </form>
</div>
</div>