<?php
require_once('../config.php');
?>

<body>
    <?php
  $post_id = $_GET['post_id'];
  $post = get_post($post_id);
  $post_user = get_user($post['user_id']);
  $current_user = get_user($_SESSION['user_id']);
  ?>
    <div class="col-8 offset-2">
        <div class="post">
            <div class="post_list">
                <div class="post_user">
                    <object>
                        <a
                            href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $post_user['id'] ?>&type=main">
                            <img src="/user/image/<?= $post_user['image'] ?>">
                            <?php print '' . $post_user['name'] . ''; ?>
                        </a>
                    </object>
                </div>
                <div class="post_text"><?php print '' . $post['text'] . ''; ?></div>
                <?php
        if (!empty($post['image'])) :
          print '<img src="/post/image/' . $post['image'] . '" class="post_img" >';
        endif;
        ?>
                <div class="post_info">
                    <form class="favorite_count" action="#" method="post">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <button type="button" name="favorite" class="btn favorite_btn" data-toggle="favorite"
                            title="いいね">
                            <?php if (!check_favolite_duplicate($_SESSION['user_id'], $post['id'])) : ?>
                            <i class="far fa-star"></i>
                            <?php else : ?>
                            <i class="fas fa-star"></i>
                            <?php endif; ?>
                        </button>
                        <span class="post_count"><?= current(get_post_favorite_count($post['id'])) ?></span>
                    </form>
                    <div class="post_comment_count">
                        <button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>" type="button"
                            data-toggle="post" title="投稿"><i class="fas fa-comment-dots"></i></button>
                        <span class="post_comment_count"><?= current(get_post_comment_count($post['id'])) ?></span>
                    </div>
                    <div class="comment_confirmation" id="modal<?= $post['id'] ?>">
                        <p class="modal_title">この投稿にコメントしますか？</p>
                        <p class="post_content"><?= nl2br($post['text']) ?></p>
                        <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
                            <textarea id="comment_counter" class="textarea form-control" placeholder="コメントを入力ください"
                                name="text"></textarea>
                            <div class="counter">
                                <span class="comment_count">0</span><span>/300</span>
                            </div>
                            <div class="comment_img">
                                <label>
                                    <i class="far fa-image"></i>
                                    <input type="file" name="image_name" id="comment_image" accept="image/*" multiple>
                                </label>
                                <p><img class="comment_preview"></p>
                                <i class="far fa-times-circle comment_clear"></i>
                            </div>
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <div class="post_btn">
                                <button class="btn btn-outline-danger" type="submit" name="comment"
                                    value="comment">コメント</button>
                                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                            </div>
                        </form>
                    </div>
                    <?php if($post['user_id']==$current_user['id']): ?>
                    　<button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>" type="button"
                        data-toggle="edit" title="編集"><i class="fas fa-edit"></i></button>
                    <div class="post_edit" id="edit_modal<?= $post['id'] ?>">
                        <p>投稿内容更新</p>
                        <form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
                            <textarea id="edit_counter" class="textarea form-control" placeholder="投稿内容を編集してください"
                                name="text"><?php print $post['text']; ?></textarea>
                            <div class="counter">
                                <span class="post_edit_count">0</span><span>/300</span>
                            </div>
                            <div class="post_image">
                                <label>
                                    <i class="far fa-image"></i>
                                    <input type="file" name="image_name" id="edit_image" accept="image/*" multiple>
                                </label>
                                <p><img class="edit_preview"></p>
                                <i class="far fa-times-circle edit_clear"></i>
                            </div>
                            <input type="hidden" name="id" value="<?php print $post['id']; ?>">
                            <input type="hidden" name="image_name_old" value="<?php print $post['image']; ?>">
                            <div class="post_btn">
                                <button class="btn btn-outline-danger" type="submit" name="edit"
                                    value="edit">更新</button>
                                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                            </div>
                        </form>
                    </div>
                    　<button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>" type="button"
                        data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
                    <div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>">
                        <p class="modal_title">こちらの投稿を削除しますか？</p>
                        <p class="post_content"><?= nl2br($post['text']) ?></p>
                        <form action="post_delete_done.php" method="post">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="image_name" value="<?= $post['image'] ?>">
                            <button class="btn btn-outline-danger" type="submit" name="delete"
                                value="delete">削除</button>
                            <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                        </form>
                    </div>
                    <?php endif ?>
                </div>
                　<p class="post_created_at"><?php print '' . convert_to_fuzzy_time($post['created_at']) . ''; ?></p>
                <?php
        $comments = get_comments($post['id']);
        foreach ($comments as $comment) :
          if (empty($comment['comment_id'])) :
            $comment_user = get_user($comment['user_id']);
        ?>
                <div class="comment">
                    <object><a
                            href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $comment_user['id'] ?>&type=all">
                            <div class="user_info">
                                <img src="/user/image/<?= $comment_user['image'] ?>">
                                <?php print '' . $comment_user['name'] . ''; ?>
                            </div>
                        </a></object>
                    <span class="comment_text"><?= $comment['text'] ?></span>
                    <?php
              if (!empty($comment['image'])) {
                print '<p class="comment_image"><img src="../comment/image/' . $comment['image'] . '"></p>';
              }
              ?>
                    <div class="comment_info">
                        <button class="btn modal_btn" data-target="#delete_modal<?= $comment['id'] ?>" type="button"
                            data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
                        <div class="delete_confirmation" id="delete_modal<?= $comment['id'] ?>">
                            <span class="modal_title">こちらのコメントを削除しますか？</span>
                            <span class="post_content"><?= nl2br($comment['text']) ?></span>
                            <form action="../comment/comment_delete_done.php" method="post">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                <input type="hidden" name="image_name" value="<?= $comment['image'] ?>">
                                <input type="hidden" name="user_id" value="<?= $post_user['id'] ?>">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button class="btn btn-outline-danger" type="submit" name="delete"
                                    value="delete">削除</button>
                                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                            </form>
                        </div>
                        <div class="reply_comment_count">
                            <button class="btn modal_btn" data-target="#reply_modal<?= $comment['id'] ?>" type="button"
                                data-toggle="reply" title="返信"><i class="fas fa-reply"></i></button>
                            <span
                                class="post_comment_count"><?= current(get_reply_comment_count($comment['id'])) ?></span>
                        </div>
                        <div class="reply_comment_confirmation" id="reply_modal<?= $comment['id'] ?>">
                            <p class="modal_title">このコメントに返信しますか？</p>
                            <p class="post_content"><?= nl2br($comment['text']) ?></p>
                            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
                                <textarea id="comment_counter" class="textarea form-control" placeholder="コメント内容を入力ください"
                                    name="text"></textarea>
                                <div class="counter">
                                    <span class="comment_count">0</span><span>/300</span>
                                </div>
                                <div class="comment_img">
                                    <label>
                                        <i class="far fa-image"></i>
                                        <input type="file" name="image_name" id="reply_comment_image" accept="image/*"
                                            multiple>
                                    </label>
                                    <p><img class="reply_comment_preview"></p>
                                    <i class="far fa-times-circle reply_comment_clear"></i>
                                </div>
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                <div class="post_btn">
                                    <button class="btn btn-outline-danger" type="submit" name="comment"
                                        value="comment">コメント</button>
                                    <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
            print '<span class="comment_created_at margin_bottom">' . convert_to_fuzzy_time($comment['created_at']) . '</span>';
          endif;
          $reply_comments = get_reply_comments($post['id'], $comment['id']);
            ?>
                    <?php
              foreach ($reply_comments as $reply_comment) :
                if ($reply_comment['comment_id'] == $comment['id']) :
                  $reply_comment_user = get_user($reply_comment['user_id']);
              ?>
                    <div class="reply">
                        <div class="reply_comment">
                            <object><a
                                    href="/user/user_disp.php?user_id=<?= $reply_comment_user['id'] ?>&page_id=<?= $reply_comment_user['id'] ?>&type=all">
                                    <div class="user_info">
                                        <img src="/user/image/<?= $reply_comment_user['image'] ?>">
                                        <?php print '' . $reply_comment_user['name'] . ''; ?>
                                    </div>
                            </object></a>
                            <?php
                    print '<span class="comment_text">' . $reply_comment['text'] . '</span>';
                    if (!empty($reply_comment['image'])) {
                      print '<p class="comment_image"><img src="../comment/image/' . $reply_comment['image'] . '"></p>';
                    }
                    ?>
                            <div class="comment_info">
                                <button class="btn modal_btn" data-target="#delete_modal<?= $reply_comment['id'] ?>"
                                    type="button"><i class="far fa-trash-alt"></i></button>
                                <div class="delete_confirmation" id="delete_modal<?= $reply_comment['id'] ?>">
                                    <span class="modal_title">こちらのコメントを削除しますか？</span>
                                    <span class="post_content"><?= nl2br($reply_comment['text']) ?></span>
                                    <form action="../comment/comment_delete_done.php" method="post">
                                        <input type="hidden" name="id" value="<?= $reply_comment['id'] ?>">
                                        <input type="hidden" name="image_name" value="<?= $reply_comment['image'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $post_user['id'] ?>">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <button class="btn btn-outline-danger" type="submit" name="delete"
                                            value="delete">削除</button>
                                        <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                                    </form>
                                </div>
                            </div>
                            <span
                                class="comment_created_at"><?= convert_to_fuzzy_time($reply_comment['created_at']) ?></span>

                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>
    </div>
    </div>

    <?php require_once('../footer.php'); ?>