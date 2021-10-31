<?php
if (isset($_GET["lang"]) && $_GET["lang"] != "") {
    $lang = $_GET["lang"];
} else {
    exit("言語が指定されていません");
}

require_once "./models/tech-article.php";
require_once "./admin/env.php";

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from techarticles where genre=? order by created_at desc";

    $stmt = $pdo->prepare($sql);
    $data[] = $lang;
    $stmt->execute($data);

    $select_articles = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $select_articles[] = new TechArticle($row);
    }

    // var_dump($articles);/
} catch (PDOException $e) {
    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

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
    <title>ちゃちゃブログ｜<?= $lang ?>記事</title>
</head>

<body>
    <?php @include("./assets/header.php"); ?>
    <main id="list">
        <?php @include("./assets/sidemenu.php"); ?>

        <?php if (count($select_articles)) : ?>
            <ul>
                <?php foreach ($select_articles as $select_article) : ?>
                    <li>
                        <a href="./article.php?id=<?= $select_article->id ?>">
                            <h2><?= $select_article->title ?></h2>
                            <p>言語：<?= $select_article->genre ?></p>
                            <p>投稿日：<?= $select_article->created_at ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-lang">まだ<?= $lang ?>の記事は投稿されていません</p>
        <?php endif; ?>

        <div class="adsense"></div>
    </main>
</body>

</html>