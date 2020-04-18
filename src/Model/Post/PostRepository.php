<?php

namespace Post;

class PostRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $rows = $this->dbAdapter->query('SELECT * FROM "post"');
        $posts = [];
        foreach ($rows as $row) {
            $post = new Post();
            $post
                ->setId($row['id'])
                ->setContent($row['content'])
                ->setCreatedAt(new \DateTime($row['created_at']))
                ->setAuthorId($row['author_id']);
            $posts[] = $post;
        }
        return $posts;
    }

    //TODO fetch by postId, indice (comme le fetch all avec une clause WHERE)

    public function create(Post $newPost)
    {
        $query = $this->dbAdapter->prepare(
            'INSERT INTO "post"(content, created_at, author_id) 
            VALUES (:content, :created_at, :author_id)');
        
        $query->bindValue(':content', $newPost->getContent());
        $query->bindValue(':created_at', $newPost->getCreatedAt());
        $query->bindValue(':author_id', $newPost->getAuthorId());

        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        $newPost->setId($this->dbAdapter->lastInsertId());
        return $newPost;
    }

    //attention ne gère pas la délétion en cascade
    public function delete(Post $postToDelete)
    {
        $query = $this->dbAdapter->prepare('DELETE FROM "post" WHERE id = :id');
        $query->bindValue(':id', $postToDelete->getId());
        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        return $result;
    }
}