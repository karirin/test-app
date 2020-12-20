<?php
if (!empty($_POST['search_user'])) {
  $hoge = $_POST['search_input'];
  header("Location:user_list.php?type=search&query=${hoge}");
}
require_once('../config.php');
require_once('../header.php');
require_once('../head.php');
require_once('../post_process.php');
?>

<body>
  <div class="col-8 offset-2">
    <h2 class="center margin_top_bottom">ユーザー一覧</h2>
    <form method="post" action="#" class="search_container">
      <div class="input-group mb-2">
        <input type="text" name="search_input" class="form-control" placeholder="ユーザー検索">
        <div class="input-group-append">
          <input type="submit" name="search_user" class="btn btn-outline-secondary">
        </div>
      </div>
    </form>

    <?php
    $page_type = $_GET['type'];
    $current_user = get_user($_SESSION['user_id']);
    switch ($page_type) {
      case 'all';
        $users = get_users('all', '');
        break;

      case 'search':
        $users = get_users('search', $_GET['query']);
        break;
    }
    foreach ((array) $users as $user) :
      $user = current($user);
      $user = get_user($user);
    ?>
      <a href="/user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $user['id'] ?>&type=main" class="user_link">
        <div class="user">
          <div class="user_info">
            <?php if (!empty($user['image'])) : ?>
              <img src="/user/image/<?= $user['image'] ?>">
            <?php endif; ?>
            <div class="user_name">
              <?= $user['name'] ?>
            </div>
          </div>
          <div class="user_profile">
            <?= $user['profile'] ?>
          </div>
          <?php if (!($current_user == $user)) : ?>
            <div class="direct_message">
              <object><a href="../message/message.php?user_id=<?= $user['id'] ?>"><i class="far fa-envelope"></i></a></object>
            </div>
          <?php endif; ?>
        </div>
      </a>
    <?php endforeach ?>
    <a href="../user_login/user_top.php?user_id=<?= $_SESSION['user_id'] ?>&type=main">トップメニューへ</a><br />
  </div>
</body>
<?php require_once('../footer.php'); ?>