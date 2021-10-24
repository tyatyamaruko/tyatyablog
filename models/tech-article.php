<?php

class TechArticle {
    public $id = "";
    public $title = "";
    public $genre = "";
    public $markdown = "";
    public $visible = "";
    public $created_at = "";
    function __construct($item) {
        $this -> id = $item["id"];
        $this -> title = $item["title"];
        $this -> genre = $item["genre"];
        $this -> markdown = $item["markdown"];
        $this -> visible = $item["visible"];
        $this -> created_at = $item["created_at"];
    }
}