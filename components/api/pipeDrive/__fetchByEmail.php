<?php

function fetchPersonByEmail($token, $email) {
    $url = "https://api.pipedrive.com/v1/persons/search?term=" . urlencode($email) . "&fields=email&api_token=" . $token;
    $response = file_get_contents(filename: $url);
    return json_decode(json: $response, associative: true);
}

?>