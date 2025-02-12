<?php
session_start();

// DB接続
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
try {
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die('接続失敗：' . $e->getMessage());
}
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$msg = '';
$link = '';

if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])) {
        // フォームからの値をそれぞれ変数に代入
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // パスワードをハッシュ化

        // メールアドレスの重複チェック
        $sql = "SELECT * FROM t_login WHERE mail = :mail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $member = $stmt->fetch();

        if ($member) {
            $msg = '同じメールアドレスが存在します。';
            $link = '<a href="m6-new.php">戻る</a>';
        } else {
            // 登録されていなければinsert
            $sql = "INSERT INTO t_login (name, mail, pass) VALUES (:name, :mail, :pass)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);

            if ($stmt->execute()) {
                // 登録成功時にメッセージをセッションに保存し、ログイン画面にリダイレクト
                $_SESSION['register_msg'] = '新規登録しました';
                header('Location: m6_login.php');
                exit;
            } else {
                // エラー発生時
                $msg = 'エラーが発生しました。' . print_r($stmt->errorInfo(), true);
            }
        }
    } else {
        $msg = '全ての項目を入力してください。';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>イチオシ新規会員登録フォーム</title>
    <style>
        /* CSSはここに書く */
        
 

        body {
            text-align: center;
            background: #e6e6fa;
            font-family: "Open Sans";
        }
   .loading .circle {
        border-radius: 100%;
        position: absolute;
    }

    .loading .circle.dark {
        background-color: #87ceeb;
        height: 22px;
        left: 1px;
        top: 10px;
        width: 22px;
    }

    .loading .circle.light {
        background-color: #ffb6c1;
        height: 25px;
        right: 1px;
        top: 8px;
        width: 25px;
    }

        .login {
            width: 300px;
            margin: 0 auto;
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
    <h1>新規登録画面</h1>

    <div class="login">
        <?php 
        if (!empty($msg)) {
            echo "<p>{$msg}</p>";
            if (!empty($link)) {
                echo "<p>{$link}</p>";
            }
        }
        ?>

        <form action="m6-new.php" method="post">
            <input type="text" name="name" placeholder="Username" required="required" />
            <input type="email" name="mail" placeholder="e-mail@address" required="required" />
            <input type="password" name="pass" placeholder="Password" required="required" />
            <button type="submit" name="submit">新規会員登録</button>
        </form>
        <p>すでに登録済みの方は<a href="m6_login.php">こちら</a></p>
    </div>
</body>
</html>
