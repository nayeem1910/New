<?php
$apiKey = "AIzaSyAniDZy-mJZD3RgKCpD64LPn8MzeT8vxgM"; // Keep this secret
$inputText = $_POST['text'] ?? '';

$data = [
  "contents" => [
    [
      "parts" => [
        [ "text" => $inputText ]
      ]
    ]
  ]
];

$options = [
  'http' => [
    'method'  => 'POST',
    'header'  => "Content-Type: application/json\r\n",
    'content' => json_encode($data)
  ]
];

$context = stream_context_create($options);
$response = file_get_contents("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=$apiKey", false, $context);
echo $response;
?>
