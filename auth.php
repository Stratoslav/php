<?php



function loginUser($connection, $data) {
    
    $username = $data->username;

    $stmt = mysqli_prepare($connection, "SELECT * FROM `users` WHERE `username` AND `password` = ?, ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    
    $user = mysqli_fetch_assoc($result);


    if($user !== null){
        
       $userId = $user['id'];
       $token = bin2hex(random_bytes(16));
 
       $loginToken = mysqli_query($connection, "INSERT INTO `token` (`token`,`user_id`) VALUES ('$token','$userId')");
       if(!$loginToken){
      http_response_code(404);
        $res = [
            "status" => "400 Server Error",
"message" => "sorry, something went wrong:("
        ];
        echo json_encode($res);
       }else {
    http_response_code(200);
        $res = [
            "status" => "200 OK",
"message" => "user login successfully"
        ];
        echo json_encode($res);
       }
    } else {
        http_response_code(400);
        $res = [
            "status" => "400 Bad Request",
"message" => "user doesn't exist"
        ];
        echo json_encode($res);
    }
    mysqli_stmt_close($stmt);
}

function logout($connection){
   

    $tokenAuth = substr(getallheaders()['Authorization'], 7);
   if($tokenAuth){
  mysqli_query($connection, "DELETE  FROM `token` WHERE `token` = '$tokenAuth'");
      http_response_code(200);
  $res = [
            "status" => "200 OK",
            "message" => "logout success"
        ];
  getallheaders()['Authorization'] = "";
       echo json_encode($res);
   } else {
        http_response_code(400);
     $res = [
            "status" => "400 Bad Request",
            "message" => "You've already been logout"
        ];
      
       echo json_encode($res);
   }
 

}