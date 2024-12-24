<?php
session_start();
include 'save_csv.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $time = date('Y-m-d H:i:s');  // 現在の時刻を取得
    $kakikomi1 = $_POST['kakikomi1'];
    $kakikomi2 = $_POST['kakikomi2'];
    $kakikomi3 = $_POST['kakikomi3'];

    $data = [$username, $time, $kakikomi1, $kakikomi2, $kakikomi3];

    save_csv('review', $username, $data);

    // 完了ページにリダイレクト
    header('Location: finish.html');
    exit();
} else {
    echo "無効なリクエストです。";
}
?>