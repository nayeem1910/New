<?php
$logFile = 'log.txt';
function logMessage($msg) {
    file_put_contents($GLOBALS['logFile'], date('[Y-m-d H:i:s] ') . $msg . "\n", FILE_APPEND);
}

$image = 'image.jpg';
$audio = 'default.mp3';
$textUrl = 'txt.php'; // ✅ Dynamic source
$output = 'today.mp4';

// Check all files
if (!file_exists($image)) { logMessage("Missing image.jpg"); exit("❌ No image"); }
if (!file_exists($audio)) { logMessage("Missing default.mp3"); exit("❌ No audio"); }

// ✅ Fetch text from txt.php (can be static or dynamic PHP)
$textContent = @file_get_contents($textUrl);
if (!$textContent) { logMessage("Missing or failed to load txt.php"); exit("❌ No text content"); }

$textContent = str_replace("\n", '\n', $textContent);

// Build FFmpeg command
$cmd = "ffmpeg -y -loop 1 -i $image -i $audio -vf \"drawtext=text='$textContent':fontcolor=white:fontsize=30:x=(w-text_w)/2:y=(h-text_h)/2:box=1:boxcolor=black@0.5:boxborderw=5\" -shortest $output";

// Execute
logMessage("Running FFmpeg...");
exec($cmd . " 2>&1", $outputLog, $exitCode);

if ($exitCode === 0) {
    logMessage("✅ Video created: $output");
    echo "✅ Video generated successfully!";
} else {
    logMessage("❌ FFmpeg failed:\n" . implode("\n", $outputLog));
    echo "❌ Video generation failed!";
}
?>
