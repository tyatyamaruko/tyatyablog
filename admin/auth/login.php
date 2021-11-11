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
    <link rel="stylesheet" href="../../css/style.css">
    <title>ログイン画面</title>
</head>

<body>
    <div class="error">
        <?= isset($isError) && $isError == true ? "IDまたはPasswordが間違っています" : "" ?>
    </div>
    <form class="login-form" method="post">
        <table>
            <tr>
                <th>ID</th>
                <td><input type="text" name="id" id=""></td>
            </tr>
            <tr>
                <th>PASSWORD</th>
                <td><input type="password" name="password" id=""></td>
            </tr>
            <tr>
                <td class="login-btn" colspan="2"><input type="submit" value="LOG IN"></td>
            </tr>
        </table>
    </form>
</body>

</html>