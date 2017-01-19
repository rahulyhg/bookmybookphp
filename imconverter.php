<?php

$code=$_REQUEST['code'];
if($code == 'I')
{
	imtobyte();
}
else if($code == 'B')
{
	bytetoim();
}
else
{
	echo "Error Occured";
}

function imtobyte()
{
$path = "bookim/book7.jpg";//Image path

$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

echo $base64;

}

function bytetoim()
{
$data=$_REQUEST['imdata'];
$data = base64_decode($data);

$im = imagecreatefromstring($data);
$path = "png.png";
if ($im !== false) {
    header('Content-Type: image/png');
    imagepng($im);
    imagepng($im,$path);
    imagedestroy($im);
}
else {
    echo 'An error occurred.';
}

}

?>