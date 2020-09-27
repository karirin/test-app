<div class="row">
<div class="col-4">
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
<?php print '<img src="./image/'.$current_user['image'].'" style="width:200px">';?><br />
<img src=<?= $current_user['image'] ?> alt="">
<?php var_dump($current_user['image']);?>


<div class="comment">

<button class="edit_btn" type="button" name="follow">プロフィール編集</button>  
<p class="profile_comment"></p>
<div class="btn_flex">

<button class="btn profile_save" type="button">編集完了</button>
<button class="btn modal_close" type="button">キャンセル</button>
</div>

</div>
<?php print'<br />'.$current_user['profile'].'';
?>
</div>

<div class="col-8">
<?php require_once('../post/post_index.php') ?>
</div>
</div>