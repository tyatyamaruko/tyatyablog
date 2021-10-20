<?php

use cebe\markdown\MarkdownExtra;
require_once "../../vendor/autoload.php";


session_start();
session_regenerate_id(true);

require_once "../../Library/lib.php";
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

if (isset($post['markdown']) && $post['markdown'] != "") {
    $markdown = $post['markdown'];
} else {
    $errors['markdown'] = "記事が入力されていません";
}

$converter = new MarkdownExtra();
echo $converter -> parse($markdown);


if (count($errors) > 0) {
    header("Location: insert.php");
    $_SESSION["error"] = $errors;
    exit();
}

echo "";
// データベースに保存
// mdをファイルに書き込んで保存
// 成功したらリストにリダイレクト
// 失敗したら...