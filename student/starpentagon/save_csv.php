<?php
session_start();

function save_csv($folder, $username, $data) {
    // フォルダのパス
    $folderPath = $folder . '/' . $username;

    // フォルダが存在しない場合は作成
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // 現在の日時を取得してフォーマット
    $timestamp = date('Ymd_His');

    // CSVファイルのパス
    $filePath = $folderPath . '/' . $username . '_' . $timestamp . '.csv';

    // CSVファイルが存在しない場合は、UTF-8のBOM付きで新規作成
    $isNewFile = !file_exists($filePath);
    $file = fopen($filePath, 'a');

    // 新規作成の場合はBOMを追加
    if ($isNewFile) {
        // UTF-8のBOMを追加（Excelなどでの文字化け防止）
        fwrite($file, "\xEF\xBB\xBF");
    }

    // データをUTF-8に変換してCSVに書き込む
    $encoded_data = array_map(function($field) {
        return mb_convert_encoding($field, 'UTF-8', 'auto');
    }, $data);

    // CSVファイルに書き込む
    fputcsv($file, $encoded_data);

    // ファイルを閉じる
    fclose($file);
}
?>