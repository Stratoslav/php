<?php
require_once "./helpers/validatePassword.php";

     function  getUsers($connection){
   
 $token = substr(getallheaders()['Authorization'], 7);
 
    $userFromToken = mysqli_query($connection, "SELECT * FROM `token` WHERE `token` = '$token'  ")->fetch_assoc();
  $accessTime =  $userFromToken['time'] - time();
     if(!is_null($userFromToken) && $accessTime > 0){
 $users =   mysqli_query($connection, "SELECT * FROM `users`");
     $userList = array();
     while($user = mysqli_fetch_assoc($users)){
    $userList[] = $user;
     }
    
  } else {
      http_response_code(400);
        $res = [
            "status" => "400 Bad Request",
"message" => "You are not authtorethion"
        ];
        echo json_encode($res);
  }
    echo json_encode($userList);
    }

    function createUser($connection, $data) {
        $username = $data->username;
  
        validatePassword($data->pasword, 4, 16);
           
         
    $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);
    $findUser = mysqli_query($connection, "SELECT * FROM users WHERE `username` = '$username'");
   
    if($findUser->num_rows != 0){
          http_response_code(400);
        $res = [
            "status" => "400 Bad Request",
"message" => "user already exist"
        ];
        echo json_encode($res);
        return;
    }

        $stmt = mysqli_prepare($connection, "INSERT INTO users (`username`, `password`) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
    
        if (mysqli_stmt_execute($stmt)) {
            echo "User created successfully.";
        } else {
            echo "Error creating user: " . mysqli_error($connection);
        }
    
        mysqli_stmt_close($stmt);
    }
    






?>