<?php
require_once "./connection.php";
require_once "./users.php";
require_once "./auth.php";
header("Content-type: application/json");
$q = $_GET["q"];

$path = explode("/", $q);

     json_encode($path[0]);

$method =  $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":     
        if($path[0] === "users"){
           
         getUsers($connection);
        }
        break;
        case 'POST':
            if($path[0] === "users"){
        $data = file_get_contents("php://input");
      $data = json_decode($data);
     
       createUser($connection, $data);  
        } else if($path[0] == "login"){
            $data = file_get_contents('php://input');
            $data = json_decode($data);
            loginUser($connection, $data);
        } else if($path[0] === "logout"){
            logout($connection);
        }
            break;
        
    default:
       echo "GG";
        break;
}