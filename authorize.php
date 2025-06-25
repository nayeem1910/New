<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('https://yourdomain.com/oauth2callback.php');
$client->addScope('https://www.googleapis.com/auth/youtube.upload');

$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit();
