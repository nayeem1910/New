<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('https://yourdomain.com/oauth2callback.php');
$client->addScope('https://www.googleapis.com/auth/youtube.upload');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    file_put_contents('youtube-token.json', json_encode($token));
    echo "✅ Token saved! You can now upload videos.";
} else {
    echo "❌ No code received.";
}
