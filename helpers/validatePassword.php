<?php

function validatePassword($str, $minLength, $maxLength){
    if(strlen(($str)) < $minLength || strlen(($str)) > $maxLength){
        $res = [
            "status" => "401 Unauthorized",
            "message" => "password must be from" . '' . $minLength . '' . "to" . '' . "$maxLength" . '' . "symbols"
        ];
        echo json_encode($res);
      exit;
    }

    return;
   
}