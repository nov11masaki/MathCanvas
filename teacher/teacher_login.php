<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MathCanvas Teacher ログイン</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }
    h1, h3 {
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    input, button {
        margin: 10px 0;
        padding: 10px;
        width: 100%;
        max-width: 300px;
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
  <h1>MathCanvas Teacher ログイン</h1>
  <h3>教師アカウントでログインしてください。</h3>
  <form action="teacher_login_handler.php" method="post">
    <input type="text" name="teacher_username" placeholder="ユーザー名" required>
    <input type="password" name="teacher_password" placeholder="パスワード" required>
    <button type="submit">ログイン</button>
  </form>
</div>
</body>
</html>