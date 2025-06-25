<?php
error_reporting(0);
header("Content-Type: application/json");

// 1. Load your API key
$apiKey = "AIzaSyAniDZy-mJZD3RgKCpD64LPn8MzeT8vxgM"; // Replace with your real key

// 2. Get the input
$input = $_POST['text'] ?? '';

// 3. Create the payload
$data = [
  "contents" => [
    [
      "parts" => [
        ["text" => $input]
      ]
    ]
  ]
];

// 4. Initialize cURL
$ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json"
]);

// 5. Execute and decode
$response = curl_exec($ch);
curl_close($ch);

// 6. Output the result
echo $response;
