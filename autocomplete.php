<?php

// array for final json response
$response = array();

$text = isset($_POST['text']) ? $_POST['text'] : '';

if($text == '')
{
	$response['PHP'] = "autocomplete";
	$response['IS_ERROR'] = "N";
	$response['ERROR_MESSAGE'] = "No Error";
	$response['EXCEPTION'] = "No Exception";
	$response['USER_MESSAGE'] = "No User Message";
	echo json_encode($response);
}
else
{
	searchBookData($text);
}

function searchBookData($data)
{
	include 'config.php';

	$SQL = "Select * from BOOK where `TITLE` LIKE '%$data%'";
	
	$result = mysqli_query($db,$SQL);
	if($result)
	{
		$myArray = array();
       	while($result_val = $result->fetch_object()) 
	    	{
               $tempArray = $result_val;
               array_push($myArray, $tempArray);
        	}

		$response['PHP'] = "autocomplete";
		$response['IS_ERROR'] = "N";
		$response['ERROR_MESSAGE'] = "No Error Message";
		$response['EXCEPTION'] = "No Exception";
		$response['USER_MESSAGE'] = "No User Message";	
		$response['BOOKS_LIST'] = $myArray;
		mysqli_close($db);
	}
	else
	{
		$response['PHP'] = "autocomplete";
		$response['IS_ERROR'] = "Y";
		$response['ERROR_MESSAGE'] = "SQL failed: ".$SQL;
		$response['EXCEPTION'] = "No Exception";
		$response['USER_MESSAGE'] = "No User Message";
		mysqli_close($db);
	}

echo json_encode($response);
}





?>