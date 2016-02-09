<?php
	// grab recaptcha library
require_once "recaptchalib.php";
$secret='6LcqABATAAAAABxfd3YDZWpcVlveBLMnNfl3nsA3';
$response=null;
$reCaptcha=new ReCaptcha($secret);
if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

require_once(dirname(__FILE__).'/../classes/WaitlistEntry.php');

$params = array();
$params['department'] = isset($_POST['dpmnt']) ? trim($_POST['dpmnt']) : "";
$params['course'] = isset($_POST['course']) ? trim($_POST['course']) : "";
$params['section'] = isset($_POST['section']) ? trim($_POST['section']) : "";
$params['fName'] = isset($_POST['fname']) ? trim($_POST['fname']) : "";
$params['lName'] = isset($_POST['lname']) ? trim($_POST['lname']) : "";
$params['studentId'] = isset($_POST['id']) ? trim($_POST['id']) : "";
$params['email'] = isset($_POST['email']) ? trim($_POST['email']) : "";
$params['reason'] = isset($_POST['reason']) ? trim($_POST['reason']) : "";

//echo print_r($params);

if($response!=null && $response->success){
	$request = new WaitlistEntry($params);
	try {
		$request->save();
		echo "success!";
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
else {
	echo "Captcha error. Please try again if you are a person. Stop if you are a bot.";
}
echo '<br/><a href="../../student.php">Submit another request</a>';
?>
