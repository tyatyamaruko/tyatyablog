<?php
session_start();
session_regenerate_id(true);

require_once "../secretinfo/env.php";
require_once "../../Library/lib.php";


if (isset($_POST["id"])) {
    $id = $_POST["id"];
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
}

var_dump($id);
var_dump($password);
var_dump(ID);
var_dump(PASSWORD);

if (isset($id) && isset($password)) {
    if (ID == $id && PASSWORD == $password) {
        $_SESSION['login'] = 1;
        header("Location: ../tech/list.php");
        exit();
    } else {
        $isError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>

<body>
    <div class="error">
        <?= isset($isError) && $isError == true ? "IDまたはPasswordが間違っています" : "" ?>
    </div>
    <form method="post">
        <ul>
            <li>
                <p>ID</p>
                <input type="text" name="id">
            </li>
            <li>
                <p>PASSWORD</p>
                <input type="text" name="password">
            </li>
            <li>
                <input type="submit" value="ログイン">
            </li>
        </ul>
    </form>
</body>

</html>