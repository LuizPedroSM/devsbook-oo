<?php
class Post
{
    public $id;
    public $id_user;
    public $type; // text || photo
    public $created_at;
    public $body;
}

interface PostDAO
{
    public function insert(Post $post);
    public function getHomeFeed($id_user);
    //public function update(Post $post);
}