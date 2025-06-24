it<?php
date_default_timezone_set('Asia/Dhaka'); // Optional: Set your timezone
$logFile = "log.txt";

// Start logging
function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] $message\n", FILE_APPEND);
}

// Read image, audio, and text
$image = "image.jpg";
$audio = "default.mp3";
$textSource = "txt.php";
$output = "today.mp4";

if (!file_exists($image)) {
    logMessage("❌ image.jpg not found.");
    exit("Image missing.");
}

if (!file_exists($audio)) {
    logMessage("❌ default.mp3 not found.");
    exit("Audio missing.");
}

if (!file_exists($textSource)) {
    logMessage("❌ txt.php not found.");
    exit("Text source missing.");
}

// Read first line of text from txt.php
// $textRaw = file_get_contents($textSource);
// $textRaw = strip_tags($textRaw);
// $textLines = explode("\n", $textRaw);
// $firstLine = trim($textLines[0]);
// $escapedText = escapeshellarg($firstLine);

// logMessage("Text: " . $firstLine);

// FFmpeg command
$escapedText = escapeshellarg(trim(shell_exec("php txt.php")));

$drawText = "drawtext=fontfile='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf':"
. "text=$escapedText:"
. "fontcolor=white:"
. "fontsize=32:"
. "x=(w-text_w)/2:"
. "y=(h-text_h)/2:"
. "alpha='if(lt(t,1),0, if(lt(t,3),(t-1)/2, if(lt(t,5),1, if(lt(t,7),(7-t)/2, 0))))'";

$cmd = "ffmpeg -loop 1 -i $image -i $audio -t 10 -vf "$drawText" -shortest -y $output";




// Run FFmpeg
logMessage("Running FFmpeg...");
exec($cmd . " 2>&1", $outputLines, $exitCode);

// Log result
if ($exitCode === 0) {
    logMessage("✅ Video generated: $output");
    echo "Video generated successfully!";
} else {
    logMessage("❌ FFmpeg failed: " . implode("\n", $outputLines));
    echo "Video generation failed!";
}
?>
