<div class="post_info">
    <form class="favorite_count" action="#" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="button" name="favorite" class="btn favorite_btn" data-toggle="favorite" title="いいね">
            <?php if (!check_favolite_duplicate($_SESSION['user_id'], $post['id'])) : ?>
            <i class="far fa-star"></i>
            <?php else : ?>
            <i class="fas fa-star"></i>
            <?php endif; ?>
        </button>
        <?php
        $post_class = new Post($post['id']);
        $post = $post_class->get_post();
        ?>
        <span class="post_count"><?= current($post_class->get_post_favorite_count()) ?></span>
    </form>
    <div class="post_comment_count">
        <button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>" type="button" data-toggle="post"
            title="投稿"><i class="fas fa-comment-dots"></i></button>
        <span class="post_comment_count"><?= current($post_class->get_post_comment_count()) ?></span>
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
                <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </div>
        </form>
    </div>
    <?php if ($post['user_id'] == $current_user['id']) : ?>
    <button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>" type="button" data-toggle="edit"
        title="編集"><i class="fas fa-edit"></i></button>
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
                <button class="btn btn-outline-danger" type="submit" name="edit" value="edit">更新</button>
                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </div>
        </form>
    </div>
    <button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>" type="button" data-toggle="delete"
        title="削除"><i class="far fa-trash-alt"></i></button>
    <div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>">
        <p class="modal_title">こちらの投稿を削除しますか？</p>
        <p class="post_content"><?= nl2br($post['text']) ?></p>
        <form action="../post/post_delete_done.php" method="post">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="image_name" value="<?= $post['image'] ?>">
            <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
            <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
        </form>
    </div>
    <?php endif; ?>
</div>