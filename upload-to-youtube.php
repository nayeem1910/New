$client = new Google_Client();
$client->setClientId('982444537092-ku2dcpeolqd15oeqrcura8s86c8pshls.apps.googleusercontent.com');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setAccessToken(json_decode(file_get_contents('youtube-token.json'), true));

if ($client->isAccessTokenExpired()) {
    echo "❌ Token expired. Please reauthorize.";
    exit;
}

$youtube = new Google_Service_YouTube($client);

// Now you can upload the video using YouTube API
