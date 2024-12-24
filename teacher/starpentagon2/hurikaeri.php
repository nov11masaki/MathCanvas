<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データの確認</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2, h3, h4 {
            color: #333;
        }
        .container {
            display: flex;
        }
        .image-section, .review-section {
            border: 2px solid #007bff;
            padding: 10px;
            border-radius: 5px;
            margin-right: 20px;
        }
        .image-section {
            flex: 1;
        }
        .review-section {
            flex: 2;
        }
        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .image-container img {
            max-width: 100px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        #result {
                max-height: 500px;
                overflow-y: auto;
        }
    </style>
</head>
<body>
　<form method="post" action="hurikaeri.php">
            <select name="username">
             <option>student01</option>
                <option>student02</option>
                <option>student03</option>
                <option>student04</option>
                <option>student05</option>
                <option>student06</option>
                <option>student07</option>
                <option>student08</option>
                <option>student09</option>
                <option>student10</option>
                <option>student11</option>
                <option>student12</option>
                <option>student13</option>
                <option>student14</option>
                <option>student15</option>
                <option>student16</option>
                <option>student17</option>
                <option>student35</option>
                <option>student36</option>
            </select>
            <br>
            <button type="submit">検索</button>
        </form>
        <br>
        <div id="result">
            <!-- 結果をここに表示 -->
        </div>
    <h2>データの確認 - <?php echo htmlspecialchars($_POST['username']); ?> さん</h2>
    <div align="right"><a href="./hurikaeri.html">生徒ごとの検索</a></div>
    <div align="right"><a href="../top.html">Topに戻る</a></div>

    <div class="container">
        <div class="image-section">
            <h3>過程の画像</h3>
            <?php
            function getDirectories($path) {
                $dirs = glob($path . '/*', GLOB_ONLYDIR);
                usort($dirs, function($a, $b) {
                    return filemtime($a) - filemtime($b);
                });
                return $dirs;
            }

            function getFiles($dir, $extensions) {
                $files = [];
                if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file != "." && $file != ".." && is_file($dir . "/" . $file)) {
                                $fileExt = pathinfo($file, PATHINFO_EXTENSION);
                                if (in_array($fileExt, $extensions)) {
                                    $files[] = $dir . "/" . $file;
                                }
                            }
                        }
                        closedir($dh);
                    }
                }
                return $files;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                
                $imageDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/starpentagon2/process/" . $username;

                $sessionFolders = getDirectories($imageDir);
                foreach ($sessionFolders as $index => $folder) {
                    echo "<h4>" . ($index + 1) . "回目</h4>";

                    $imageFiles = getFiles($folder, ['jpg', 'jpeg', 'png', 'gif']);

                    if (!empty($imageFiles)) {
                        usort($imageFiles, function($a, $b) {
                            return filemtime($a) - filemtime($b);
                        });
                        echo "<div class='image-container'>";
                        foreach ($imageFiles as $image) {
                            echo "<img src='/MathCanvas/student/starpentagon2/process/" . $username . "/" . basename($folder) . "/" . basename($image) . "' alt='Image'>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>画像ファイルが見つかりませんでした。</p>";
                    }
                }
            }
            ?>
        </div>

        <div class="review-section">
            <div class="section">
                <h3>考え方ごとの振り返り</h3>
                <?php
                function readCsv($filePath) {
                    $rows = [];
                    if (($handle = fopen($filePath, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $rows[] = $data;
                        }
                        fclose($handle);
                    }
                    return $rows;
                }

                $resultDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/starpentagon2/result/" . $username;
                $resultFiles = getFiles($resultDir, ['csv']);

                $resultData = [];
                foreach ($resultFiles as $file) {
                    $resultData = array_merge($resultData, readCsv($file));
                }
                
                foreach ($resultData as $index => &$row) {
                    array_unshift($row, $index + 1); 
                }

                if (!empty($resultData)) {
                    echo "<table>";
                    echo "<tr><th>回数</th><th>username</th><th>time</th><th>自己評価</th><th>考え方について</th></tr>";
                    foreach ($resultData as $row) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>考え方ごとの自己評価のデータが見つかりませんでした。</p>";
                }
                ?>
            </div>

            <div class="section">
                <h3>授業の振り返り</h3>
                <?php
                $reviewDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/starpentagon/review/" . $username;
                $reviewFiles = getFiles($reviewDir, ['csv']);

                $reviewData = [];
                foreach ($reviewFiles as $file) {
                    $reviewData = array_merge($reviewData, readCsv($file));
                }

                if (!empty($reviewData)) {
                    echo "<table>";
                    echo "<tr><th>username</th><th>time</th><th>やったこと</th><th>分かったこと</th><th>次にやること</th></tr>";
                    foreach ($reviewData as $row) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>授業の振り返りのデータが見つかりませんでした。</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>