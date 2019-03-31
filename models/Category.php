<?php

class Category
{
// DB stuff
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    # Get Categories
    public function read()
    {
        // Create query
        $query = "SELECT
            c.name AS category_name,
            p.id AS post_id,
            p.category_id AS post_category_id,
            p.title AS post_tittle,
            p.author AS post_author,
            p.created_at AS post_created_at
        FROM
            $this->table c
        RIGHT JOIN
            posts p ON p.category_id = c.id
        ORDER BY
            c.name DESC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        // (dumping out the statement)
        return $stmt;
    }

    # Create category
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind data
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong. we shoud be able to see it in the raw tab in postman
        printf("Error: %s.\n", $stmt->error); // "%s' is like a placeholder, then ".\n" concatenate new line
        return false;
    }
}