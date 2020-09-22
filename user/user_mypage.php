<script src=" https://id.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<?php require_once('../function.php'); ?>
<?php
$page_type = $_GET['type'];

print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=main">自分の投稿</a>';
print'<a href="user_top.php?user_id='.$_SESSION['user_id'].'&type=favorites">いいねした投稿</a>';

$current_user=get_user($_SESSION['user_id']);

switch ($page_type) {
  case 'main':
    $posts = get_posts($current_user['id'],'my_post',0);
  break;

  case 'favorites':
    $posts = get_posts($current_user['id'],'favorite',0);
  break;
}

?>

<?php  require_once('../post_list.php') ?>
<br /><br />
<?php print'<br />'.$current_user['name'].'';?>

<div class="comment">

<button class="edit_btn" type="button" name="follow">プロフィール編集</button>
<br />
<br />
<p class="profile_comment"></p>
<br />
<br />
<div class="btn_flex" style="display: none;">
<button class="btn profile_save" type="button">編集完了</button>
<button class="btn modal_close" type="button">キャンセル</button>
</div>

</div>
<?php print'<br />'.$current_user['profile'].'';?>

<div class = "result"></div>