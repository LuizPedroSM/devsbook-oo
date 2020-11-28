<?php
require_once './models/Post.php';
require_once './dao/UserRelationDaoMysql.php';
require_once './dao/UserDaoMysql.php';
class PostDaoMysql implements PostDAO
{
    private $dao;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function _postListToObject(array $post_list, $id_user): array
    {
        $userDao = new UserDaoMysql($this->pdo);

        foreach ($post_list as $post_item) {
            $newPost = new Post();
            $newPost->id = $post_item['id'];
            $newPost->id_user = $post_item['id_user'];
            $newPost->type = $post_item['type'];
            $newPost->created_at = $post_item['created_at'];
            $newPost->body = $post_item['body'];
            $newPost->mine = false;

            if ($post_item['id_user'] == $id_user) {
                $newPost->mine = true;
            }

            // Info do usuário
            $newPost->user = $userDao->findById($post_item['id_user']);

            // Info sobre LIKE
            $newPost->likeCount = 0;
            $newPost->liked = false;

            // Info sobre Comments
            $newPost->comments = [];

            $posts[] = $newPost;
        }
        return $posts ?? [];
    }

    public function insert(Post $post): void
    {
        $sql = $this->pdo->prepare("INSERT INTO posts (
                id_user, type, created_at, body
            ) VALUES (
                :id_user, :type, :created_at, :body
        )");
        $sql->bindValue(':id_user', $post->id_user);
        $sql->bindValue(':type', $post->type);
        $sql->bindValue(':created_at', $post->created_at);
        $sql->bindValue(':body', $post->body);
        $sql->execute();
    }

    public function getHomeFeed($id_user): array
    {
        // 1.Listar os usuários que o usuário logado segue.
        $userRelationDao = new UserRelationDaoMysql($this->pdo);
        $userList = $userRelationDao->getRelationsFrom($id_user);

        // 2. Pegar os posts ordenado pela data.
        $sql = $this->pdo->query("SELECT * FROM posts
        WHERE id_user in (" . implode(',', $userList) . ")
        ORDER BY created_at DESC");

        if ($sql->rowCount() > 0) {
            $post_list = $sql->fetchAll(PDO::FETCH_ASSOC);
            // 3. Transformar o resultado em objetos.
            $array = $this->_postListToObject($post_list, $id_user);
        }
        return $array ?? [];
    }
}