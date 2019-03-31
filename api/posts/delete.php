<?php
// for Postman http://localhost/php_rest_api/api/posts/delete.php?id=7


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');  // "X-Requested-With" will help with cross-site scripting attacks

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

// Instantiate posts object
$post = new Post($db);

// Get raw posted data (in this case just "id")
// file_get_contents("php://input") = $HTTP_RAW_POST_DATA (to get the body of JSON request)
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$post->id = $data->id;

// Delete posts
if ($post->delete()) {
    echo json_encode(
        array('message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}

