<?php 
if (!empty($_POST['search_post'])){
    $hoge = $_POST['search_input'];
    header("Location:post_index.php?type=search&query=${hoge}");
  }
require_once('../config.php'); 
?>
<div class="col-8 offset-2">
<h2 class="center margin_top">投稿一覧</h2>
<form method="post" action="#" class="search_container">
<div class="input-group mb-2">
<input type="text" name="search_input" class="form-control" placeholder="投稿検索">
<div class="input-group-append">
<input type="submit" name="search_post" class="btn btn-outline-secondary">
<?php
$current_user = get_user($_SESSION['user_id']);
$page_type = $_GET['type'];

switch ($page_type) {
    case 'all':
    $posts = get_posts('','all',0);
    break;

    case 'search':
    $posts = get_posts('','search',$_GET['query']);
    break;
  }
?>
</div>
</div>
</form>
<?php
require_once('post_list.php');
print'</div>';
require_once('../footer.php'); 
?>
