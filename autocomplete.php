<?php
function _debug($data, $clear_log = false)
{
    $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/debug.txt';
    if ($clear_log) {
        file_put_contents($uri_debug_file, print_r('', true));
    }
    file_put_contents($uri_debug_file, print_r($data, true), FILE_APPEND);
}

// 単語のリスト
$list = array(
    'AWS',
    'Bootstrap',
    'C',
    'CakePHP',
    'C#',
    'C++',
    'COBOL',
    'CSS',
    'Docker',
    'Go',
    'Git',
    'HTTP',
    'iOS',
    'Java',
    'JavaScript',
    'JIRA',
    'Kotlin',
    'Laravel',
    'MATLAB',
    'MySQL',
    'Oracle Database',
    'Perl',
    'PHP',
    'PostgreSQL',
    'Python',
    'R',
    'React',
    'Ruby',
    'Ruby on Rails',
    'Rust',
    'SVN',
    'SSL',
    'SQLite',
    'TypeScript',
    'Vue.js'
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