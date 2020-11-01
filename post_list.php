<?php 
foreach($posts as $post):
$post_user = get_user($post['user_id']); 

print'<div class="post">';
print'<a href="/post/post_disp.php?post_id='.$post['id'].'&user_id='.$current_user['id'].'" class="post_link">';
print'<div class="post_list">';
print'<div class="post_user">';
print'<object><a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$post_user['id'].'">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</a></object>';
print'</div>';
print'<div class="post_text">';
print''.$post['text'].'';
print'</div>';
if (!empty($post['gazou'])):
  print'<img src="/post/gazou/'.$post['gazou'].'" class="post_img" >';
endif;

?>
</a>
<div class="post_info">
<div class="post_favorite">
<button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>" type="button" data-toggle="post" title="投稿"><i class="fas fa-comment-dots"></i></button>
<span class="post_comment_count"><?= current(get_post_comment_count($post['id'])) ?></span>
</div>
<div class="comment_confirmation" id="modal<?= $post['id'] ?>">
            <p class="modal_title" >この投稿にコメントしますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
              <p>コメント内容を入力ください。</p>
              <input type="text" name="text">
              <p>画像を選んでください。</p>
              <input type="file" name="image_name">
              <input type="hidden" name="id" value="<?= $post['id'] ?>">
              <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
<button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>" type="button" data-toggle="edit" title="編集"><i class="fas fa-edit"></i></button>
<div class="post_edit" id="edit_modal<?= $post['id'] ?>">
投稿内容更新
<form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
投稿内容を編集する
<input type="text" name="text" value="<?php print $post['text']; ?>">
<?php
if(!empty($disp)){
print $disp_gazou;
}
?>
画像を選んでください<br />
<input type="file" name="gazou_name" style="width:400px">
<input type="hidden" name="id" value="<?php print $post['id']; ?>">
<input type="hidden" name="gazou_name_old" value="<?php print $post['gazou']; ?>">
<button class="btn btn-outline-danger" type="submit" name="edit" value="edit">更新</button>
<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
</form>
</div>
<button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>" type="button" data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
<div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>">
            <p class="modal_title" >こちらの投稿を削除しますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form action="post_delete_done.php" method="post">
              <input type="hidden" name="id" value="<?= $post['id']?>">
              <input type="hidden" name="gazou_name" value="<?= $post['gazou']?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
</div>
<p class="post_created_at"><?php print''.convert_to_fuzzy_time($post['created_at']).''; ?></p>
</div>
</div>

<?php endforeach ?>