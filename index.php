<?php
require_once "./models/tech-article.php";
require_once "./admin/env.php";

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "select * from techarticles where 1 order by created_at desc limit 5";

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
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>ちゃちゃブログ</title>
</head>

<body>
    <?php @include("./assets/header.php"); ?>
    <main id="index">
        <?php @include("./assets/sidemenu.php"); ?>

        <div class="container">
            <article class="top">
                <h2>Hello World</h2>

                <article class="description">
                    <p>
                        本サイトは主に技術ブログとして更新していく予定ではありますが、筆者の気分によってかなりの確率で愛犬についての投稿になる可能性があります。<br>
                        また、技術ブログはWEB系(<span>HTML</span>, <span>CSS</span>, <span>JavaScript</span>, <span>PHP</span>)と
                        ネイティブアプリ(特に<span>Swift</span>)やその周辺についての投稿が主になりますが、
                        興味を持ったことについての投稿もたまにする予定です。<br>
                        おもしろおかしく記事を書いて行けたらいいなと思っておりますので是非クスッと笑いながら読んでいただけますと光栄です。
                    </p>
                </article>
            </article>
        </div>

        <div class="adsense"></div>
    </main>

    <footer>

    </footer>
</body>

</html>