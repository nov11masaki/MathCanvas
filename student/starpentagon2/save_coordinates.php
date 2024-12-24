<?php
session_start();

$directory = 'zahyo';
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

// セッションが存在しない場合にエラーを表示
if (!isset($_SESSION['username'])) {
    exit("セッションが開始されていないか、ユーザー名が設定されていません。");
}

$username = $_SESSION['username'];
$timestamp = time();
$filename = $directory . '/' . $username . '_' . $timestamp . '.csv';

$csvData = $_POST['csvData'];
file_put_contents($filename, $csvData);

echo "座標データが保存されました: " . $filename;
?>