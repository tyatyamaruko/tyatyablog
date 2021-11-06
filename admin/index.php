<?php
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['login'])) {
    header("Location: ./auth/login.php" );
    exit;
}

header("Location: ./tech/list.php");
exit;

?>