<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require 'db_connection.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && 
is_numeric($data->id) &&
isset($data->edit_username) && 
isset($data->edit_password) && 
isset($data->edit_email) && 
isset($data->edit_name)
) {
    $username = mysqli_real_escape_string($conn, trim($data->edit_username));
    $email = mysqli_real_escape_string($conn, trim($data->edit_email));
    $password = mysqli_real_escape_string($conn, trim($data->edit_password));
    $name = mysqli_real_escape_string($conn, trim($data->edit_name));

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $updateUser = mysqli_query($conn, "UPDATE `users` SET 
            `user_username`='$username', 
            `user_password`='$password',
            `user_email`='$email',
            `user_name`='$name'
            WHERE `user_Id`=$data->id");

        if ($updateUser) {
            echo json_encode(["success" => true, "msg" => "User already updated.", ]);
        }
        else {
            echo json_encode(["success" => false, "msg" => "User Not Updated!"]);
        }


    }
    else {
        echo json_encode(["success" => false, "msg" => "Invalid Email Address!"]);
    }
}
else {
    echo json_encode(["success" => false, "msg" => "Please fill all the required fields!"]);
}

?>