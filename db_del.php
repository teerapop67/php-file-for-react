<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id) && is_numeric($data->id)) {
    $delID = $data->id;
    $deleteUser = mysqli_query($conn, "DELETE FROM `users` WHERE `user_Id`=$delID");
    if ($deleteUser) {
        echo json_encode(["success" => true, "msg" => "User Deleted"]);
    } else {
        echo json_encode(["success" => false, "msg" => "User Not Found!"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "User Not Found!!!"]);
}