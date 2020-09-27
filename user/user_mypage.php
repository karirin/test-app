<?php
require_once('../function.php');
$page_type = $_GET['type'];
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

<?php require_once('../post/post_index.php') ?>

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
<?php print'<br />'.$current_user['profile'].'';


?>

<div class = "result"></div>