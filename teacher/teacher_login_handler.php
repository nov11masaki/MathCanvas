<?php
// サンプル用のハードコーディングされた認証情報
$valid_username = 'teacher';
$valid_password = '123';

// POSTデータを取得
$username = $_POST['teacher_username'];
$password = $_POST['teacher_password'];

// 認証情報を検証
if ($username === $valid_username && $password === $valid_password) {
    // ログイン成功時にトップページにリダイレクト
    header("Location: top.html");
    exit();
} else {
    // ログイン失敗時にログインページにリダイレクト
    header("Location: teacher_login.php?error=1");
    exit();
}
?>