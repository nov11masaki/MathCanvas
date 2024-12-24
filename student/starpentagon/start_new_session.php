<?php
session_start();

$studentName = $_SESSION['username'];
$dir = './process/' . $studentName;

// ユーザーのフォルダが存在しない場合は作成
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// 現在のセッションフォルダの数を取得して新しいフォルダ名を設定
$sessionFolders = array_filter(glob($dir . '/*'), 'is_dir');
$sessionCount = count($sessionFolders) + 1;
$newSessionFolder = $sessionCount . '回目';

// 新しいセッションフォルダを作成
$newDir = $dir . '/' . $newSessionFolder;
if (!is_dir($newDir)) {
    mkdir($newDir, 0777, true);
}

// フォルダ名を返す
echo $newSessionFolder;
?>