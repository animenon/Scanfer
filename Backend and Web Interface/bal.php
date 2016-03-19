<?php
		$DB_host = "localhost";
		$DB_user = "root";
		$DB_pass = "";
		$DB_name = "tolls_data";

	$user_id = $_GET["user_id"];


		$conn = new MySQLi($DB_host,$DB_user,$DB_pass,$DB_name);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}	
	$phone=intval("9876543210");
	$sql1 = "Select balance,phone from user_table where email_id ='$user_id'";
	$balance = 0;
	$result = $conn->query($sql1);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			$balance = $row['balance'];
			$phone = $row['phone'];
		}
	}
	echo "$balance";
	$conn->close();

$post_data = array(
    // 'From' doesn't matter; For transactional, this will be replaced with your SenderId;
    // For promotional, this will be ignored by the SMS gateway
    'From'   => '8808891988',
    'To'    => $phone,
    'Body'  => 'Hi Tolpe here!', //Incase you are wondering who Dr. Rajasekhar is http://en.wikipedia.org/wiki/Dr._Rajasekhar_(actor)
);
 
$exotel_sid = "igate3"; // Your Exotel SID - Get it from here: http://my.exotel.in/Exotel/settings/site#api-settings
$exotel_token = "8a41e4c5395b1c7c01957b99d947d6e0bbf907ae"; // Your exotel token - Get it from here: http://my.exotel.in/Exotel/settings/site#api-settings
 
$url = "https://".$exotel_sid.":".$exotel_token."@twilix.exotel.in/v1/Accounts/".$exotel_sid."/Sms/send";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FAILONERROR, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
 
$http_result = curl_exec($ch);
$error = curl_error($ch);
$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
 
curl_close($ch);
 
print "Response = ".print_r($http_result);

?>