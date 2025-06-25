<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('982444537092-ku2dcpeolqd15oeqrcura8s86c8pshls.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://new-kb9a.onrender.com/oauth2callback.php');
$client->addScope('https://www.googleapis.com/auth/youtube.upload');

$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit();
