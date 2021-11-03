<?php
if (isset($_GET["type"]) && $_GET["type"] != "") {
    $type = $_GET["type"];
} else {
    header("Location: index.php");
    exit;
}

require_once "./models/tech-article.php";
require_once "./admin/env.php";

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from techarticles where type=? order by created_at desc";

    $stmt = $pdo->prepare($sql);
    $data[] = $type;
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


// sidemenu用
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

<?php @include("./assets/hd.php") ?>

<body>
    <?php @include("./assets/header.php"); ?>
    <main id="list">
        <?php @include("./assets/sidemenu.php"); ?>

        <div class="contents">
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
                <p class="no-lang">まだ<?= $type ?>の記事は投稿されていません</p>
            <?php endif; ?>
        </div>

        <div class="adsense"></div>
    </main>
</body>

</html>