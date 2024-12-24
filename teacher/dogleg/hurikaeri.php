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
        h2, h3 {
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
    </style>
</head>
<body>
    <form method="post" action="hurikaeri.php">
            <select name="username">
                <option>testuser1</option>
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
                <option>student18</option>
                <option>student19</option>
                <option>student20</option>
                <option>student21</option>
                <option>student22</option>
                <option>student23</option>
                <option>student24</option>
                <option>student25</option>
                <option>student26</option>
                <option>student27</option>
                <option>student28</option>
                <option>student29</option>
                <option>student30</option>
                <option>student31</option>
                <option>student32</option>
                <option>student33</option>
                <option>student34</option>
                <option>student35</option>
                <option>student36</option>
                <option>student37</option>
                <option>student38</option>
                <option>student39</option>
                <option>student40</option>
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
    <div align="right"><a href="https://nov11masaki.main.jp/MathCanvas/teacher/top.html">Topに戻る</a></div>

    <div class="container">
        <div class="image-section">
            <h3>過程の画像</h3>
            <?php
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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                
                // 画像ファイルの表示
                $imageDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/dogleg2/process/" . $username;
                
                // 各セッションフォルダを取得
                if (is_dir($imageDir)) {
                    $sessionFolders = array_filter(glob($imageDir . '/*'), 'is_dir');
                    foreach ($sessionFolders as $folder) {
                        $folderName = basename($folder);
                        echo "<h4>{$folderName}</h4>";
                        $imageFiles = getFiles($folder, ['jpg', 'jpeg', 'png', 'gif']); // 画像の拡張子を指定
                        
                        if (!empty($imageFiles)) {
                            // ファイルを作成日時でソート
                            usort($imageFiles, function($a, $b) {
                                return filemtime($a) - filemtime($b);
                            });
                            echo "<div class='image-container'>";
                            foreach ($imageFiles as $image) {
                                echo "<img src='/MathCanvas/student/dogleg2/process/" . $username . "/" . $folderName . "/" . basename($image) . "' alt='Image'>";
                            }
                            echo "</div>";
                        } else {
                            echo "<p>画像ファイルが見つかりませんでした。</p>";
                        }
                    }
                } else {
                    echo "<p>セッションフォルダが見つかりませんでした。</p>";
                }
            }
            ?>
        </div>

        <div class="review-section">
            <div class="section">
                <h3>考え方ごとの振り返り</h3>
                <?php
                $resultDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/dogleg2/result/" . $username;
                $resultFiles = getFiles($resultDir, ['csv']);

                $resultData = [];
                foreach ($resultFiles as $file) {
                    $resultData = array_merge($resultData, readCsv($file));
                }
                // 回数を上から順に割り振る
                foreach ($resultData as $index => &$row) {
                array_unshift($row, $index + 1); // 回数を先頭に追加
                }

                if (!empty($resultData)) {
                    echo "<table>";
                    echo "<tr><th>回数</th><th>username</th><th>time</th><th>自己評価</th><th>考え方について</th><th>補助線を引いた意図</th></tr>";
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
                $reviewDir = $_SERVER['DOCUMENT_ROOT'] . "/MathCanvas/student/dogleg2/review/" . $username;
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