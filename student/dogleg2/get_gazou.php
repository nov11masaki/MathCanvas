<?php

$dir = '../student/dogleg2/last/';

$images = [];

if (is_dir($dir)) {
    // フォルダが存在するか確認
    $sessionFolders = array_filter(glob($dir . '/*'), 'is_dir');

    if (!empty($sessionFolders)) {
        foreach ($sessionFolders as $folder) {
            // JPEG画像を取得
            $files = glob($folder . '/*.jpeg');

            if (!empty($files)) {
                // ファイルを更新日時でソート
                usort($files, function($a, $b) {
                    return filemtime($a) - filemtime($b);
                });

                // フォルダと画像を配列に追加
                $images[] = [
                    'folder' => basename($folder),
                    'images' => $files
                ];
            }
        }
    }
}

// デバッグ用のHTML出力はせず、JSONデータのみを返す
header('Content-Type: application/json');
echo json_encode($images);
?>