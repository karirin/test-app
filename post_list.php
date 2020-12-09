<?php 
foreach($posts as $post):
$post_user = get_user($post['user_id']); 

print'<div class="post">';
print'<a href="/post/post_disp.php?post_id='.$post['id'].'&user_id='.$current_user['id'].'" class="post_link">';
if(basename($_SERVER['PHP_SELF']) === 'user_top.php'):
print'<div class="post_list"  style="width: 100%;">';
else:
print'<div class="post_list"  style="width: 80%;">';
endif;
print'<div class="post_user">';
print'<object><a href="/user/user_disp.php?user_id='.$current_user['id'].'&page_id='.$post_user['id'].'&type=all">';
print'<img src="/user/image/'.$post_user['image'].'">'; 
print''.$post_user['name'].'';
print'</a></object>';
print'</div>';
print'<div class="post_text ellipsis" id="post_text">';
print''.$post['text'].'';
print'</div>';
if (substr_count($post['text'],"\n") +1 > 10):
print'<object><a href="#" class="show_all">続きを表示する</a></object>';
endif;
if (!empty($post['image'])):
  print'<img src="/post/image/'.$post['image'].'" class="post_img" >';
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
            <textarea id="comment_counter" class="textarea form-control" placeholder="コメントを入力ください" name="text"></textarea>
            <div class="counter">
                <span class="comment_count">0</span><span>/300</span>
            </div>
            <div class="comment_img">
            <label>
            <i class="far fa-image"></i>
            <input type="file" name="image_name" class="comment_image" accept="image/*" multiple>
            </label>
            <p><img class="comment_preview"></p>
            </div>
              <input type="hidden" name="id" value="<?= $post['id'] ?>">
              <div class="post_btn">
              <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
              </div>
            </form>
</div>
<button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>" type="button" data-toggle="edit" title="編集"><i class="fas fa-edit"></i></button>
<div class="post_edit" id="edit_modal<?= $post['id'] ?>">
<p>投稿内容更新</p>
<form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
<textarea id="edit_counter" class="textarea form-control" placeholder="投稿内容を編集してください" name="text"><?php print $post['text']; ?></textarea>
<div class="counter">
                <span class="post_edit_count">0</span><span>/300</span>
</div>
<div class="post_image">
<label>
<i class="far fa-image"></i>
<input type="file" name="image_name" class="edit_image" accept="image/*" multiple>
</label>
<p><img class="edit_preview"></p>
</div>
<input type="hidden" name="id" value="<?php print $post['id']; ?>">
<input type="hidden" name="image_name_old" value="<?php print $post['image']; ?>">
<div class="post_btn">
<button class="btn btn-outline-danger" type="submit" name="edit" value="edit">更新</button>
<button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
</div>
</form>
</div>
<button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>" type="button" data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
<div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>">
            <p class="modal_title" >こちらの投稿を削除しますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form action="../post/post_delete_done.php" method="post">
              <input type="hidden" name="id" value="<?= $post['id']?>">
              <input type="hidden" name="image_name" value="<?= $post['image']?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
</div>
</div>
<p class="post_created_at"><?php print''.convert_to_fuzzy_time($post['created_at']).''; ?></p>
</div>
</div>

<?php endforeach ?>