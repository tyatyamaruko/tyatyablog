<?php
require_once "../env.php";


session_start();
session_regenerate_id(true);

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$errors = $_SESSION['error'];
$_SESSION["error"] = array();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.js"></script>
    <title>技術ブログ投稿画面</title>
</head>

<body>
    <form class="article-form" action="insert_check.php" method="post">
        <ul>
            <li class="article-form__error">
                <?= $errors["title"] ?>
            </li>
            <li class="article-form__input">
                <p>タイトル(64文字まで)</p>
                <input type="text" name="title" id="title">
            </li>
            <li class="article-form__error">
                <?= $errors["genre"] ?>
            </li>
            <li class="article-form__input">
                <p>ジャンル</p>
                <select name="genre" id="genre">
                    <?php foreach ($GENRES as $genre) : ?>
                        <?php if ($genre != "all") : ?>
                            <option value="<?= $genre ?>"><?= $genre ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="article-form__input">
                <p>記事のタイプ</p>
                <select name="type" id="type">
                    <option value=1>技術</option>
                    <option value=0>日常</option>
                </select>
            </li>
            <li class="article-form__main">
                <span>コードを書く場合は```の後に{ .language-[言語の拡張子] }と書いてください。また、コード群と文字の間に一行改行を入れてください。</span>
                <p class="err"><?= $errors["markdown"] ?></p>
                <textarea name="markdown" id="mde"></textarea>
            </li>
        </ul>



        <div class="btn">
            <div class="btn__back-btn">
                <a href="./list.php">戻る</a>
            </div>
            <div class="btn__post-btn">
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