<?php
session_start();
session_regenerate_id(true);

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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/simplemde@latest/dist/simplemde.min.js"></script>
    <title>技術ブログ投稿画面</title>
</head>

<body>
    <form action="insert_check.php" method="post">
        <p class="err"><?= $errors["title"] ?></p>
        <label for="title">
            <p>タイトル(64文字まで)</p>
            <input type="text" name="title" id="title">
        </label>
        <p class="err"><?= $errors["genre"] ?></p>
        <label for="genre">
            <p>ジャンル</p>
            <select name="genre" id="genre">
            <?php foreach ($GENRES as $genre): ?>
                    <option value="<?= $genre ?>"><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <p class="err"><?= $errors["markdown"] ?></p>
        <textarea name="markdown" id="mde"></textarea>

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