<?php
// 単語のリスト
$list = array(
    'Apple',
    'Orange',
    'Grape',
    'Banana',
    'Pear',
    'Melon',
    'Peach',
    'Lemon'
);

$words = array();

// 現在入力中の文字を取得
$term = (isset($_GET['term']) && is_string($_GET['term'])) ? $_GET['term'] : '';

// 部分一致で検索
foreach ($list as $word) {
    if (mb_stripos($word, $term) !== FALSE) {
        $words[] = $word;
    }
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($words);