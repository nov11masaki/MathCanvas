<?php
session_start();

// セッションからユーザー名を取得
if (!isset($_SESSION['username'])) {
    exit("セッションが開始されていないか、ユーザー名が設定されていません。");
}

$username = $_SESSION['username'];

function readCsv($filePath) {
    $rows = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // ユーザー名を読み飛ばして、残りのデータを配列に追加
            array_shift($data); // 先頭のユーザー名を削除
            $rows[] = $data;
        }
        fclose($handle);
    }
    return $rows;
}

header('Content-Type: application/json');

// ユーザーごとのCSVファイルのパス
$resultDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/dogleg2/result/" . $username;
$resultFiles = array_filter(glob($resultDir . '/*.csv'), 'is_file');

$resultData = [];
foreach ($resultFiles as $file) {
    $resultData = array_merge($resultData, readCsv($file));
}

// 回数を上から順に割り振る
foreach ($resultData as $index => &$row) {
    array_unshift($row, $index + 1); // 回数を先頭に追加
}

echo json_encode($resultData);
?>