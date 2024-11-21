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
header('Access-Control-Allow-Origin: *'); // Allows all domains to access the response
header('Content-Type: application/json'); // Tells the client it's JSON data
echo $response;
?>
