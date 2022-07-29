<?php
require_once('../config_1.php');
$post_class = new Post($_GET['post_id']);
$test_class = new Test($_GET['post_id']);
$post = $post_class->get_post();
$test = $test_class->get_test();
?>
<div class="input-group test_url">
    <div class="input-group mb-2">
        <input type="text" id="test_url" class="form-control" aria-label="Username" aria-describedby="text1a"
            value="<?= $post['text']; ?>" readonly="readonly">
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard()"><i
                    class="fas fa-copy"></i></button>
        </div>
    </div>
</div>
<ul class="test_case">
    <?php _debug($test); ?>
    <?php foreach ($test as $test_case) : ?>
    <?php _debug($test_case); ?>
    <li><?= $test_case['text'] ?></li>
    <?php endforeach ?>
    <form method="post" action="test_add_done.php">
        <input type="text" name="text" class="form-control testcase_text" aria-describedby="text1a">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <input class="btn btn-outline-dark" type="submit" value="投稿">
    </form>
</ul>
<?php
require_once('../footer.php');
?>