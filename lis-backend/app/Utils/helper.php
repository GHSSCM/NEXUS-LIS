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

function update_registered_specimens_state($rs,$state){
     $rs->state = $state;
     $rs->save();
}

/**
 * 
 * 
 * @param int $pos = the index of the main loop
 * @param int $truespan = the real span if the table was normal
 */
function getColumnSpanForPage($pos,$truespan,$maxSpanPerPage=10){
    $expansion =  $pos+$truespan;
    $spansInEachPage=[];

     
    if($pos==0){
        $copyTrueSpan=$truespan;
        while($copyTrueSpan>0){
            if($copyTrueSpan<$maxSpanPerPage){
                $spansInEachPage[]=$copyTrueSpan;
                $copyTrueSpan=0;
            }else{
                $spansInEachPage[]=$maxSpanPerPage;
                $copyTrueSpan=$copyTrueSpan-$maxSpanPerPage;
            }
        }
    }else{
        $copyTrueSpan=$truespan;

        $counter=0;
        while($copyTrueSpan>0){
            if($counter==0){
                $maxSpanable= $maxSpanPerPage - $pos;//the mount of size he can occupy on the first page
            }else{
                $maxSpanable=$maxSpanPerPage;
            }
            if($copyTrueSpan<$maxSpanable){
                $spansInEachPage[]=($copyTrueSpan);
                $copyTrueSpan=0;
            }else{
                $spansInEachPage[]=($maxSpanable);
                $copyTrueSpan=$copyTrueSpan-$maxSpanable;
            }
        }
    }

    return $spansInEachPage;
}