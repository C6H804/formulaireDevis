<?php

function getImageUrl($file) {
    $apiKey = $_ENV["IMG_API_KEY"];
    $imageExpiration = $_ENV["IMG_EXPIRATION"];

    $imageData = file_get_contents($file['tmp_name']);
    $imageBase64 = base64_encode($imageData);

    $url = "https://api.imgbb.com/1/upload?key=" . $apiKey;
    $postData = array(
        "image" => $imageBase64,
        "expiration" => $imageExpiration
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $apiKey
    ));

    if ($_ENV["ENVIRONMENT"] === "development") {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    } else {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    }

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curlError) {
        $uploadError = "Upload error: " . $curlError;
    } else {
        $result = json_decode($response, true);

        if ($httpCode === 200 && isset($result['success']) && $result['success'] === true) {
            $uploadUrl = $result['data']['url'];
            return $uploadUrl ?? "";
            
        } else {
            $uploadError = "Upload failed with status code " . $httpCode;
        }
    }
    // echo $uploadError ?? "Unknown error during image upload."; //debug
    return "";
}