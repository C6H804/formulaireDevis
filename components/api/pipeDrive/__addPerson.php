<?php
function addPerson($token, $name, $surname, $email, $phone, $address) {
    // echo "<script>console.log('Adding person: ' + " . json_encode([$name, $surname, $email, $phone]) . ");</script>";
    $url = "https://api.pipedrive.com/v1/persons?api_token=" . $token;
    $data = [
        "name" => $name . " " . $surname,
        "first_name" => $surname,
        "last_name"=> $name,
        "email" => [$email],
        "phone" => [$phone],
        "f9bb98d85ad690a8bdc2a2a5fbc55551cc1a669d" => $address
        ];
    $options = [
        "http" => [
            "header" => "Content-type: application/json\r\n",
            "method"=> "POST",
            "content" => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

?>