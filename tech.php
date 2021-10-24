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
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/tech.css">
    <title>ちゃちゃブログ｜技術</title>
</head>

<body>
    <header>
        <h1>ちゃちゃブログ</h1>
    </header>
    <main>
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
                <?php foreach ($articles as $article) : ?>
                    <li>
                        <a href="./article.php?id=<?= $article->id ?>">
                            <p class="title"><?= $article->title ?></p>
                            <p class="date"><?= $article->created_at ?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="container">
            <article>
                <h2>ジャンル</h2>

                <ul>
                    <li class="html">
                        <div>
                            <a href="./list.php?lang=html">
                                <img src="./imgs/html-logo.png" alt="">
                                <p>HTML</p>
                            </a>
                        </div>
                    </li>
                    <li class="css">
                        <div>
                            <a href="./list.php?lang=css">
                                <img src="./imgs/css-logo.png" alt="">
                                <p>CSS</p>
                            </a>
                        </div>
                    </li>
                    <li class="js">
                        <div>
                            <a href="./list.php?lang=javascript">
                                <img src="./imgs/js-logo.png" alt="">
                                <p>JavaScript</p>
                            </a>
                        </div>
                    </li>
                    <li class="php">
                        <div>
                            <a href="./list.php?lang=php">
                                <img src="./imgs/php-logo.png" alt="">
                                <p>PHP</p>
                        </div>
                    </li>
                    <li class="swift">
                        <div>
                            <a href="./list.php?lang=swift">
                                <img src="./imgs/swift-logo.jpeg" alt="">
                                <p>Swift</p>
                        </div>
                    </li>
                    <li class="ios">
                        <div>
                            <a href="./list.php?lang=ios">
                                <img src="./imgs/ios-logo.png" alt="">
                                <p>iosアプリ開発</p>
                            </a>
                        </div>
                    </li>
                    <li class="web">
                        <div>
                            <a href="./list.php?lang=web">
                                <img src="./imgs/web-logo.png" alt="">
                                <p>Webアプリ開発</p>
                            </a>
                        </div>
                    </li>
                    <li class="other">
                        <div>
                            <a href="./list.php?lang=other">
                                <img src="./imgs/pro-logo.jpeg" alt="">
                                <p>その他</p>
                            </a>
                        </div>
                    </li>
                </ul>
            </article>
        </div>

        <div class="adsense"></div>
    </main>

    <footer>

    </footer>
</body>

</html>