<?php
session_start();

// セッションが存在しない場合にエラーを表示
if (!isset($_SESSION['username'])) {
    exit("セッションが開始されていないか、ユーザー名が設定されていません。");
}

if (isset($_POST['image']) && isset($_POST['type']) && isset($_POST['sessionFolder'])) {
    $image = $_POST['image'];
    $type = $_POST['type'];
    $sessionFolder = $_POST['sessionFolder'];
    $studentName = $_SESSION['username'];  
    $dir = './process/' . $studentName . '/' . $sessionFolder;

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $data = base64_decode($image);

    // 現在の時刻を取得
    $timestamp = date('Ymd_His');  // YYYYMMDD_HHMMSS形式

    // ファイル名の設定
    if ($type === 'save1') {
        $filename = 'draw_' . $studentName . '_' . $timestamp . '.jpeg';
    } elseif ($type === 'save2') {
        $filename = 'calculate_' . $studentName . '_' . $timestamp . '.jpeg';
    } else {
        exit("Invalid type specified.");
    }

    $file = $dir . '/' . $filename;

    if (file_put_contents($file, $data) === false) {
        exit("画像の保存に失敗しました。");
    }

    echo "画像が保存されました。ファイル名: " . $filename;

    // 画像が保存された後に、同じセッションの draw ファイルを last フォルダにコピー (上書き)
    if ($type === 'save1') { // 描画キャンバスの画像が保存された場合
        $lastDir = './last';

        // lastフォルダが存在しない場合は作成
        if (!is_dir($lastDir)) {
            mkdir($lastDir, 0777, true);
        }

        // lastフォルダにファイルをコピー (既存のファイルがある場合は上書き)
        $destinationPath = $lastDir . '/draw_' . $studentName . '_' . $sessionFolder . '.jpeg';
        if (!copy($file, $destinationPath)) {
            exit("ファイルのコピーに失敗しました。");
        }
        echo "ファイルがlastフォルダにコピーされました。ファイル名: " . basename($destinationPath);
    }

} else {
    exit("必要なデータがPOSTされていません。");
}
?>