<?php

include 'error_code.php';
include 'config.php';

$code=(isset($_REQUEST['code'])? $_REQUEST['code']:null);

if($code == 1)
{
	register();
}
else if($code == 2)
{
	modify();
}
else if($code == 3)
{
	delete();
}
else if($code == 4)
{
	login();
}
else
{
	echo $CODE_NOT_FOUND;
}


function register()
{
include 'error_code.php';
include 'config.php';
$user_id=(isset($_REQUEST['user_id'])? $_REQUEST['user_id']:vishal);
$email=(isset($_REQUEST['email'])? $_REQUEST['email']:vishalva06gmail.com);
$mobile=(isset($_REQUEST['mobile'])? $_REQUEST['mobile']:8124627522);
$password=(isset($_REQUEST['password'])? $_REQUEST['password']:test123);
$name=(isset($_REQUEST['name'])? $_REQUEST['name']:vishal);
$gender=(isset($_REQUEST['gender'])? $_REQUEST['gender']:m);
$city=(isset($_REQUEST['city'])? $_REQUEST['city']:chennai);

$SQL = "Select USER_ID from USER where USER_ID = '$user_id'";

$usercheck = mysqli_query($db,$SQL);

$row = $usercheck->fetch_row();

	if($row[0]==$user_id)
	{
		$data["errorCode"]= $USER_ID_EXISTS;
		$data["errorMessage"]="User_id already exist";
		echo json_encode($data);
	}
	else
	{
	$result = mysqli_query($db,"INSERT INTO USER (USER_ID,EMAIL,MOBILE,PASSWORD,NAME,GENDER,CITY,CREATE_DTM) values('$user_id','$email','$mobile','$password','$name','$gender','$city',CURRENT_TIMESTAMP)");
	}
	
	if($result)
	{
		$json_response = array();
		mysqli_close($db);
		$data["errorCode"]= $SUCCESS;
		$data["errorMessage"]="User Registered Successfully";
		echo json_encode($data);
	}
	else
	{
		mysqli_close($db);
	  //	die('Could not enter data: '.mysqli_error());
	}
}

function modify()
{
include 'error_code.php';
include 'config.php';
$user_id=(isset($_REQUEST['user_id'])? $_REQUEST['user_id']:'vishal');
$email=(isset($_REQUEST['email'])? $_REQUEST['email']:'vishalva06egmail.com');
$mobile=(isset($_REQUEST['mobile'])? $_REQUEST['mobile']:8124627522);
$password=(isset($_REQUEST['password'])? $_REQUEST['password']:test123);
$name=(isset($_REQUEST['name'])? $_REQUEST['name']:vishal);
$gender=(isset($_REQUEST['gender'])? $_REQUEST['gender']:m);
$city=(isset($_REQUEST['city'])? $_REQUEST['city']:chennai);

$SQL = "Select USER_ID from USER where USER_ID = '$user_id'";

$usercheck = mysqli_query($db,$SQL);

$row = $usercheck->fetch_row();

	if($row[0]!=$user_id)
	{
		$data["errorCode"]= $USER_NOT_EXISTS;
		$data["errorMessage"]="User Not Found";
		echo json_encode($data);
	}
	else
	{	
		$SQL = "UPDATE USER SET EMAIL = '$email', MOBILE = '$mobile',PASSWORD = '$password',NAME = '$name',GENDER = '$gender',CITY = '$city'	,MOD_DTM = CURRENT_TIMESTAMP WHERE USER_ID = '$user_id'";
		
		$result = mysqli_query($db,$SQL);
		
		if($result)
		{
			$json_response = array();
			mysqli_close($db);
			$data["errorCode"]= $SUCCESS;
			$data["errorMessage"]="User Details Modified Successfully";
			echo json_encode($data);
		}
		else
		{
			mysqli_close($db);
		  //	die('Could not enter data: '.mysqli_error());
		}
	}

}

function delete()
{
include 'error_code.php';
include 'config.php';
$user_id=(isset($_REQUEST['user_id'])? $_REQUEST['user_id']:vishal);


$SQL = "Select USER_ID from USER where USER_ID = '$user_id'";

$usercheck = mysqli_query($db,$SQL);

$row = $usercheck->fetch_row();

	if($row[0]!=$user_id)
	{
		$data["errorCode"]= $USER_NOT_EXISTS;
		$data["errorMessage"]="User Not Found";
		echo json_encode($data);
	}
	else
	{	
		$SQL = "DELETE FROM USER WHERE USER_ID = '$user_id'";
		
		$result = mysqli_query($db,$SQL);
		
		if($result)
		{
			$json_response = array();
			mysqli_close($db);
			$data["errorCode"]= $SUCCESS;
			$data["errorMessage"]="User Deleted Successfully";
			echo json_encode($data);
		}
		else
		{
			mysqli_close($db);
		  //	die('Could not enter data: '.mysqli_error());
		}
	}

}

function login()
{
	include 'error_code.php';
include 'config.php';

$user_id=(isset($_REQUEST['user_id'])? $_REQUEST['user_id']:vishal);
$password=(isset($_REQUEST['password'])? $_REQUEST['password']:test123);


	$result = mysqli_query($db,"Select USER_ID,PASSWORD from USER where USER_ID = '$user_id' AND PASSWORD = '$password'");

	$row = $result->fetch_row();
	if($row[0]==$user_id && $row[1]==$password)
	{
		$data["errorCode"]=$SUCCESS;
		$data["errorMessage"]="login success";
		echo json_encode($data);

	}
	else
	{
		$data["errorCode"]=$FAILURE;
		$data["errorMessage"]="login failed";
		echo json_encode($data);
		mysqli_close($db);
	}
}


?>