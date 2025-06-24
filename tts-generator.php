<?php
$text = trim(shell_exec("php txt.php"));
$lang = "en"; // Change to "bn" for Bangla

// Encode the text
$encodedText = urlencode($text);

// Build the URL (Unofficial Google TTS)
$url = "https://translate.google.com/translate_tts?ie=UTF-8&q=$encodedText&tl=$lang&client=tw-ob";

// Save audio
$audioFile = "voice.mp3";
$audioData = file_get_contents($url);

if ($audioData && file_put_contents($audioFile, $audioData)) {
    header("Location: video-generator.php"); // 🔁 Redirect to next step
} else {
    echo "❌ Voiceover creation failed!";
}
?>
