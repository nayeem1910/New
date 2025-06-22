<?php
// Your FreeSound API key
$apiKey = '61ZDoilS2Zvuumesw3t1YJgukELo5YEOFJRuuz37';

// Get the word from URL, fallback to "calm"
$word = $_GET['word'] ?? 'calm';

// API URL
$url = "https://freesound.org/apiv2/search/text/?query=" . urlencode($word) . "&fields=id,name,previews&token=$apiKey";

// Call API
$response = file_get_contents($url);
$data = json_decode($response, true);

// Check and save MP3
if (!empty($data['results'][0]['previews']['preview-hq-mp3'])) {
    $mp3Url = $data['results'][0]['previews']['preview-hq-mp3'];
    $mp3Data = file_get_contents($mp3Url);
    file_put_contents("default.mp3", $mp3Data);
    echo "✅ Music for '$word' saved as default.mp3";
} else {
    echo "❌ No BGM found for '$word'";
}
?>
