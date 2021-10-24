<?php

use cebe\markdown\MarkdownExtra;

require_once "./vendor/autoload.php";
require("./admin/env.php");
require("./models/tech-article.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    exit("記事のIDが指定されていません。IDを指定してください");
}

$id = htmlspecialchars($id);

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from " . TECH_TABLE . " where id=?";

    $stmt = $pdo->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);
    $article = "";

    while ($row = $stmt->fetch()) {
        $article = new TechArticle($row);
    }
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

$markdownConverter = new MarkdownExtra();
$markdown = $markdownConverter->parse($article->markdown);


try {
    $sql = "select * from techarticles where 1 order by created_at desc limit 5";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

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
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/detail.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>
    <title>ちゃちゃブログ｜<?= $article->title ?></title>
</head>

<body>
    <header>
        <h1>ちゃちゃブログ</h1>
    </header>

    <main class="detail">
        <nav>
            <ul class="menu">
                <li><a href="./tech.php">技術記事</a></li>
                <li><a href="./tech.php">日常記事</a></li>
                <!-- <li><a href="./tech.php">問い合わせ</a></li> -->
            </ul>

            <ul class="topic">
                <li>
                    <h5>最新記事</h5>
                </li>
                <?php foreach ($articles as $item) : ?>
                    <li>
                        <a href="./article.php?id=<?= $item->id ?>">
                            <p class="title"><?= $item->title ?></p>
                            <p class="date"><?= $item->created_at ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div class="content">
            <div class="title">
                <?= $article->title ?>
            </div>
            <?= $markdown ?>
        </div>
    </main>
    <script>
        $(function() {
            let pre = $("pre");
            pre.addClass("prettyprint");
        });
    </script>
</body>

</html>