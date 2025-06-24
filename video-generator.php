<?php

date_default_timezone_set("Asia/Dhaka");
$logFile = "log.txt";
file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Starting video generation...\n", FILE_APPEND);

// Fetch values
$image = "image.jpg";
$audio = "default.mp3";
$output = "today.mp4";

// Generate text from PHP file
$text = trim(shell_exec("php txt.php"));
file_put_contents("ffmpeg_text.txt", $text);

// FFmpeg drawtext filter
$drawText = "drawtext=fontfile='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf':"
          . "textfile='ffmpeg_text.txt':"
          . "fontcolor=white:fontsize=32:x=(w-text_w)/2:y=(h-text_h)/2:"
          . "alpha='if(lt(t,1),0, if(lt(t,3),(t-1)/2, if(lt(t,5),1, if(lt(t,7),(7-t)/2, 0))))'";

// FFmpeg command
$ffmpegCommand = "ffmpeg -loop 1 -i $image -i $audio -t 10 -vf \"$drawText\" -shortest -y $output";

// Run command and log
file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Running FFmpeg...\n", FILE_APPEND);
exec($ffmpegCommand . " 2>&1", $outputLines, $exitCode);

if ($exitCode === 0) {
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] ✅ Video created successfully!\n", FILE_APPEND);
} else {
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] ❌ FFmpeg failed:\n" . implode("\n", $outputLines) . "\n", FILE_APPEND);
}

?>
