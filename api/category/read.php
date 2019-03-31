<?php
// for Postman http://localhost/php_rest_api/api/category/read.php


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Category query
$result = $category->read(); // [queryString]
// Get row count
$num = $result->rowCount(); // $num = 6


// Check if any posts
if ($num > 0) {
    // Categories array
    $categories_arr = []; // array(1) { ["data"]=>array(6)... }
    $categories_arr['data'] = []; //  array(6) {...}

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'author' => html_entity_decode($author),
            'category-id' => $category_id,
            'category_name' => $category_name
        );

        // Push to the data
        array_push($categories_arr['data'], $category_item);
    }

// Turn to JSON & output
    echo json_encode($categories_arr);

} else {
// No Posts
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}

