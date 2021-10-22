<?php

require_once "../../models/tech-article.php";

// データベースに保存
$dsn = "mysql:dbname=tyatyablog;host=localhost;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from techarticles where 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);

    $articles = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $articles[] = new TechArticle($row);
    }

    // var_dump($articles);/
} catch (PDOException $e) {
    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>管理画面</title>
</head>

<body>
    <ul>
        <?php foreach ($articles as $article) { ?>
            <li>
                <a href="./detail.php?id=<?=$article -> id?>">
                    <h2><?= $article->title ?></h2>
                    <p><?= $article->genre ?></p>
                    <p>投稿日：<?= $article->created_at ?></p>
                </a>
            </li>
        <?php } ?>
    </ul>
</body>

</html>