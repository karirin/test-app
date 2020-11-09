<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php
$post_id=$_GET['post_id'];
$post = get_post($post_id);
$post_user = get_user($post['user_id']); 
$current_user = get_user($_SESSION['user_id']);
?>
<div class="col-8 offset-2">
  <div class="post">
    <div class="post_list">
      <div class="post_user">
        <object>
          <a href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $post_user['id'] ?>">
            <img src="/user/image/<?= $post_user['image'] ?>"> 
            <?php print''.$post_user['name'].''; ?>
          </a>
        </object>
      </div>
      <div class="post_text"><?php print''.$post['text'].''; ?></div>
      <?php
      if (!empty($post['gazou'])):
      print'<img src="/post/gazou/'.$post['gazou'].'" class="post_img" >';
      endif;
      ?>
      <div class="post_info">
        <form class="favorite_count" action="#" method="post">
          <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
          <button type="button" name="favorite" class="btn favorite_btn" data-toggle="favorite" title="いいね">
            <?php if (!check_favolite_duplicate($_SESSION['user_id'],$post['id'])): ?>
              <i class="far fa-star"></i>
            <?php else: ?>
              <i class="fas fa-star"></i>
            <?php endif; ?>
          </button>
          <span class="post_count"><?= current(get_post_favorite_count($post['id'])) ?></span>
        </form>
        <div class="post_comment_count">
          <button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>" type="button" data-toggle="post" title="投稿"><i class="fas fa-comment-dots"></i></button>
          <span class="post_comment_count"><?= current(get_post_comment_count($post['id'])) ?></span>
        </div>
        <div class="comment_confirmation" id="modal<?= $post['id'] ?>">
            <p class="modal_title" >この投稿にコメントしますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
            <textarea class="textarea form-control" placeholder="投稿内容を入力ください" name="text"></textarea>
            <div class="counter">
                <span class="show_count">0</span><span>/300</span>
            </div>
            <div class="comment_img">
            <label>
            <i class="far fa-image"></i>
            <input type="file" name="image_name" class="myImage" accept="image/*" multiple>
            </label>
            <p><img class="preview"></p>
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
          投稿内容更新
          <form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
            投稿内容を編集する
            <input type="text" name="text" value="<?php print $post['text']; ?>">
              <?php if(!empty($disp)) { print $disp_gazou; } ?>
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
      <?php
      $comments = get_comments($post['id']);
      foreach($comments as $comment):
      if(empty($comment['comment_id'])):
      $comment_user = get_user($comment['user_id']);
      ?>
      <div class="comment">
        <object><a href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $comment_user['id'] ?>">
          <div class="user_info">
            <img src="/user/image/<?= $comment_user['image'] ?>">
            <?php print''.$comment_user['name'].''; ?>
          </div>
        </a></object>
        <span class="comment_text"><?= $comment['text'] ?></span>
        <?php
        if(!empty($comment['image'])){
        print'<p class="comment_image"><img src="../comment/image/'.$comment['image'].'"></p>';
        }
        ?>
        <div class="comment_info">
          <button class="btn modal_btn" data-target="#delete_modal<?= $comment['id'] ?>" type="button" data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
          <div class="delete_confirmation" id="delete_modal<?= $comment['id'] ?>">
            <span class="modal_title">こちらのコメントを削除しますか？</span>
            <span class="post_content"><?= nl2br($comment['text']) ?></span>
            <form action="../comment/comment_delete_done.php" method="post">
              <input type="hidden" name="id" value="<?= $comment['id'] ?>">
              <input type="hidden" name="image_name" value="<?= $comment['image'] ?>">
              <input type="hidden" name="user_id" value="<?= $post_user['id'] ?>">
              <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
              <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
          </div>
          <button class="btn modal_btn" data-target="#reply_modal<?= $comment['id'] ?>" type="button" data-toggle="reply" title="返信"><i class="fas fa-reply"></i></button>
          <span class="post_comment_count"><?= current(get_post_comment_count($comment['id'])) ?></span>
          <div class="reply_comment_confirmation" id="reply_modal<?= $comment['id'] ?>">
            <p class="modal_title">このコメントに返信しますか？</p>
            <p class="post_content"><?= nl2br($comment['text']) ?></p>
            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
              <p>コメント内容を入力ください。</p>
              <input type="text" name="text">
              <p>画像を選んでください。</p>
              <input type="file" name="image_name">
              <input type="hidden" name="id" value="<?= $post['id'] ?>">
              <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
              <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
              <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
          </div>
        </div>
        <?php 
        print'<span class="comment_created_at">'.convert_to_fuzzy_time($comment['created_at']).'</span>'; 
        //_debug($reply_comments);
        endif;
        $reply_comments = get_reply_comments($post['id'],$comment['id']); 
        // for($i = 0; $i <= $reply_comments[$i]; $i++){
        //   if(!empty($reply_comments)):
        //     print'<a href="#" class="thread_btn" data-target="#reply_'.current($reply_comments[$i]).'"><p>このスレッドを表示する</p></a>';
        //   endif;
        foreach($reply_comments as $reply_comment):
        if(!empty($reply_comment)):
        print'<a href="#" class="thread_btn" data-target="#reply_'.$reply_comment['id'].'"><p>このスレッドを表示する</p></a>';
        endif;
        ?>
        <div class="reply" id="reply_<?= $reply_comment['id'] ?>">
          <?php
          if($reply_comment['comment_id']==$comment['id']):
          $reply_comment_user = get_user($reply_comment['user_id']);
          ?>
          <div class="reply_comment">
            <object><a href="/user/user_disp.php?user_id=<?= $reply_comment_user['id'] ?>&page_id=<?= $reply_comment_user['id'] ?>">
              <div class="user_info">
                <img src="/user/image/<?= $reply_comment_user['image'] ?>">
                <?php print''.$reply_comment_user['name'].''; ?>
              </div>
            </object></a>
            <?php print'<span class="comment_text">'.$reply_comment['text'].'</span>';
            if(!empty($reply_comment['image'])){
            print'<p class="comment_image"><img src="../comment/image/'.$reply_comment['image'].'"></p>';
            }
            ?>
            <div class="comment_info">
              <button class="btn modal_btn" data-target="#delete_modal<?= $reply_comment['id'] ?>" type="button"><i class="far fa-trash-alt"></i></button>
              <div class="delete_confirmation" id="delete_modal<?= $reply_comment['id'] ?>">
                <span class="modal_title">こちらのコメントを削除しますか？</span>
                <span class="post_content"><?= nl2br($reply_comment['text']) ?></span>
                <form action="../comment/comment_delete_done.php" method="post">
                  <input type="hidden" name="id" value="<?= $reply_comment['id'] ?>">
                  <input type="hidden" name="image_name" value="<?= $reply_comment['image'] ?>">
                  <input type="hidden" name="user_id" value="<?= $post_user['id'] ?>">
                  <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                  <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
                  <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                </form>
              </div>
              <button class="btn modal_btn" data-target="#reply_modal<?= $reply_comment['id'] ?>" type="button"><i class="fas fa-reply"></i></button>
              <span class="post_comment_count"><?= current(get_post_comment_count($reply_comment['id'])) ?></span>
              <div class="reply_comment_confirmation" id="reply_modal<?= $reply_comment['id'] ?>">
                <p class="modal_title">このコメントに返信しますか？</p>
                <?php print'<p class="post_content">'.nl2br($reply_comment['text']).'</p>'; ?>
                <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
                  <p>コメント内容を入力ください。</p>
                  <input type="text" name="text">
                  <p>画像を選んでください。</p>
                  <input type="file" name="image_name">
                  <input type="hidden" name="id" value="<?= $post_id ?>">
                  <input type="hidden" name="comment_id" value="<?= $reply_comment['id'] ?>">
                  <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
                  <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                </form>
              </div>
              <span class="comment_created_at"><?= convert_to_fuzzy_time($reply_comment['created_at'])?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
                  <?php endforeach; ?>
      </div>
      <?php endforeach; ?>



<?php require_once('../footer.php');?>