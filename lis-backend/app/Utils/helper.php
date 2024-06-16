<?php


function error_response($code,$message){
    if($code>=200 && $code<=299){
        throw new \Exception("[TKC] Code should be http error");
    }
    return response([
        "message"=>$message
    ],$code);
}

function gen_uniqid(){
    return uniqid(time());
}

function calculateAge($date) {
    $now = new DateTime();
    $dob = new DateTime($date);
    $diff = $now->diff($dob);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
    } elseif ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
    } elseif ($diff->d >= 7) {
        $weeks = floor($diff->d / 7);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '');
    } else {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
    }
}

function formatDate($dateString) {
    $dateString = trim($dateString);
    if(empty($dateString)){
        return "";
    }
    try {
        $date = new DateTime($dateString);
        if (strpos($dateString, ':') !== false) {
            // Date string contains time
            return $date->format('d/m/Y H:i');
        } else {
            // Date string does not contain time
            return $date->format('d/m/Y');
        }
    } catch (Exception $e) {
        // Handle invalid date format
        return 'Invalid date format';
    }
}