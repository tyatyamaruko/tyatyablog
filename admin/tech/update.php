<?php

session_start();
session_regenerate_id(true);

require("../env.php");
require("../../models/tech-article.php");

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}


$errors = $_SESSION['error'];
$_SESSION["error"] = array();

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
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.js"></script>
    <title>技術ブログ編集画面</title>
</head>

<body>
    <form action="update_check.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <p class="err"><?= $errors["title"] ?></p>
        <label for="title">
            <p>タイトル(64文字まで)</p>
            <input type="text" name="title" id="title" value="<?= $article -> title ?>">
        </label>
        <p class="err"><?= $errors["genre"] ?></p>
        <label for="genre">
            <p>ジャンル</p>
            <select name="genre" id="genre">
                <?php foreach ($GENRES as $genre): ?>
                    <option value="<?= $genre ?>" <?= $genre == $article->genre ? "selected" : "" ?>><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        
        <p class="err"><?= $errors["markdown"] ?></p>
        <textarea name="markdown" id="mde"><?= $article -> markdown ?></textarea>

        <div class="btn">
            <div class="back-btn">
                <a href="./list.php">戻る</a>
            </div>
            <div class="post-btn">
                <input type="submit" value="投稿">
            </div>
        </div>

    </form>

    <script>
        const mde = new SimpleMDE({
            element: document.getElementById("mde")
        });
    </script>
</body>

</html>