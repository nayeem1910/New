<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret.json'); // Replace with your file if named differently
$client->addScope(Google_Service_YouTube::YOUTUBE_UPLOAD);
$client->setAccessType('offline');

// Load saved token
$tokenPath = 'youtube-token.json';
if (!file_exists($tokenPath)) {
    exit("❌ Token not found. Please run authorize.php first.\n");
}

$accessToken = json_decode(file_get_contents($tokenPath), true);
$client->setAccessToken($accessToken);

// Refresh token if expired
if ($client->isAccessTokenExpired()) {
    exit("❌ Access token expired. Delete youtube-token.json and run authorize.php again.\n");
}

$youtube = new Google_Service_YouTube($client);

// Video info
$videoPath = "today.mp4";
if (!file_exists($videoPath)) {
    exit("❌ Video file not found: $videoPath\n");
}

$snippet = new Google_Service_YouTube_VideoSnippet();
$snippet->setTitle("Word of the Day: Courage"); // You can update dynamically
$snippet->setDescription("This is an auto-generated Word of the Day video.");
$snippet->setTags(["Word of the Day", "Motivation", "English", "Bangla"]);

$status = new Google_Service_YouTube_VideoStatus();
$status->privacyStatus = "public"; // Change to 'private' or 'unlisted' if needed

$video = new Google_Service_YouTube_Video();
$video->setSnippet($snippet);
$video->setStatus($status);

// Upload
$chunkSizeBytes = 1 * 1024 * 1024; // 1MB per chunk
$client->setDefer(true);

$insertRequest = $youtube->videos->insert("status,snippet", $video);

$media = new Google_Http_MediaFileUpload(
    $client,
    $insertRequest,
    'video/*',
    null,
    true,
    $chunkSizeBytes
);
$media->setFileSize(filesize($videoPath));

$handle = fopen($videoPath, "rb");
while (!$media->nextChunk($handle)) {}
fclose($handle);

echo "✅ Video uploaded successfully to YouTube!";
?>
