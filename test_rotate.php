<?php
$path = 'public/logo.jpg';
$size = getimagesize($path);
if ($size) {
    echo "Width: " . $size[0] . ", Height: " . $size[1] . "\n";
    $imageResource = imagecreatefromstring(file_get_contents($path));
    if ($imageResource !== false) {
        $rotated = imagerotate($imageResource, 270, 0);
        ob_start();
        imagejpeg($rotated);
        $data = ob_get_clean();
        echo "Rotated data length: " . strlen($data) . "\n";
    }
}
