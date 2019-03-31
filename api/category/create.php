<?php
// for Postman http://localhost/php_rest_api/api/category/create.php
//             Headers  Key: Content-Type  Value: application/json
//             Body  raw
//             {
//	               "name": "Education"
//              }


// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');  // "X-Requested-With" will help with cross-site scripting attacks

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get raw posted data (data should meet us whatever is submitted)
// file_get_contents("php://input") = $HTTP_RAW_POST_DATA (to get the body of JSON request)
$data = json_decode(file_get_contents("php://input"));

// Assigning what we have in the data to the posts
// posts-model or posts-object
$category->name = $data->name;

// Create posts
if ($category->create()) {
    echo json_encode(
        array('message' => 'Category Created')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
}