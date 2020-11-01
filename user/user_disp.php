<?php 
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php
$current_user = get_user($_GET['user_id']);
$profile_user = get_user($_GET['page_id']);
$page_type = $_GET['type'];
?>
<div class="row">
<div class="col-4">
<?php
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

print'<img src="/user/image/'.$current_user['image'].'" class="mypage">';
print '<h2>'.$current_user['name'].'</h2>';
print '<table>';
print '<tbody>';
print '<tr>';
print '<td>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=main">投稿数<p>'.current(get_user_count('post',$current_user['id'])).'</p></a>';
print '</td>';
print '<td>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=favorites">お気に入り投稿<p>'.current(get_user_count('favorite',$current_user['id'])).'</p></a>';
print '</td>';
print '</tr>';
print '<tr>';
print '<td>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=follow">フォロー数<p>'.current(get_user_count('follow',$current_user['id'])).'</p></a>';
print '</td>';
print '<td>';
print'<a href="user_top.php?user_id='.$current_user['id'].'&type=follower">フォロワー数<p>'.current(get_user_count('follower',$current_user['id'])).'</p></a>';
print '</td>';
print '</tr>';
print '</tbody>';
print '</table>';
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
  <h2>投稿する</h2>
  <form method="post" action="../post/post_add_done.php" enctype="multipart/form-data">
　投稿内容を入力ください。<br />
  <input type="text" name="text" style="width:200px"><br />
  画像を選んでください。<br />
  <input type="file" name="gazou_name" style="width:200px"><br />
  <br />
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
  </form>
</div>
</div>
</body>
<?php require_once('../footer.php'); ?>
</html>

<form action="#" method="post">
          <input type="hidden" class="current_user_id" value="<?= $current_user['id'] ?>">
          <input type="hidden" name="follow_user_id" value="<?= $user_id ?>">
          <!-- フォロー中か確認してボタンを変える -->
          <?php if (check_follow($current_user['id'],$user_id)): ?>
            <button class="follow_btn border_white btn following" type="button" name="follow">フォロー中</button>
          <?php else: ?>
            <button class="follow_btn border_white btn" type="button" name="follow">フォロー</button>
          <?php endif; ?>
</form>