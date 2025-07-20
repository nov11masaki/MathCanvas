<!DOCTYPE html>
<html>
<head>
<base target="_top">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MathCanvas ログイン</title>
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
    select, button {
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
  <h1>MathCanvas ログイン</h1>
  <h3>使うユーザー名を選択してください。</h3>
  <form action="student/top.php" method="post">
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
      <<option>student18</option>
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
      <option>teacher1</option>
      <option>teacher2</option>
      <option>teacher3</option>
      <option>teacher4</option>
      <option>testuser1</option>
    </select>
    <button type="submit">ログイン</button>
  </form>
  <div class="teacher-link">
    <CENTER><a href="./teacher/teacher_login.php">MathCanvas for Teacher</a></CENTER>
  </div>
</div>
</body>
</html>