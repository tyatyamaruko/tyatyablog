<?php

use cebe\markdown\MarkdownExtra;

require_once "../../vendor/autoload.php";
require("../env.php");
require("../../models/tech-article.php");

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

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>
    <title>ちゃちゃブログ｜<?= $article->title ?></title>
</head>

<body>
    <?php @include("./assets/header.php"); ?>
    <main class="detail">
        <nav>
            <ul>
                <li><a href="./update.php?id=<?= $id ?>">編集する</a></li>
                <li class="delete">
                    <p>削除する</p>
                </li>
            </ul>
        </nav>
        <div class="content">
            <div class="title">
                <?= $article->title ?>
            </div>
            <?= $markdown ?>
        </div>

        <div class="conf-delete">
            <div class="screen">
                <h2>本当に削除してもよろしいですか？</h2>
                <p>
                    削除した記事は復元することができません。<br>
                    もう一度同じ内容を投稿する場合は最初から書き直すことになります。<br>
                    削除する場合は「はい」、削除しない場合は「いいえ」を押してください。
                </p>
                <div class="button">
                    <a class="no" href="">いいえ</a>
                    <a class="yes" href="./delete.php?id=<?= $article->id ?>">はい</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(function() {
            let pre = $("pre");
            pre.addClass("prettyprint");

            $(".delete").on("click", function() {
                $(".conf-delete").css("display", "block");
            });

            $(".conf-delete").on("click", function() {
                $(this).css("display", "none");
            });

            $(".no").on("click", function() {
                $(".conf-delete").css("display", "none");
            });
        });
    </script>
</body>

</html>