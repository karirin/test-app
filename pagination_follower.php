<?php
if (isset($block[1])) :
    $block_count = count($block);
?>

<form method="post" action="#">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center pagination-lg">
            <li class="page-item">
                <?php if ($_SESSION['page_follower'] == 0) : ?>
                <input class="page-link first" name="block_follower" type="submit" value="&laquo;" disabled>
                <?php else : ?>
                <input class="page-link" name="block_follower" type="submit" value="&laquo;">
                <?php endif; ?>
            </li>

            <?php for ($m = 1; $m < $block_count + 1; $m++) {
                    print '<li class="page-item"><input class="page-link" name="block_follower" type="submit" value="' . $m . '"></li>';
                } ?>
            <li class="page-item">
            <li class="page-item">
                <?php if ($_SESSION['page_follower'] == $block_count - 1) : ?>
                <input class="page-link last" name="block_follower" type="submit" value="&raquo;" disabled>
                <?php else : ?>
                <input class="page-link" name="block_follower" type="submit" value="&raquo;">
                <?php endif; ?>
            </li>
            </li>
        </ul>
    </nav>
</form>
<?php endif; ?>