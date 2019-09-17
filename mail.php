<?php
// We only do stuff if there's a POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
		// Sanitize user input
		$_POST = array_map("strip_tags", $_POST);
		$_POST = array_map("htmlspecialchars", $_POST);

		// Subject
		$subject = $_POST["subject"];

		// Search and replace variables (and whatever else)
		$arrS = [
			"{name}",
			"{email}",
			"{phone}",
			"{message}",
			"{date}",
			"{ip}"
		];
		$arrR = [
			$_POST["name"],
			$_POST["email"],
			$_POST["phone"],
			str_replace("\n", "<br />", $_POST["message"]),
			date('Y-m-d H:i:s'),
			$_SERVER["REMOTE_ADDR"]
		];
		$template = "Hi,<br /><br />You have received a new message from your website.<br /><br />Name: {name}<br />E-mail: {email}<br />Phone: {phone}<br />Message:<br />{message}<br /><br />Date: {date}<br />Remote IP: {ip}<br /><br />Have a nice day.";
		$template = str_replace($arrS, $arrR, $template);

		// Body
		$body = "<html><body>" . $template . "</body></html>";
			
		// Set headers
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8\r\n";
		$headers .= "From: \"Website\" <web@zahirkhailani.com.my>\r\n";
		$headers .= "Reply-To: web@zahirkhailani.com.my";

		// Send the mail
		if ( mail("info@zahirkhailani.com.my", $subject, $body, $headers) ) {
			echo "1";
		}
	}
	catch (Exception $e) {
	}
}
?>