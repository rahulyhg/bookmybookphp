<?php
$ssid=(isset($_REQUEST['ssid'])? $_REQUEST['ssid']:'');

if($ssid == '')
{
	lo_validate();
}
else
{
	ss_validate();
}

function lo_validate()
{

include 'config.php';
include 'error_code.php';

$email=(isset($_REQUEST['email'])? $_REQUEST['email']:'');
$password=(isset($_REQUEST['password'])? $_REQUEST['password']:'');

	if($email == '' || $password = '')
	{
			$data["errorCode"]=$FAILURE;
			$data["errorMessage"]="email and password came blank..!!";
			echo json_encode($data);
	}
	else
	{
		$email=(isset($_REQUEST['email'])? $_REQUEST['email']:'');
		$password=(isset($_REQUEST['password'])? $_REQUEST['password']:'');

		$salt_result = mysqli_query($db,"Select SALT from USER where EMAIL = '$email'");
		if($salt_result)
		{
			$salt_val = $salt_result->fetch_assoc();
			$salt = $salt_val['SALT'];
			
			$salt = base64_decode($salt);

			$password_str = base64_encode($password.$salt);
			$password = $password_str;

		}
		else
		{
			mysqli_close($db);
			$data["errorCode"]=$FAILURE;
			$data["errorMessage"]="User not Found";
			echo json_encode($data);
		}

		$result = mysqli_query($db,"Select * from USER where EMAIL = '$email' AND PASSWORD = '$password'");
		$row = $result->fetch_assoc();

		if($row['EMAIL']==$email && $row['PASSWORD']==$password)
		{	
			session_start();
			$_SESSION['sid']=session_id();
			$ssid = $_SESSION['sid'];
		
		$email=(isset($_REQUEST['email'])? $_REQUEST['email']:'');
		$password=(isset($_REQUEST['password'])? $_REQUEST['password']:'');
		
			$query ="UPDATE USER SET SSID ='$ssid' WHERE EMAIL = '$email' AND PASSWORD = '$password'";
					$ssid_ins = mysqli_query($db,$query);
					
						if(!$ssid_ins)
						{
							mysqli_close($db);
							$data["errorCode"]= $FAILURE;
							$data["errorMessage"]="ERROR INSERTING SSID";
						}

			$data["errorCode"]	="$SUCCESS";
			$data["errorMessage"]="Login Success";
			$data["SSID"]		=$row['SSID'];
	
			
			echo json_encode($data);
			mysqli_close($db);
		}
		else
		{
			mysqli_close($db);
			$data["errorCode"]=$FAILURE;
			$data["errorMessage"]="Login failed, Invalid Credentials";
			echo json_encode($data);
		}
	}
}

function ss_validate()
{

include 'config.php';
include 'error_code.php';

$ssid=(isset($_REQUEST['ssid'])? $_REQUEST['ssid']:'');
	if($ssid == '')
	{
			$data["errorCode"]=$FAILURE;
			$data["errorMessage"]="SSID came blank..!!";
			echo json_encode($data);
	}
	else
	{
		$result = mysqli_query($db,"Select * from USER where SSID = '$ssid'");
		$row = $result->fetch_assoc();

		if($row)
		{
			$data["errorCode"]	="$SUCCESS";
			$data["errorMessage"]="Session Restored";

			$data["NAME"]		=$row['NAME'];
			$data["EMAIL"]		=$row['EMAIL'];
			$data["MOBILE"]		=$row['MOBILE'];
			$data["CITY"]		=$row['CITY'];
			$data["GENDER"]		=$row['GENDER'];	
			
			echo json_encode($data);
			mysqli_close($db);

		}
		else
		{
			mysqli_close($db);
			$data["errorCode"]=$FAILURE;
			$data["errorMessage"]="Session Out";
			echo json_encode($data);
		}
	}
}
?>