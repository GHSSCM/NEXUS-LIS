<?php


function error_response($code,$message){
    if($code>=200 && $code<=299){
        throw new \Exception("[TKC] Code should be http error");
    }
    return response([
        "message"=>$message
    ],$code);
}