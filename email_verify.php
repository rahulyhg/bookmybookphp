<?php
include 'config.php';

$code=(isset($_REQUEST['c'])? $_REQUEST['c']:'');

$result = mysqli_query($db,"Select * from USER where VERI_CODE = '$code' ");
$row = $result->fetch_assoc();

if($row)
{
	$compl_verf = mysqli_query($db,"UPDATE USER SET VERI_CODE ='VERIFIED' where VERI_CODE = '$code' ");
	if($compl_verf)
	{
		echo "<h1>";
		echo "Verified Successfully";
		echo "</h1>";
	}
	else
	{
		echo "<h1>";
		echo "ERROR OCCURED";
		echo "</h1>";	
	}
}
else
{
	echo "<h1>";
	echo "ERROR OCCURED";
	echo "</h1>";	
}


?>