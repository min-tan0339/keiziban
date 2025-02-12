<?php
session_start();

if (isset($_SESSION["NAME"])) {
    $errorMessage = "ログアウトしました。";
} else {
    $errorMessage = "セッションがタイムアウトしました。";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
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

    <head>
        <meta charset="UTF-8">
        <title>ログアウト</title>
    </head>
    <body>
        <h1>ログアウト画面</h1>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="m6_login.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>
