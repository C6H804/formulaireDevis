<?php
function addDeal($token, $title, $value, $currency, $person_id, $address, $devis, $TVA, $stage_id = 17) {
    $url = "https://api.pipedrive.com/v1/deals?api_token=" . $token;
    $data = [
        "title" => $title,
        "value" => $value,
        "currency" => $currency,
        "person_id" => $person_id,
        // "stage_id" => 31,
        "stage_id" => $stage_id,
        // "stage_id" => 17,
        "48fe09ac430f6ed0cf66439cccde8ec99830be8c" => $address,
        "28b0fd48a7342c7dd136e759c3d1a032c0e40546" => $TVA === true ? 35 : 36,
        "b04cd4cdc4dd8dd4d94395c624a7e6a644d0bc25" => $devis
    ];
    $options = [
        "http" => [
            "header" => "Content-type: application/json\r\n",
            "method" => "POST",
            "content" => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

?>