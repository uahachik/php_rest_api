<?php
// for Postman http://localhost/php_rest_api/api/posts/read.php


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

// Instantiate blog posts object
$post = new Post($db);

// Post query
$result = $post->read(); // PDOStatement Object ([queryString] => SELECT c.name AS category_name, ... c.name DESC)

// Get row count
$num = $result->rowCount(); // $num = 6


// Check if any posts
if ($num > 0) {
    // Post array
    $posts_arr = []; // array(1) { ["data"]=>array(6)... }
    $posts_arr['data'] = []; //  array(6) {...}

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'category_name' => $category_name,
            'id' => $id,
            'category-id' => $category_id,
            'title' => $title,
            'author' => html_entity_decode($author),
            'created_at' => $created_at,
            'body' => $body
        );

        // Push to the data
        array_push($posts_arr['data'], $post_item);
    }

// Turn to JSON & output
    echo json_encode($posts_arr);

} else {
// No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}


