<?php
require_once('../config_1.php');

$page_type = $_GET['type'];
if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
  $user = new User($_GET['page_id']);
  $current_user = $user->get_user();
} else {
  $user = new User($_SESSION['user_id']);
  $current_user = $user->get_user();
}

$favorite_count = $user->get_user_count('favorite');
$follow_count = $user->get_user_count('follow');
$follower_count = $user->get_user_count('follower');
?>

<body>

    <div class="row wide_disp justify-content-center">
        <div class="col-8 offset-2">
            <div class="col-6 myprofile">
                <div class="profile">
                    <form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
                        <div class="edit_profile_img">
                            <label>
                                <div class="fa-image_range">
                                    <i class="far fa-image"></i>
                                </div>
                                <input type="file" name="image_name" id="edit_profile_img" accept="image/*" multiple>
                            </label>
                            <img name="profile_image" class="editing_profile_img"
                                src="/user/image/<?= $current_user['image'] ?>">
                            <label>
                                <i class="far fa-times-circle profile_clear"></i>
                                <input type="button" id="profile_clear">
                            </label>
                        </div>
                        <img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
                        <h3 class="profile_name"><?= $current_user['name'] ?></h3>
                        <p class="comment"><?= $current_user['profile'] ?></p>
                        <input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
                        <input type="file" name="image" class="image" value="<?= $current_user['image'] ?>"
                            style="display:none;">
                        <div class="btn_flex">
                            <input type="submit" class="btn btn-outline-dark" value="編集完了">
                            <button class="btn btn-outline-info modal_close" type="button">キャンセル</button>
                        </div>
                    </form>
                </div>
                <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
                <button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
                <?php endif; ?>

                <?php if ($current_user['id'] != $_SESSION['user_id']) : ?>
                <form action="#" method="post">
                    <input type="hidden" class="current_user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" name="follow_user_id" value="<?= $current_user['id'] ?>">
                    <?php if ($user->check_follow($_SESSION['user_id'], $current_user['id'])) : ?>
                    <button class="follow_btn border_white btn following" type="button" name="follow">フォロー中</button>
                    <?php else : ?>
                    <button class="follow_btn border_white btn" type="button" name="follow">フォロー</button>
                    <?php endif; ?>
                </form>
                <?php endif; ?>

            </div>
            <div class="col-6 myprofile">
                <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
                <button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row narrow_disp">
        <div class="col-6 center">
            <div class="profile">
                <form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
                    <div class="edit_profile_img">
                        <label>
                            <div class="fa-image_range">
                                <i class="far fa-image"></i>
                            </div>
                            <input type="file" name="image_name" id="edit_profile_img_narrow" accept="image/*" multiple>
                        </label>
                        <img name="profile_image" class="editing_profile_img"
                            src="/user/image/<?= $current_user['image'] ?>">
                        <label>
                            <i class="far fa-times-circle profile_clear"></i>
                            <input type="button" id="profile_clear">
                        </label>
                    </div>
                    <img src="/user/image/<?= $current_user['image'] ?>" class="mypage">
                    <h3 class="profile_name_narrow"><?= $current_user['name'] ?></h3>
                    <p class="comment_narrow"><?= $current_user['profile'] ?></p>
                    <input type="hidden" name="id" class="user_id" value="<?= $current_user['id'] ?>">
                    <input type="file" name="image" class="image" value="<?= $current_user['image'] ?>"
                        style="display:none;">
                    <div class="btn_flex">
                        <input type="submit" class="btn btn-outline-dark" value="編集完了">
                        <button class="btn btn-outline-info modal_close" type="button">キャンセル</button>
                    </div>
                </form>
            </div>
            <div class="row profile_count">
                <div class="col-4 offset-1">
                    <a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=main">投稿数<p>
                            <?= current($user->get_user_count('post')) ?></p></a>
                </div>
                <div class="col-4 offset-1">
                    <a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=favorites">お気に入り投稿<p>
                            <?= current($user->get_user_count('favorite')) ?></p></a>
                </div>
                <div class="col-4 offset-1">
                    <a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follow">フォロー数<p>
                            <?= current($user->get_user_count('follow')) ?></p></a>
                </div>
                <div class="col-4 offset-1">
                    <a href="user_top.php?page_id=<?= $current_user['id'] ?>&type=follower">フォロワー数<p>
                            <?= current($user->get_user_count('follower')) ?></p></a>
                </div>
            </div>
            <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
            <button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
            <?php endif; ?>
        </div>

    </div>
    <?php
  switch ($page_type) {

    case 'follow':
      $users = $user->get_users('follows');
      break;

    case 'follower':
      $users = $user->get_users('followers');
      break;
  } ?>
    <div class="row narrower_disp">
        <div class="col-8 offset-2">
            <?php
      if ($page_type === 'main') :
      ?>
            <h2><?= $current_user['name'] ?>さんの投稿</h2>
            <?php elseif ($page_type === 'favorites') : ?>
            <h2>お気に入りの投稿</h2>
            <?php elseif ($page_type === 'follow') : ?>
            <h2>フォローした人</h2>
            <?php elseif ($page_type === 'follower') : ?>
            <h2>フォロワー</h2>
            <?php endif;

      require('user_list.php');
      ?>
        </div>
    </div>

    <?php

  require_once('../footer.php'); ?>