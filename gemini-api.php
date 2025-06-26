<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

$apiKey = "AIzaSyAniDZy-mJZD3RgKCpD64LPn8MzeT8vxgM"; // 🔁 Replace this with your real API key
$userPrompt = $_POST['text'] ?? '';

if (empty($userPrompt)) {
    echo json_encode(["error" => "No input provided"]);
    exit;
}

$data = [
  "contents" => [
    [
      "role" => "user",
      "parts" => [
        ["text" => $userPrompt]
      ]
    ]
  ]
];

$ch = curl_init("https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    echo json_encode(["error" => curl_error($ch)]);
} elseif ($http_code != 200) {
    echo json_encode(["error" => "HTTP $http_code", "response" => $response]);
} else {
    echo $response;
}
curl_close($ch);

?>
