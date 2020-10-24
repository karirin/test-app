<?php 
require_once('../config.php'); 
require_once('../header.php'); 
require_once('../head.php');
require_once('../post_process.php');

$current_user = get_user($_SESSION['user_id']);
$posts = get_posts($current_user['id'],'all',0);
print'<div class="col-8 offset-2">';
require_once('../post_list.php');
print'</div>';
require_once('../footer.php'); 
?>
