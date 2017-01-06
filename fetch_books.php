<?php
include 'error_code.php';

$code=(isset($_REQUEST['code'])? $_REQUEST['code']:'CNF');

if($code == 'ALL')
{
	all_books();
}
else
{
	echo "$CODE_NOT_FOUND";
}

function all_books()
{
include 'config.php';

$sql = "SELECT * FROM `BOOK`";

$book_data = mysqli_query($db,$sql);
$myArray = array();
       while($bookobj = $book_data->fetch_object()) 
	    {
                $tempArray = $bookobj;
                array_push($myArray, $tempArray);
        }
		$res["book_data"] = $myArray;
        echo json_encode($res);
}

?>