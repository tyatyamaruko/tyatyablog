<?php

use cebe\markdown\MarkdownExtra;

require_once "./vendor/autoload.php";
require("./admin/env.php");
require("./models/tech-article.php");
require("./models/Comment.php");

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
    $data = [];
    $article = "";

    while ($row = $stmt->fetch()) {
        $article = new TechArticle($row);
    }
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from " . COMMENT_TABLE . " where article_id = ? order by created_at desc";

    $stmt = $pdo->prepare($sql);
    $data[] = $id;
    $stmt->execute($data);

    $comments = [];

    while ($row = $stmt->fetch()) {
        $comments[] = new Comment($row);
    }
    $data = [];
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


<?php @include("./assets/hd.php") ?>


<body>
    <?php @include("./assets/header.php"); ?>

    <main class="detail">
        <?php @include("./assets/sidemenu.php"); ?>
        <div class="content">
            <div class="title">
                <?= $article->title ?>
            </div>
            <?= htmlspecialchars_decode($markdown) ?>
        </div>

        <div class="comment-area">
            <ul>
                <?php foreach($comments as $comment) : ?>
                <li>
                    <p class="id">id: <?= $comment -> id ?></p>
                    <p class="username">コメ主：<?= $comment -> username ?></p>
                    <p class="comment"><?= $comment -> comment ?></p>
                    <p class="created_at"><?= $comment -> createdAt ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <label class="comment-btn" for="comment-check">
            <i class="fas fa-comment"></i>
        </label>
    </main>

    <input type="checkbox" id="comment-check">

    <label class="comment-field" for="comment-check">
        <form action="./comment-post.php" method="post">
            <input type="hidden" name="articleId" value="<?= $id ?>">
            <input type="text" name="username" placeholder="表示用の名前を入力してください">
            <textarea name="comment" id="mde" placeholder="コメントを入力してください" cols="30" rows="10"></textarea>
            <input type="submit" value="投稿">
            <label for="comment-check">閉じる</label>
        </form>
    </label>

</body>

</html>