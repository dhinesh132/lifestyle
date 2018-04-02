<?php

$number = 12345678;

$barcode_font = 'font/FREE3OF9.TTF';
$plain_font   = 'font/plain.pfb';

$width = 200;
$height = 80;

$img = imagecreate($width, $height);

// First call to imagecolorallocate is the background color
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);

// Reference for the imagettftext() function
// imagettftext($img, $fontsize, $angle, $xpos, $ypos, $color, $fontfile, $text);
imagettftext($img, 36, 0, 10, 50, $black, $barcode_font, $number);

imagettftext($img, 14, 0, 40, 70, $black, $plain_font, $number);

//header('Content-type: image/png');
header('Content-type: image/gif');
imagegif($img);
//imagepng($img);
//imagedestroy($img);

?>