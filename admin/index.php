<?php
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['login'])) {
    header("Location: ./auth/" );
    exit;
}

header("Location: ./tech/list.php");
exit;

?>