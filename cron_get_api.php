<?php 


require_once(dirname(__FILE__) . '/wp-load.php');

function parse_data($url)
{
        
    $xmlfile = file_get_contents($url);
    // Convert xml string into an object
    $new = simplexml_load_string($xmlfile);
    // Convert into json
    $con = json_encode($new);
    // Convert into associative array
    return $newArr = json_decode($con, true);


}

$resorts=parse_data('https://agents.alida.lv/xml.php?what=resorts');

print_r($resorts);