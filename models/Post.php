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
    public function delete(int$id, int $id_user);
    public function getHomeFeed($id_user, $page = 1);
    public function getUserFeed($id_user, $page = 1);
    public function getPhotosFrom($id_user);
    //public function update(Post $post);
}