<?php
require("./admin/env.php");

$error = false;

if (isset($_POST['articleId'])) {
    $articleId = $_POST['articleId'];
} else {
    $error = true;
}

if (isset($_POST['username']) && $_POST['username'] != "") {
    $username = $_POST['username'];
} else {
    $error = true;
}

if (isset($_POST['comment']) && $_POST['comment'] != "") {
    $comment = $_POST['comment'];
} else {
    $error = true;
}

if ($error) {
    header("Location: ./article.php?id=$articleId" );
    exit;
}

try {
    $pdo = new PDO(DSN, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "insert into " . COMMENT_TABLE . " (article_id, username, comment) values (?,?,?)";

    $stmt = $pdo->prepare($sql);
    $data[] = $articleId;
    $data[] = $username;
    $data[] = $comment;
    $stmt->execute($data);
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

header("Location: ./article.php?id=$articleId");
exit;


?>