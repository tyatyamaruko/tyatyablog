<?php
if ((isset($_GET["type"]) && $_GET["type"] != "") || (isset($_GET["genre"]) && $_GET["genre"] != "")) {
    $type = $_GET["type"];
    $selectedGenre = $_GET['genre'];
} else {
    header("Location: index.php");
    exit;
}
var_dump($selectedGenre);
require_once "./models/tech-article.php";
require_once "./admin/env.php";

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($selectedGenre !== "all") {
        $sql = "select * from techarticles where type=? and genre=? order by created_at desc";
    } else {
        $sql = "select * from techarticles where type=? order by created_at desc";
    }
    // $sql = "select * from techarticles where type=? and genre=? order by created_at desc";

    $stmt = $pdo->prepare($sql);
    $data[] = $type;
    if ($selectedGenre != "all") {
        $data[] = $selectedGenre;
    }
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
var_dump($sql);


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
            <?php if ($type == 1) : ?>
                <form action="./list.php" method="get">
                    <input type="hidden" name="type" value=1>
                    <select name="genre" id="genre">
                        <?php foreach ($GENRES as $i => $genre) : ?>
                            <?php if ($i != Count($GENRES) - 1) : ?>
                                <option <?= $genre == $selectedGenre ? "selected" : "" ?> value="<?= $genre ?>"><?= $genre ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="検索">
                </form>
            <?php endif; ?>

            <?php if (count($select_articles)) : ?>
                <ul class="user-article">
                    <?php foreach ($select_articles as $select_article) : ?>
                        <li class="user-article__item">
                            <a href="./article.php?id=<?= $select_article->id ?>">
                                <span class="user-article__icon">
                                    <?= $select_article->getGenreImage(); ?>
                                </span>
                                <div>
                                    <h2><?= $select_article->title ?></h2>
                                    <p>ジャンル：<?= $select_article->genre ?></p>
                                    <p>投稿日：<?= $select_article->created_at ?></p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="no-lang">まだ記事は投稿されていません</p>
            <?php endif; ?>
        </div>

        <div class="adsense"></div>

    </main>
</body>

</html>