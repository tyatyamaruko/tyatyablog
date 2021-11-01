<?php

define("DBNAME", "tyatyablog");
if ($_SERVER["SERVER_NAME"] == "localhost") {
    define("DSN", "mysql:dbname=tyatyablog;host=localhost;charset=utf8mb4");
    define("USERNAME", "root");
    define("PASSWORD", "");
} else {
    define("DSN", "mysql:dbname=tyatyablog;port=3306;host=tyatyablog.chkzhzmzvjin.ap-northeast-3.rds.amazonaws.com;charset=utf8mb4");
    define("USERNAME", "ryota9981");
    define("PASSWORD", "ryota9981");
}


define("TECH_TABLE", "techarticles");
define("DAILY_TABLE", "dailyarticles");

$GENRES = [
    "html",
    "css",
    "javascript",
    "php",
    "swift",
    "ios",
    "web",
    "other",
];
