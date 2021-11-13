<?php

class TechArticle
{
    public $id = "";
    public $title = "";
    public $genre = "";
    public $type = "";
    public $markdown = "";
    public $visible = "";
    public $created_at = "";
    function __construct($item)
    {
        $this->id = $item["id"];
        $this->title = $item["title"];
        $this->genre = $item["genre"];
        $this->markdown = $item["markdown"];
        $this->visible = $item["visible"];
        $this->created_at = substr($item["created_at"], 0, 10);
        $this->type = $item["type"];
    }

    public function getGenreImage()
    {
        switch ($this->genre) {
            case 'html':
                return '<i class="fab fa-html5 html"></i>';
                break;
            case 'css':
                return '<i class="fab fa-css3-alt css"></i>';
                break;
            case 'javascript':
                return '<i class="fab fa-js js"></i>';
                break;
            case 'php':
                return "<i class='fab fa-php php'></i>";
                break;
            case 'swift':
                return '<i class="fab fa-swift swift"></i>';
                break;
            case 'ios':
                return '<i class="fab fa-app-store-ios ios"></i>';
                break;
            case 'web':
                return '<i class="fab fa-chrome web"></i>';
                break;
            case 'other':
                return '<i class="fas fa-laptop-code other"></i>';
                break;
            default:
                return '<i class="fas fa-bible" life></i>';
                break;
        }
    }
}
