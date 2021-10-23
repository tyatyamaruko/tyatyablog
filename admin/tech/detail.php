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
$markdown = $markdownConverter -> parse($article -> markdown);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ちゃちゃブログ｜<?= $article->title ?></title>
</head>

<body>
<?= $markdown ?>
</body>

</html>