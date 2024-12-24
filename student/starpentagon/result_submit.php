<?php
session_start();
include 'save_csv.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $time = date('Y-m-d H:i:s');

    $hyoka = $_POST['hyoka'];
    $idea = $_POST['idea'];
    $support_line_reason = $_POST['support_line_reason']; // "なぜその補助線を引こうと考えたか"の回答を取得

    // データを配列にまとめる
    $data = [$username, $time, $hyoka, $idea, $support_line_reason];

    // データを保存
    save_csv('result', $username, $data);

    // 確認ページにリダイレクト
    header('Location: result_confirm.php');
    exit();
} else {
    echo "無効なリクエストです。";
}
?>