<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>イチオシお菓子教えちゃう</title>
<style>
    h1 {
        color:#696969
/*少しずらしたボックス*/
	margin: 2em auto;
	padding:2em;/*内側の余白*/
	background: none;/*元のボックス背景色なし*/
	border:1px solid #b0c4de ;/*線の太さ・種類・色*/
	position: relative;/*配置（基準）*/
    }
    h1:after{
	background-color:#f0f8ff;/*ずらしたボックスの背景色*/
	border:none;
	content: '';
	position: absolute;/*配置（ここを動かす）*/
	top: 7px;/*上から7pxずらす*/
	left: 7px;/*左から7pxずらす*/
	width: 100%;
	height: 100%;
	z-index: -1;
    }
/*方眼紙風*/
body {
    margin: 0;
    padding: 0;
    height: 100vh; /* ビューポートの高さを設定 */
    display: flex;
    justify-content: center; /* 横方向の中央配置 */
    align-items: center; /* 縦方向の中央配置 */
    background-image: linear-gradient(0deg, transparent 19px, #e6e6fa 20px),linear-gradient(90deg, transparent 19px, #e6e6fa 20px);
    background-size:  20px 20px;
    font-family: Arial, sans-serif;
}

.box1-4 {
    padding: 2em;
    border: dotted 5px #e2c2b3; /* 線の種類・太さ・色 */
    background-color: #f9f9f9; /* 背景色 */
    border-radius: 8px; /* 角を丸くする */
    width: 600px; /* 幅を設定 */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* シャドウを追加 */
}

h1 {
    color: #4682b4;
    text-align: center; /* 見出しを中央に配置 */
    margin: 0 0 20px 0;
}

form {
    display: flex;
    flex-direction: column; /* フォーム内の要素を縦に並べる */
    gap: 15px; /* 要素間の隙間 */
}

input[type="text"], input[type="submit"] {
    padding: 10px;
    border: 1px solid #ffe4e1;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #ffe4e1;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #99cccc;
}

.box1-4 {
    padding: 2em;
    border: dotted 5px #e2c2b3; /* 線の種類・太さ・色 */
    background-color: #ffffff; /* 背景色 */
    border-radius: 8px; /* 角を丸くする */
    width: 400px; /* 幅を設定 */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* シャドウを追加 */
}

h1 {
    color: #696969;
    text-align: center; /* 見出しを中央に配置 */
    margin: 0 0 20px 0;
}

form {
    display: flex;
    flex-direction: column; /* フォーム内の要素を縦に並べる */
    gap: 15px; /* 要素間の隙間 */
}

input[type="text"], input[type="submit"] {
    padding: 10px;
    border: 1px solid #e2c2b3;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    background-color:linear-gradient(to bottom, #87ceeb 0px, #e5ccff 100%) repeat scroll 0 0 transparent;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 6px;
    color: #000000;
    cursor: pointer;
    display: block;
    margin: 0 auto;
    padding: 10px 25px;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #ffb7db;
}

/* 掲示板部分のスタイル */
.table-box {
    margin-top: 20px;
    padding: 2em;
    border: dotted 5px #e2c2b3; /* 線の種類・太さ・色 */
    background-color: #ffffff; /* 背景色 */
    border-radius: 8px; /* 角を丸くする */
    width: 800px; /* 幅を設定 */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* シャドウを追加 */
    overflow-x: auto; /* テーブルがはみ出した時の横スクロール */
}

table {
    width: 100%;
    border-collapse: collapse; /* テーブルの重なりを解消 */
}

table th, table td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ccc; /* セルに枠線を追加 */
}

table th {
    background-color: #f1f1f1; /* ヘッダー行の背景色 */
}

table td {
    background-color: #fff0f5; /* データ行の背景色 */
}

table td span {
    color: #000000;
}
</style>
<script>
/*タイムアウトの設定*/
    setTimeout(function() {
        window.location.href = "m6-logout.php"; // コード2のファイル名に変更
    }, 1800000); // 30分（1800000ミリ秒）
</script>

</head>
<body>
<?php
// DB接続設定
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//変数を初期化
    $edit_id = '';
    $edit_name = '';
    $edit_comment = '';
//編集表示処理
        if( !empty( $_POST["edit_id"] ) && isset($_POST["edit"])){
            $edit_id = $_POST["edit_id"];
            //該当の行を取得
            $sql = 'SELECT * FROM t_board WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  
            $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT); 
            $stmt->execute();
            $results = $stmt->fetchAll();  
                 
                foreach ($results as $row){
                    if($row){
                    $edit_name = $row['name'];
                    $edit_comment = $row['comment'];
                     }
                 }
         }
?>

    <div class="box1-4">

    <h1>お菓子のイチオシ共有掲示板</h1>
    -投稿フォーム-
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前を入力" value="<?php echo $edit_name; ?>">
        <input type="text" name="comment" placeholder="コメントを入力" value="<?php echo $edit_comment; ?>">
        <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
        <input type="submit" name="submit" value="投稿">
    </form>
    <br>
    <br>
     
     
    <form action="" method="post" >
        -削除フォーム-
        <input type="text" name="delete_id" placeholder="削除したい投稿番号を入力">
        <input type="submit" name="delete"  value="削除" >
    </form>
    <br>
    <br>
 
    <form action="" method="post" >
        -編集フォーム-
        <input type="text" name="edit_id" placeholder="編集したい投稿番号を入力">
        <input type="submit" name="edit"  value="編集" >
    </form>
    <br>
    <br>

    </div>
</body>
</html>
<?php
     // 新規投稿処理か編集処理か
     if (!empty($_POST['name']) && !empty($_POST['comment'])) {
         $name = $_POST['name'];
         $comment = $_POST['comment'];
         $date = date("Y/n/j G:i:s");

         // 編集処理
         if (!empty($_POST['edit_id'])) {
             $edit_id = $_POST["edit_id"];
             $sql = 'UPDATE t_board SET name=:name, comment=:comment, datetime=:datetime WHERE id=:id';
             $stmt = $pdo->prepare($sql);
             $stmt->bindParam(':name', $name, PDO::PARAM_STR);
             $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
             $stmt->bindParam(':datetime', $date, PDO::PARAM_STR);
             $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT); 
             $stmt->execute();
         } else {
             $sql = "INSERT INTO t_board (name, comment, datetime) VALUES (:name, :comment, :datetime)";
             $stmt = $pdo->prepare($sql);
             $stmt->bindParam(':name', $name, PDO::PARAM_STR);
             $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
             $stmt->bindParam(':datetime', $date, PDO::PARAM_STR);
             $stmt->execute();
         }
     }

     // 投稿削除処理
     if (!empty($_POST["delete_id"])) {
         $delete_id = $_POST["delete_id"];
         $sql = 'DELETE FROM t_board WHERE id=:id';
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
         $stmt->execute();
     }
     
     // 投稿を表示する
     $sql = 'SELECT * FROM t_board';
     $stmt = $pdo->query($sql);
     $results = $stmt->fetchAll();
?>

<div class="table-box">
    <h1>---イチオシお菓子共有し合おう---</h1>
    <table>
        <tr>
            <th>NO.</th>
            <th>NAME</th>
            <th>コメント</th>
            <th>投稿日時</th>
        </tr>

        <?php foreach ($results as $row): ?>
        <tr>
            <td><span><?php echo $row[0]; ?></span></td>
            <td><b><?php echo $row[1]; ?></b></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[3]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>