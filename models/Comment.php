<?php


class Comment {
    public $id = "";
    public $username = "";
    public $comment = "";
    public $createdAt = "";

    function __construct($data) {
        $this -> id = $data['id'];
        $this -> username = $data['username'];
        $this -> comment = $data['comment'];
        $this -> createdAt = $data['created_at'];
    }
}