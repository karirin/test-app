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
    $users = current(current(get_users('follows',$current_user['id'])));
  break;

  case 'follower':
    $users = current(current(get_users('followers',$current_user['id'])));
    
  break;
}

print'<img src="/user/image/'.$current_user['image'].'" class="mypage">';
print '<p>'.$current_user['name'].'</p>';
print '<div>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=main">投稿数：'.current(get_user_count('post',$current_user['id'])).'</a>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=favorites">お気に入り投稿：'.current(get_user_count('favorite',$current_user['id'])).'</a>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=follow">フォロー数：'.current(get_user_count('follow',$current_user['id'])).'</a>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=follower">フォロワー数：'.current(get_user_count('follower',$current_user['id'])).'</a>';
print '</div>';
?>

<button class="edit_btn" type="button" name="follow">プロフィール編集</button>
<div class="comment">
<p class="profile_comment"></p>
<div class="btn_flex">
<button class="btn profile_save" type="button">編集完了</button>
<button class="btn modal_close" type="button">キャンセル</button>
</div>

</div>
<?php print'<br />'.$current_user['profile'].'';?>
</div>

<div class="col-8">

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
</div>