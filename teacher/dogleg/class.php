<?php
// エラー表示を有効化
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 画像が保存されているフォルダ（相対パス）
$folder = "/MathCanvas/student/dogleg2/last/";

$absoluteFolder = $_SERVER['DOCUMENT_ROOT'] . $folder;

if (!is_dir($absoluteFolder)) {
    echo json_encode(['error' => '指定されたフォルダが存在しません。']);
    exit;
}

// フォルダ内のファイル一覧を取得
$files = array_diff(scandir($absoluteFolder), array('.', '..'));

if (empty($files)) {
    echo json_encode(['error' => 'フォルダに画像ファイルがありません。']);
    exit;
}

// 画像ファイルのみをフィルタリング
$images = array_filter($files, function($file) use ($absoluteFolder) {
    $filePath = $absoluteFolder . $file;
    return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
});

if (empty($images)) {
    echo json_encode(['error' => '画像ファイルが見つかりませんでした。']);
    exit;
}

// ファイル名をソートして時系列順に並べる
usort($images, function($a, $b) use ($absoluteFolder) {
    return filemtime($absoluteFolder . $a) - filemtime($absoluteFolder . $b);
});

// 画像の相対パスを取得してJSONで返す
$images = array_map(function($file) use ($folder) {
    return $folder . $file;
}, $images);

// 出力前にバッファの確認と出力
header('Content-Type: application/json');
echo json_encode(['images' => $images]);
exit;
?>