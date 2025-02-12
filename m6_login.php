<?php
session_start();

// DB接続設定
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
try {
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die('接続失敗：' . $e->getMessage());
}

// エラーメッセージ初期化
$msg = '';

// ログイン処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];

        // メールアドレスでユーザーを検索
        $sql = "SELECT * FROM t_login WHERE mail = :mail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetch();

        // パスワードの確認
        if ($member && password_verify($pass, $member['pass'])) {
            // セッションにユーザー情報を格納
            $_SESSION['user_id'] = $member['id'];
            $_SESSION['user_name'] = $member['name'];

            // ログイン成功時、マイページへリダイレクト
            header('Location: m6-02.php');
            exit;
        } else {
            $msg = 'メールアドレスまたはパスワードが違います。';
        }
    } else {
        $msg = 'メールアドレスとパスワードを入力してください。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>イチオシログインフォーム</title>
<style>
    /* スタイルはそのまま使用 */
    body {
        background: #e6e6fa;
        font-family: "Open Sans";
    }

    h1 {
        text-align: center;
    }

    .login {
        width: 300px;
        margin: 0 auto;
    }

    .login form {
        width: 100%;
    }

    input {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: 4px;
        color: #FFFFFF;
        font-size: 13px;
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
    }

    button {
        background: linear-gradient(to bottom, #87ceeb 0px, #ffb6c1 100%) repeat scroll 0 0 transparent;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: 6px;
        color: #f5f5f5;
        cursor: pointer;
        display: block;
        margin: 0 auto;
        padding: 10px 25px;
        width: 100%;
    }
</style>
</head>
<body>

<h1>ログイン</h1>

<?php if (!empty($msg)) : ?>
    <p style="color: red;"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></p>
<?php endif; ?>

<div class="login">
  <form method="post">
    <input type="email" name="mail" placeholder="e-mail@address" required="required" />
    <input type="password" name="pass" placeholder="Password" required="required" />
    <button type="submit">Login</button>
  </form>
  <p>新規登録は<a href="m6-new.php">こちら</a></p>
</div>

</body>
</html>
