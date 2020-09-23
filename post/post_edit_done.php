<?php require_once('../head.php'); ?>
<body>

<?php

try
{
    $post_id = $_POST['id'];
    $post_name = $_POST['name'];
    $post_price = $_POST['price'];
    $post_gazou_name_old = $_POST['gazou_name_old'];
    $post_gazou_name = $_POST['gazou_name'];

    $post_id=htmlspecialchars($post_id,ENT_QUOTES,'UTF-8');
    $post_name=htmlspecialchars($post_name,ENT_QUOTES,'UTF-8');
    $post_price=htmlspecialchars($post_price,ENT_QUOTES,'UTF-8');

    $dsn = 'mysql:dbname=shop;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn,$user,$password);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE post SET name=?,price=?,gazou=? WHERE id=?';
    $stmt = $dbh -> prepare($sql);
    $data[] = $post_name;
    $data[] = $post_price;
    $data[] = $post_gazou_name;
    $data[] = $post_id;
    $stmt -> execute($data);

    $dbh = null;

if($post_gazou_name_old!=$post_gazou_name)
{
    if($post_gazou_name_old!='')
    {
        unlink('./gazou/'.$post_gazou_name_old);
    }
}
    print '修正しました。<br />';

}   
catch (Exception $e)
{
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>

<a href="post_list.php">戻る</a>
</body>
</html>