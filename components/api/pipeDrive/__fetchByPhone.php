<?php 
function fetchPersonByPhoneNumber($token, $phone) {
    $url = "https://api.pipedrive.com/v1/persons/search?term=" . urlencode($phone) . "&fields=phone&api_token=" . $token;
    $response = file_get_contents(filename: $url);
    return json_decode(json: $response, associative: true);
}

?>