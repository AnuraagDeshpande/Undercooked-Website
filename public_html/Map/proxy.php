<?php
//THIS FILE IS NEEDED TO AVOID CORS ISSUES WITH IPINFO
$token = '62d670d4193da6';
$url = "https://ipinfo.io/json?token=$token";

// fetching data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Sends response back to the server
header('Content-Type: application/json');
echo $response;
?>
