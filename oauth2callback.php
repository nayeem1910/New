<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('982444537092-ku2dcpeolqd15oeqrcura8s86c8pshls.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://yourdomain.com/oauth2callback.php');
$client->addScope('https://www.googleapis.com/auth/youtube.upload');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    file_put_contents('youtube-token.json', json_encode($token));
    echo "✅ Token saved! You can now upload videos.";
} else {
    echo "❌ No code received.";
}
