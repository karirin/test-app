<?php

require_once('../config.php');
require_once('../head.php');
require_once('../header.php');

$post_id=$_GET['post_id'];
$comment_id=$_GET['comment_id'];

print'<div class="reply">';
$reply_comments = get_reply_comments($post_id,$comment_id);
foreach($reply_comments as $reply_comment):
if($reply_comment['comment_id']==$comment_id){
  $reply_comment_user = get_user($reply_comment['user_id']);
  print'<div class="comment">';
  print'<object><a href="/user/user_disp.php?user_id='.$reply_comment_user['id'].'&page_id='.$reply_comment_user['id'].'">';
  print'<div class="user_info">';
  print'<img src="/user/image/'.$reply_comment_user['image'].'">';
  print''.$reply_comment_user['name'].'';
  print'</div>';
  print'</object></a>';
  print'<span class="comment_text">'.$reply_comment['text'].'</span>';
  if(!empty($reply_comment['image'])){
  print'<p class="comment_image"><img src="../comment/image/'.$reply_comment['image'].'"></p>';
  }
  print'<div class="comment_info">';
  print'<button class="btn modal_btn" data-target="#delete_modal'.$reply_comment['id'].'" type="button"><i class="far fa-trash-alt"></i></button>';
  print'<div class="delete_confirmation" id="delete_modal'.$reply_comment['id'].'">';
  print'<span class="modal_title">こちらのコメントを削除しますか？</span>';
  print'<span class="post_content">'.nl2br($reply_comment['text']).'</span>';
  print'<form action="../comment/comment_delete_done.php" method="post">';
  print'<input type="hidden" name="id" value="'.$reply_comment['id'].'">';
  print'<input type="hidden" name="image_name" value="'.$reply_comment['image'].'">';
  print'<input type="hidden" name="user_id" value="'.$post_user['id'].'">';
  print'<input type="hidden" name="post_id" value="'.$post['id'].'">';
  print'<button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>';
  print'<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>';
  print'</form>';
  print'</div>';
  print'<button class="btn modal_btn" data-target="#reply_modal'.$reply_comment['id'].'" type="button"><i class="fas fa-reply"></i></button>';
  print'<span class="post_comment_count">'.current(get_post_comment_count($reply_comment['id'])).'</span>';
  print'<div class="reply_comment_confirmation" id="reply_modal'.$reply_comment['id'].'">';
  print'<p class="modal_title">このコメントに返信しますか？</p>';
  print'<p class="post_content">'.nl2br($reply_comment['text']).'</p>';
  print'<form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">';
  print'<p>コメント内容を入力ください。</p>';
  print'<input type="text" name="text">';
  print'<p>画像を選んでください。</p>';
  print'<input type="file" name="image_name">';
  print'<input type="hidden" name="id" value="'.$post_id.'">';
  print'<input type="hidden" name="comment_id" value="'.$reply_comment['id'].'">';
  print'<button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>';
  print'<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>';
  print'</form>';
  print'</div>';
  print'</div>';
  print'<span class="comment_created_at">'.convert_to_fuzzy_time($reply_comment['created_at']).'</span>';
}
endforeach;
print'</div>';
?>