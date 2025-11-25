<?php 

function fetchPersons($token) {
    $url = "https://api.pipedrive.com/v1/persons?api_token=" . $token;
    $response = file_get_contents($url);
    return json_decode($response, true);
}


?>