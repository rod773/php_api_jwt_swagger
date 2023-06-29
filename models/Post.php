<?php


error_reporting(E_ALL);
ini_set('display_error', 1);


class Post
{
    // Database data.
    private $connection;
    private $table = 'posts';
    // Post Properties
    public $id;
    public $category_id;
    public $title;
    public $description;
    public $created_at;


    public function __construct($db)
    {
        $this->connection = $db;
    }


    // Get all list of posts.
    public function read()
    {
        // Query to get posts data.
        $query = 'SELECT c.name as category, p.id,
        p.category_id, p.title, p.description, p.created_at
         FROM ' . $this->table .
            ' p LEFT JOIN category c ON p.category_id = c.id
         ORDER BY p.created_at DESC';

        $post = $this->connection->prepare($query);
        $post->execute();

        return $post;
    }



    // Get single post.
    public function read_single_post($id)
    {
        $this->id = $id;
        // Query to get posts data.
        $query = 'SELECT c.name as category, p.id,
        p.category_id, p.title, p.description, p.created_at
        FROM ' . $this->table .
            ' p LEFT JOIN category c
         ON p.category_id = c.id WHERE p.id= ? LIMIT 0,1';

        $post = $this->connection->prepare($query);
        //$post->bindParam(9, $this->id);
        $post->execute([$this->id]);

        return $post;
    }




    // Insert a new record.
    public function create_new_record($params)
    {
        try {
            $this->title = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];

            $query = 'INSERT INTO ' . $this->table . '
            SET title = :title, category_id = :category_id, description = :details';


            $statement = $this->connection->prepare($query);
            $statement->bindValue('title', $this->title);
            $statement->bindValue('category_id', $this->category_id);
            $statement->bindValue('details', $this->description);

            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    // Update a new record.
    public function update_new_record($params)
    {
        try {
            $this->id = $params['id'];
            $this->title = $params['title'];
            $this->description = $params['description'];
            $this->category_id = $params['category_id'];
            $query = 'UPDATE ' . $this->table . '
            SET title = :title, category_id = :category_id, description = :details
            WHERE id = :id';

            $statement = $this->connection->prepare($query);
            $statement->bindValue('id', $this->id);
            $statement->bindValue('title', $this->title);
            $statement->bindValue('category_id', $this->category_id);
            $statement->bindValue('details', $this->description);

            if ($statement->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
