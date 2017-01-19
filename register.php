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

$email=(isset($_REQUEST['email'])? $_REQUEST['email']:'');
$mobile=(isset($_REQUEST['mobile'])? $_REQUEST['mobile']:'');
$password=(isset($_REQUEST['password'])? $_REQUEST['password']:'');
$name=(isset($_REQUEST['name'])? $_REQUEST['name']:'');
$gender=(isset($_REQUEST['gender'])? $_REQUEST['gender']:'');
$city=(isset($_REQUEST['city'])? $_REQUEST['city']:'');

$SQL = "Select MOBILE,EMAIL from USER where MOBILE = '$mobile' OR EMAIL = '$email' ";

$usercheck = mysqli_query($db,$SQL);

$row = $usercheck->fetch_row();

	if($row[0]==$mobile)  
	{
		$data["errorCode"]= $MOBILE_EXISTS;
		$data["errorMessage"]="Mobile no already exist";
		echo json_encode($data);
	}
	else if($row[1]==$email)
	{
		$data["errorCode"]= $EMAIL_EXISTS;
		$data["errorMessage"]="Email id already exist";
		echo json_encode($data);
	}
	else
	{
	$veri_code = generateRandomString(); 
	$salt_str = generateSalt(); 

	$password = $password.$salt_str;
	$password = base64_encode($password);

	$salt = base64_encode($salt_str);

	$result = mysqli_query($db,"INSERT INTO USER (EMAIL,MOBILE,PASSWORD,NAME,GENDER,CITY,VERI_CODE,SALT,CREATE_DTM) values('$email','$mobile','$password','$name','$gender','$city','$veri_code','$salt',CURRENT_TIMESTAMP)");

	mailtrigger($email,$veri_code);

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

function mailtrigger($mailto,$vrfctn_code)
{
				//$to = $mailto;
				$to = "dial2vishal@gmail.com";
				$subject = "PAYPER BOOK EMAIL VERIFICATION EMAIL";

				$message = "
				<html>
				<head>
				<title>Email Verification</title>
				</head>
				<body>
				Hi,<br>
				<p>This is auto-generated email,Do not reply to this mail.</p>
	            CLICK ON THE LINK TO CONFIRM YOUR EMAIL AND STAY CONNECTED
	            	            <br><br><br><br>
	            <b>Thanks,<br>
	            PayPer Book Team</b>
				</body>
				</html>";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				mail($to,$subject,$message,$headers);

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateSalt($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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