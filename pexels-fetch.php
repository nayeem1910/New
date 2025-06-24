<?php
$pexelsApiKey = getenv("PEXELS_API_KEY") ?: "fOuF5nlf1UEsPIEuAeOjNeXpGXZAMCoxJWwNvyMkCyLWB8Oku5LZ4dpQ";
$searchQuery = $_GET['word'] ?? 'motivation';

// Pexels API endpoint
$url = "https://api.pexels.com/v1/search?query=" . urlencode($searchQuery) . "&per_page=1";

// Setup cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: $pexelsApiKey"
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode response
$data = json_decode($response, true);

if (!empty($data['photos'][0]['src']['large'])) {
    $imageUrl = $data['photos'][0]['src']['large'];
    $imageContent = file_get_contents($imageUrl);
    file_put_contents("image.jpg", $imageContent);
    header("Location: fetch-bgm.php"); // 🔁 Redirect to next step
} else {
    echo "No image found for '$searchQuery'.";
}
