<?php

// Path to move uploaded files
$target_path = "/opt/lampp/htdocs/bmb/bookim/";
 
// array for final json response
$response = array();
if (isset($_FILES['image'])) 
{
    move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
    echo "moved";
} 
else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
    print_r($_FILES);
}
 
// Echo final json response to client
echo json_encode($response);
?>