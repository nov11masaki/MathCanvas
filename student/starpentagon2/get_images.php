<?php
session_start();

if (!isset($_SESSION['username'])) {
    exit("セッションが開始されていないか、ユーザー名が設定されていません。");
}

$studentName = $_SESSION['username'];
$dir = './process/' . $studentName;

$images = [];

if (is_dir($dir)) {
    $sessionFolders = array_filter(glob($dir . '/*'), 'is_dir');

    foreach ($sessionFolders as $folder) {
        $files = glob($folder . '/*.jpeg');
        usort($files, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
        if (!empty($files)) {
            $images[] = [
                'folder' => basename($folder),
                'images' => $files
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($images);
?>
