<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

$apiKey = "AIzaSyAniDZy-mJZD3RgKCpD64LPn8MzeT8vxgM"; // replace this

$input = $_POST['text'] ?? '';
if (empty($input)) {
    echo json_encode(["error" => "No input received"]);
    exit;
}

$data = [
  "contents" => [
    [
      "parts" => [
        ["text" => $input]
      ]
    ]
  ]
];

$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo json_encode(["error" => "Curl error: $curl_error"]);
} elseif ($http_code != 200) {
    echo json_encode(["error" => "HTTP error: $http_code", "response" => $response]);
} else {
    echo $response;
}
