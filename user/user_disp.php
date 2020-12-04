<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php
$current_user=get_user($_GET['user_id']);
$profile_user = get_user($_GET['page_id']);
$page_type = $_GET['type'];
?>
<div class="row">
<div class="col-4">
<?php
switch ($page_type) {
  case 'all':
    $posts = get_posts($profile_user['id'],'all',0);
  break;

  case 'main':
    $posts = get_posts($profile_user['id'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($profile_user['id'],'favorite',0);
  break;

  case 'follow':
    $users = get_users('follows',$profile_user['id']);
  break;

  case 'follower':
    $users = get_users('followers',$profile_user['id']);
    
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
<img name="profile_image" class="editing_profile_img">
</div>
<img src="/user/image/<?= $profile_user['image'] ?>" class="mypage">
<h3 class="profile_name"><?= $profile_user['name'] ?></h3>
<p class="comment"><?= $profile_user['profile'] ?></p>
<input type="hidden" name="id" class="user_id" value="<?= $profile_user['id'] ?>">
<div class="btn_flex">
<button class="btn btn-outline-primary profile_save" type="button">編集完了</button>
<button class="btn btn-outline-danger modal_close" type="button">キャンセル</button>
</div>
</div>
<?php if($current_user == $profile_user):?>
<button class="edit_btn" type="button" name="follow">プロフィール編集</button>
<?php endif; ?>

<div class="row profile_count">
<div class="col-4 offset-1">
<a href="usper_top.php?user_id=<?= $profile_user['id'] ?>&type=main">投稿数<p><?= current(get_user_count('post',$profile_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $profile_user['id'] ?>&type=favorites">お気に入り投稿<p><?= current(get_user_count('favorite',$profile_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $profile_user['id'] ?>&type=follow">フォロー数<p><?= current(get_user_count('follow',$profile_user['id'])) ?></p></a>
</div>
<div class="col-4 offset-1">
<a href="user_top.php?user_id=<?= $profile_user['id'] ?>&type=follower">フォロワー数<p><?= current(get_user_count('follower',$profile_user['id'])) ?></p></a>
</div>
</div>
<?php if($current_user != $profile_user): ?>
<form action="#" method="post">
          <input type="hidden" class="current_user_id" value="<?= $current_user['id'] ?>">
          <input type="hidden" name="follow_user_id" value="<?= $profile_user['id'] ?>">
          <?php if (check_follow($current_user['id'],$profile_user['id'])): ?>
          <button class="follow_btn border_white btn following" type="button" name="follow">フォロー中</button>
          <?php else: ?>
          <button class="follow_btn border_white btn" type="button" name="follow">フォロー</button>
          <?php endif; ?>
</form>
<?php endif; ?>
</div>

<div class="col-4">

<?php if($page_type === 'main'): ?>
  <h2><?= $profile_user['name'] ?>さんの投稿</h2>
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
<div class="col-10 offset-1">
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
</div>
<?php require_once('../footer.php'); ?>