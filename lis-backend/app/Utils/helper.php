<?php

use App\Models\Facility;

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
function getRowSpanForPage($pos,$truespan,$maxSpanPerPage=10,$realCurrentIndex=null){

    $expansion =  $pos+$truespan;
    $spansInEachPage=[];


    // $margin=9;//the first page already has headers and stuff, but the other pages are empty. if we give the same max number of rows to all of them, the other pages will be more empty at the bottom. The margin is the amount of rows that can add up to the initial maximum for the other pages.
     
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
            // if($realCurrentIndex>$maxSpanPerPage || $counter>0){ //meaning we are not on the first page, or we are calculating the number of rows this element will take on other pages.
            //     $maxSpanPerPage +=$margin;
            // }
            if($counter==0){
                $maxSpanable= $maxSpanPerPage - $pos;//the mount of size he can occupy on the first page
            }else{
                $maxSpanable=$maxSpanPerPage;
            }
            if($copyTrueSpan<$maxSpanable){
                $spansInEachPage[]=$copyTrueSpan;
                $copyTrueSpan=0;
            }else{
                $spansInEachPage[]=$maxSpanable;
                $copyTrueSpan=$copyTrueSpan-$maxSpanable;
            }
            $counter++;
        }
    }

    return $spansInEachPage;
}

/**
 * Replaces all image URLs in the provided HTML with their Base64-encoded versions.
 *
 * @param string $html The original HTML string.
 * @return string The updated HTML string with images encoded in Base64.
 */
function replaceImagesWithBase64(string $html): string
{
    // Create a new DOMDocument instance.
    $dom = new DOMDocument();

    // Suppress warnings due to potential malformed HTML.
    libxml_use_internal_errors(true);
    $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    // Get all <img> elements.
    $images = $dom->getElementsByTagName('img');

    foreach ($images as $img) {
        
        $src = $img->getAttribute('src');
        $path = parse_url($src, PHP_URL_PATH);
   

        $path = public_path($path);
        // $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        // Determine the MIME type of the image.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($data);

        // Encode the image data to base64.
        $base64  = base64_encode($data);
        $dataUrl = "data:$mimeType;base64,$base64";
        
        // Replace the src attribute with the Base64 data URL.
        $img->setAttribute('src', $dataUrl);
    }

    // Return the modified HTML.
    return $dom->saveHTML();
}

function getCurrentLab($ref=null){
    $lab =  Facility::query()->where('ref',$ref??request('facility_ref'))->first();
    // dd($ref);
    return $lab;
}

function fixTinyMCEHtml($html){
    $html = str_replace('</header>', '', $html);
    if(str_contains($html,'<header>')){
        $html = str_replace('<footer>', '</header><footer>', $html);
    }
    return $html;
}