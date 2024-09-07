<?php
function passedReCaptcha(string $secret, string $response):bool{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => ['secret' => $secret, 'response' => $response],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, TRUE)['success'];
}