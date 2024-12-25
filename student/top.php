<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
} elseif (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <base target="_top">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MathCanvas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            text-align: center;
        }
        a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 5px;
            text-decoration: none;
            color: #000;
        }
        a:hover {
            background-color: #e0e0e0;
        }
        .username {
            text-align: right;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>MathCanvasへようこそ</h1>
    <div class="username"><h3><?php echo htmlspecialchars($username); ?> さん</h3></div>
    <h2>中学校(数学)</h2>
    <a href="pentagon/draw1.html">多角形の内角の和</a>
    <a href="dogleg2/draw1.html">くの字型の角</a>
    <a href="starpentagon/draw1.html">星形五角形の内角の和(CD)</a>
    <a href="starpentagon2/draw1.html">星形五角形の内角の和(AB)</a>
</div>
</body>
</html>