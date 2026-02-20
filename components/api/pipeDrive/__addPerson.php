<?php
function addPerson($token, $name, $surname, $email, $phone, $address, $postalCode, $locality) {
    // echo "<script>console.log('Adding person: ' + " . json_encode([$name, $surname, $email, $phone]) . ");</script>";
    $url = "https://api.pipedrive.com/v1/persons?api_token=" . $token;
    $data = [
        "name" => $surname . " " . $name,
        "email" => [["label" => "devis en ligne", "primary" => true, "value" => $email]],
        "phone" => [["label" => "devis en ligne", "primary" => true, "value" => $phone]],
        // "48fe09ac430f6ed0cf66439cccde8ec99830be8c" => $address ?? "",
        // "48fe09ac430f6ed0cf66439cccde8ec99830be8c_postal_code" => "$postalCode" ?? "",
        // "48fe09ac430f6ed0cf66439cccde8ec99830be8c_locality"=> "$locality" ?? ""
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