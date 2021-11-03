<?php
session_start();
session_regenerate_id(true);

require_once "../../Library/lib.php";
require_once "../env.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$post = html_special_chars($_POST);

$errors = [];

if (isset($post['title']) && $post['title'] != "") {
    $title = $post['title'];
    if (mb_strlen($title) > 64) {
        $errors['title'] = "タイトルが長過ぎます";
    }
} else {
    $errors['title'] = "タイトルが入力されていません";
}

if (isset($post['genre']) && $post['genre'] != "") {
    $genre = $post['genre'];
    if (mb_strlen($genre) > 32) {
        $errors['genre'] = "ジャンル名が長過ぎます";
    }
} else {
    $errors['genre'] = "ジャンルが入力されていません";
}

$type = $post["type"];

if (isset($post['markdown']) && $post['markdown'] != "") {
    $markdown = $post['markdown'];
} else {
    $errors['markdown'] = "記事が入力されていません";
}

if (count($errors) > 0) {
    header("Location: insert.php");
    $_SESSION["error"] = $errors;
    exit();
}


// データベースに保存

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "insert into techarticles (title, genre, type, markdown) values (?,?,?,?)";

    $stmt = $pdo -> prepare($sql);
    $data[] = $title;
    $data[] = $genre;
    $data[] = $type;
    $data[] = $markdown;
    $stmt -> execute($data);

} catch (PDOException $e) { 
    // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

header("Location: ./list.php");
