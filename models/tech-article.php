<?php

class TechArticle {
    public $id = "";
    public $title = "";
    public $genre = "";
    public $markdown = "";
    public $created_at = "";
    function __construct($item) {
        $this -> id = $item["id"];
        $this -> title = $item["title"];
        $this -> genre = $item["genre"];
        $this -> markdown = $item["markdown"];
        $this -> created_at = $item["created_at"];
    }
}