<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>

<body>

<div class="row wide_disp">
<div class="col-4">
<?php
$page_type = $_GET['type'];
$page_id = $_GET['page_id'];

if($page_id=='current_user'){
  $current_user=get_user($_SESSION['user_id']);
}else{
  $current_user=get_user($page_id);
}

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
<form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
<div class="edit_profile_img">
<label>
<div class="fa-image_range">
<i class="far fa-image"></i>
</div>
<input type="file" name="image_name" id="edit_profile_img" accept="image/*" multiple>
</label>
<img name="profile_image" class="editing_profile_img" src="/user/image/<?= $current_user['image'] ?>">
<label>
  <i class="far fa-times-circle profile_clear"></i>
  <input type="button" id="profile_clear">
</label>
</div>
<img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
<h3 class="profile_name"><?= $current_user['name'] ?></h3>
<p class="comment"><?= $current_user['profile'] ?></p>
<input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
<input type="file" name="image" class="image" value="<?= $current_user['image'] ?>" style="display:none;">
<div class="btn_flex">
<input type="submit" class="btn btn-outline-primary" value="編集完了">
<button class="btn btn-outline-danger modal_close" type="button">キャンセル</button>
</div>
</form>
</div>

<?php
$post_count = get_user_count('post',$current_user['id']);
$favorite_count = get_user_count('favorite',$current_user['id']);
$follow_count = get_user_count('follow',$current_user['id']);
$follower_count = get_user_count('follower',$current_user['id']);
?>

<div class="row profile_count">
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=main">投稿数<p><?= current(get_user_count('post',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=favorites">お気に入り投稿<p><?= current(get_user_count('favorite',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follow">フォロー数<p><?= current(get_user_count('follow',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follower">フォロワー数<p><?= current(get_user_count('follower',$current_user['id'])) ?></p></a>
</div>
</div>
<?php if($current_user==get_user($_SESSION['user_id'])):?>
<button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
<?php endif;?>

</div>

<div class="col-4">

<?php if($page_type === 'main'): ?>
  <h2 class="left"><?= $current_user['name'] ?>さんの投稿</h2>
<?php elseif ($page_type === 'favorites'): ?>
  <h2 class="left">お気に入りの投稿</h2>
<?php elseif ($page_type === 'follow'): ?>
  <h2 class="left">フォローした人</h2>
<?php elseif ($page_type === 'follower'): ?>
  <h2 class="left">フォロワー</h2>
<?php endif; ?>

<?php
if(isset($posts)){
require('../post_list.php');
}else{
require('user_list.php');
}
?>
</div>
<div class="col-4">
<div class="col-10 offset-1">
  <h2 class="left">投稿</h2>
  <form method="post" action="../post/post_add_done.php" enctype="multipart/form-data">
  <textarea id="post_counter" class="textarea form-control" placeholder="投稿内容を入力ください" name="text"></textarea>
  <div class="counter">
                <span class="post_count">0</span><span>/300</span>
  </div>
  <div class="post_btn margin_top">
  <label>
  <i class="far fa-image"></i>
  <input type="file" name="image_name" id="my_image" accept="image/*" multiple>
</label>
  <input type="submit" class="btn btn-outline-dark" value="OK">
  </div>
  <label>
  <i class="far fa-times-circle my_clear"></i>
  <input type="button" id="my_clear">
  </label>
  <p class="preview_img"><img class="my_preview"></p>
  </form>
</div>
</div>
</div>

<div class="row narrow_disp">
<div class="col-6 center">
<?php
$page_type = $_GET['type'];
$page_id = $_GET['page_id'];

if($page_id=='current_user'){
  $current_user=get_user($_SESSION['user_id']);
}else{
  $current_user=get_user($page_id);
}

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
<form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
<div class="edit_profile_img">
<label>
<div class="fa-image_range">
<i class="far fa-image"></i>
</div>
<input type="file" name="image_name" id="edit_profile_img" accept="image/*" multiple>
</label>
<img name="profile_image" class="editing_profile_img" src="/user/image/<?= $current_user['image'] ?>">
<label>
  <i class="far fa-times-circle profile_clear"></i>
  <input type="button" id="profile_clear">
</label>
</div>
<img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
<h3 class="profile_name"><?= $current_user['name'] ?></h3>
<p class="comment"><?= $current_user['profile'] ?></p>
<input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
<input type="file" name="image" class="image" value="<?= $current_user['image'] ?>" style="display:none;">
<div class="btn_flex">
<input type="submit" class="btn btn-outline-primary" value="編集完了">
<button class="btn btn-outline-danger modal_close" type="button">キャンセル</button>
</div>
</form>
</div>

<?php
$post_count = get_user_count('post',$current_user['id']);
$favorite_count = get_user_count('favorite',$current_user['id']);
$follow_count = get_user_count('follow',$current_user['id']);
$follower_count = get_user_count('follower',$current_user['id']);
?>

<div class="row profile_count">
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=main">投稿数<p><?= current(get_user_count('post',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=favorites">お気に入り投稿<p><?= current(get_user_count('favorite',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follow">フォロー数<p><?= current(get_user_count('follow',$current_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follower">フォロワー数<p><?= current(get_user_count('follower',$current_user['id'])) ?></p></a>
</div>
</div>
<?php if($current_user==get_user($_SESSION['user_id'])):?>
<button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
<?php endif;?>

</div>

<div class="col-6">

<?php if($page_type === 'main'): ?>
  <h2 class="left"><?= $current_user['name'] ?>さんの投稿</h2>
<?php elseif ($page_type === 'favorites'): ?>
  <h2 class="left">お気に入りの投稿</h2>
<?php elseif ($page_type === 'follow'): ?>
  <h2 class="left">フォローした人</h2>
<?php elseif ($page_type === 'follower'): ?>
  <h2 class="left">フォロワー</h2>
<?php endif; ?>

<?php
if(isset($posts)){
require('../post_list.php');
}else{
require('user_list.php');
}
?>
</div>
</div>
  <?php require_once('../footer.php'); ?>