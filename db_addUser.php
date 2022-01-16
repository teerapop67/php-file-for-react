<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';

$dataUse = json_decode(file_get_contents("php://input"));

if(isset($dataUse->add_username) && 
    isset($dataUse->add_password) && 
    isset($dataUse->add_email) && 
    isset($dataUse->add_name)
) 
    {
        $username = mysqli_real_escape_string($conn, trim($dataUse->add_username));
        $userEmail = mysqli_real_escape_string($conn, trim($dataUse->add_email));
        $userPassword = mysqli_real_escape_string($conn, trim($dataUse->add_password));
        $userName = mysqli_real_escape_string($conn, trim($dataUse->add_name));
        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $insertUser = mysqli_query($conn, "INSERT INTO `users`(`user_username`,
             `user_password`, 
             `user_email`,
             `user_name`)
             VALUES('$username', '$userPassword', '$userEmail', '$userName')
             ");
             if ($insertUser) {
                $last_id = mysqli_insert_id($conn);
                 echo json_encode(["success" => true, "msg" => "You were added", "id" => $last_id]);
             }
             else {
                 echo json_encode(["success" => false, "msg" => "User Not added!"]);
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