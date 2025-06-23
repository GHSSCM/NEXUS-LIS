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


function getAllowedServices($facility_ref=null){
    $facility_ref =  $facility_ref??request('facility_ref');
    return [

                [
                    'name' => 'Nexus - Patient Information System',
                    'description' => 'A system to manage patient data and operations.',
                    'route'=>'/nexus.patients',
                    'short_name'=>'Patients',
                    'code'=>'nexus.patients',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Covid Icons by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 20.679a3.429 3.429 0 1 0 0-6.858a3.429 3.429 0 0 0 0 6.858m-.571-9.429h1.142m-.571 0v2.571m3.839-1.218l.808.808m-.404-.404l-1.819 1.819m3.576 1.853v1.142m0-.571h-2.571m1.218 3.839l-.808.808m.404-.404l-1.819-1.819m-1.853 3.576h-1.142m.571 0v-2.571m-3.839 1.218l-.808-.808m.404.404l1.819-1.819m-3.576-1.853v-1.142m0 .571h2.571m-1.218-3.839l.808-.808m-.404.404l1.819 1.819M7.5 9a4.125 4.125 0 1 0 0-8.25A4.125 4.125 0 0 0 7.5 9M.75 17.25a6.753 6.753 0 0 1 9.4-6.208"/></svg>',
                ],
                [
                    'name' => 'Nexus - Laboratory Information System',
                    'description' => 'A system to manage laboratory data and operations.',
                    'route'=>'/nexus.lab',
                    'short_name'=>'Laboratory',
                    'code'=>'nexus.lab',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Guidance by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" d="M6.5 12.5h.146c2.206 0 4.381.514 6.354 1.5s4.148 1.5 6.354 1.5H20.5m-13-14h9v.25l-.707.972a6.76 6.76 0 0 0 .688 8.759L22.5 17.5c0 2-1 3.5-3 5h-15c-2-1.5-3-3-3-5l6.02-6.02a6.76 6.76 0 0 0 .687-8.758L7.5 1.75z"/></svg>',
                ],
                [
                    'name' => 'Nexus - Billing Information System',
                    'description' => 'A system to manage billing and financial operations.',
                    'route'=>'/nexus.billing',
                    'short_name'=>'Billing',
                    'code'=>'nexus.billing',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Stash Icons by Pingback LLC - https://github.com/stash-ui/icons/blob/master/LICENSE --><path fill="currentColor" d="M7.179 3.5h5.642c.542 0 .98 0 1.333.029c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v3.071a.5.5 0 0 1-1 0V7.2c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.138-.608a1.5 1.5 0 0 0-.655-.656c-.132-.067-.305-.113-.608-.137c-.309-.026-.705-.026-1.273-.026H7.2c-.568 0-.964 0-1.273.026c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C4.5 6.236 4.5 6.632 4.5 7.2v9.6c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .646.65l.01.002c.018.004.062.014.144.026q.189.028.495.05c.404.03.92.05 1.466.064c1.089.027 2.265.027 2.826.027a.5.5 0 0 1 0 1h-.001c-.56 0-1.748 0-2.85-.027a33 33 0 0 1-1.515-.066a8 8 0 0 1-.566-.058a1.5 1.5 0 0 1-.453-.122a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C3.5 17.8 3.5 17.362 3.5 16.82V7.18c0-.542 0-.98.029-1.333c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243c.355-.03.793-.03 1.335-.03"/><path fill="currentColor" d="M18.62 12.5c.403 0 .735 0 1.006.022c.281.023.54.072.782.196a2 2 0 0 1 .874.874c.124.243.173.501.196.782c.022.27.022.603.022 1.005v2.242c0 .402 0 .734-.022 1.005c-.023.281-.072.54-.196.782a2 2 0 0 1-.874.874c-.243.124-.501.173-.782.196c-.27.022-.603.022-1.005.022h-4.242c-.402 0-.734 0-1.005-.022c-.281-.023-.54-.072-.782-.196a2 2 0 0 1-.874-.874c-.124-.243-.173-.501-.196-.782c-.022-.27-.022-.603-.022-1.005v-2.242c0-.402 0-.734.022-1.005c.023-.281.072-.54.196-.782a2 2 0 0 1 .874-.874c.243-.124.501-.173.782-.196c.27-.022.603-.022 1.005-.022zm-5.164 1.019c-.22.018-.332.05-.41.09a1 1 0 0 0-.437.437c-.04.078-.072.19-.09.41l-.004.044h7.97l-.004-.044c-.018-.22-.05-.332-.09-.41a1 1 0 0 0-.437-.437c-.078-.04-.19-.072-.41-.09a13 13 0 0 0-.944-.019h-4.2c-.428 0-.72 0-.944.019M20.5 16.5h-8v1.1c0 .428 0 .72.019.944c.018.22.05.332.09.41a1 1 0 0 0 .437.437c.078.04.19.072.41.09c.225.019.516.019.944.019h4.2c.428 0 .72 0 .944-.019c.22-.018.332-.05.41-.09a1 1 0 0 0 .437-.437c.04-.078.072-.19.09-.41c.019-.225.019-.516.019-.944zm-14-10a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zM6 10a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 6 10m.5 2.5a.5.5 0 0 0 0 1H10a.5.5 0 0 0 0-1zM6 17a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 6 17"/></svg>',
                ],
                [
                    'name' => 'Nexus - Blood Bank Information System',
                    'description' => 'A system to manage blood bank operations and data.',
                    'route'=>'/nexus.bloodbank',
                    'short_name'=>'Blood Bank',
                    'code'=>'nexus.bloodbank',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48"><!-- Icon from Health Icons by Resolve to Save Lives - https://github.com/resolvetosavelives/healthicons/blob/main/LICENSE --><g fill="currentColor"><path d="M15.465 31.398a1 1 0 1 0-1.902.62a11.53 11.53 0 0 0 4.178 5.767a11.48 11.48 0 0 0 6.759 2.203c.552 0 1-.449 1-1.003s-.448-1.003-1-1.003a9.5 9.5 0 0 1-5.584-1.82a9.53 9.53 0 0 1-3.451-4.764"/><path fill-rule="evenodd" d="m24 4l-.69.66l-.004.004l-.009.008l-.032.032l-.122.119q-.16.157-.456.455a72 72 0 0 0-6.492 7.621C12.681 17.68 9 24.082 9 30.08C9 37.845 15.796 44 24 44s15-6.155 15-13.92c0-6-3.681-12.401-7.195-17.18a72 72 0 0 0-6.492-7.622a42 42 0 0 0-.578-.574l-.032-.032l-.01-.008zm-1.451 4.334A64 64 0 0 1 24 6.8a70 70 0 0 1 6.195 7.29C33.681 18.832 37 24.777 37 30.08c0 6.503-5.74 11.914-13 11.914S11 36.583 11 30.08c0-5.303 3.319-11.248 6.805-15.99a70 70 0 0 1 4.744-5.756" clip-rule="evenodd"/></g></svg>',
                ],
                [
                    'name' => 'Nexus - Pharmacy Information System',
                    'description' => 'A system to manage pharmacy operations and data.',
                    'route'=>'/nexus.pharmacy',
                    'short_name'=>'Pharmacy',
                    'code'=>'nexus.pharmacy',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26"><!-- Icon from Pepicons Pencil by CyCraft - https://github.com/CyCraft/pepicons/blob/dev/LICENSE --><g fill="currentColor"><path fill-rule="evenodd" d="m18.85 13.192l-6.365-6.364a4 4 0 0 0-5.657 5.657l6.364 6.364a4 4 0 1 0 5.657-5.657M7.535 7.536a3 3 0 0 1 4.242 0l6.364 6.364a3 3 0 1 1-4.242 4.242l-6.364-6.364a3 3 0 0 1 0-4.242" clip-rule="evenodd"/><path d="m16.037 10.58l-.243.97c-1.201-.3-2.223-.154-3.101.432c-.87.58-1.454 1.687-1.73 3.355l-.987-.164c.318-1.917 1.032-3.27 2.162-4.023c1.122-.748 2.434-.936 3.899-.57"/><path fill-rule="evenodd" d="M13 24.5c6.351 0 11.5-5.149 11.5-11.5S19.351 1.5 13 1.5S1.5 6.649 1.5 13S6.649 24.5 13 24.5m0 1c6.904 0 12.5-5.596 12.5-12.5S19.904.5 13 .5S.5 6.096.5 13S6.096 25.5 13 25.5" clip-rule="evenodd"/></g></svg>',
                ],
                [
                    'name' => 'Nexus - Configuration',
                    'description' => 'Configure your health information system & data',
                    'route'=>'/nexus.config',
                    'short_name'=>'Configuration',
                    'code'=>'nexus.config',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M7.5 15H9v-4H7.5v1.25H6v1.5h1.5zm2.5-1.25h8v-1.5h-8zM15 11h1.5V9.75H18v-1.5h-1.5V7H15zM6 9.75h8v-1.5H6zM8 21v-2H4q-.825 0-1.412-.587T2 17V5q0-.825.588-1.412T4 3h16q.825 0 1.413.588T22 5v12q0 .825-.587 1.413T20 19h-4v2zm-4-4h16V5H4zm0 0V5z"/></svg>',
                ],
            ];
}

function hasServiceAccess($serviceCode,$facility_ref=null){
    $facility_ref =  $facility_ref??request('facility_ref');
    $allowedServices = getAllowedServices($facility_ref);
    foreach($allowedServices as $service){
        if($service['code']==$serviceCode){
            return true;
        }
    }
    return false;
}

function getMeta($key=null,$facility_ref=null){
     $facility_ref = $facility_ref??request()->get("facility_ref");
    if(empty($facility_ref)){
        throw new \Exception("[TKC] Facility ref is required");
    }
    $facility =  Facility::query()->where('ref',$facility_ref)->first();
    if(empty($facility)){
        throw new \Exception("[TKC] Facility not found with ref: $facility_ref");
    }
    return $key?(isset($facility->meta[$key])?$facility->meta[$key]:null):$facility->meta;
}

function getEmrAddress($facility_ref=null){
    $emr_address = getMeta("emr_address",$facility_ref);
    return ($emr_address ?? "http://173.212.247.224:8090")."/api/v1";
}

function getFacilityRef(){
    return request('facility_ref')??null;
}

function getCurrentUserId(){
    return request()->header('X-User-ID');  
}

/**
 * ----------------------------------------------------------------
 *  Public helper – call this when you have the full array / JSON
 * ----------------------------------------------------------------
 */
function describeMetaList($list): string
{
    $out = '';

    // Accept arrays **or** Traversable objects
    if (is_array($list) || $list instanceof Traversable) {
        foreach ($list as $element) {
            $out .= describeMetaItem($element, 0);
        }
    }

    return $out;
}

/**
 * ----------------------------------------------------------------
 *  Recursive worker – handles ONE element (array|object)
 * ----------------------------------------------------------------
 */
function describeMetaItem($item, int $indent = 0): string
{
    // ⚠️ Coerce anything that’s not an array into an array safely
    $data = is_array($item)
        ? $item
        : (is_object($item) ? get_object_vars($item) : []);

    // Nothing usable → bail out early
    if (empty($data)) {
        return str_repeat('  ', $indent) . "[unknown]: null\n";
    }

    /** -----------------------
     *  1. Detect & walk subs
     * ---------------------*/
    $subs = $data['subs'] ?? null;
    if (is_array($subs) && !empty($subs)) {
        $buffer = '';
        foreach ($subs as $sub) {
            $buffer .= describeMetaItem($sub, $indent + 1);
        }
        return $buffer;
    }

    /** -----------------------
     *  2. Leaf node – print it
     * ---------------------*/
    $name   = isset($data['name'])   ? (string)$data['name']   : '[no name]';
    $unit   = isset($data['unit'])   ? (string)$data['unit']   : null;
    $remark = isset($data['remark']) ? (string)$data['remark'] : null;

    // Prefer `value`; fall back to `values` (array) → join with “, ”
    if (array_key_exists('value', $data)) {
        $value = $data['value'];
    } elseif (isset($data['values']) && is_array($data['values'])) {
        $value = implode(', ', array_map('strval', $data['values']));
    } else {
        $value = null;
    }
    $valueString = isset($value) ? (string)$value : 'null';

    // Build the label piecemeal so missing parts don’t break anything
    $label = $name;
    if ($unit   !== null && $unit   !== '') { $label .= " [$unit]"; }
    if ($remark !== null && $remark !== '') { $label .= " ($remark)"; }

    return str_repeat('  ', $indent) . $label . ': ' . $valueString . "\n";
}
