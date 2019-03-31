<?php
// for Postman http://localhost/php_rest_api/api/posts/create.php
//             Headers  Key: Content-Type  Value: application/json
//             Body  raw
//             {
//	               "title": "My Post",
//	               "body": "Post from Postman",
//	               "author": "Me",
//	               "category_id": "1"
//              }


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');  // "X-Requested-With" will help with cross-site scripting attacks

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

// Instantiate blog posts object
$post = new Post($db);

// Get raw posted data (data should meet us whatever is submitted)
// file_get_contents("php://input") = $HTTP_RAW_POST_DATA (to get the body of JSON request)
$data = json_decode(file_get_contents("php://input"));

// Assigning what we have in the data to the posts
// posts-model or posts-object
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// Create posts
if ($post->create()) {
    echo json_encode(
        array('message' => 'Post Created')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}