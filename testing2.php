<html>
<head>
<title>RM PM System</title>
<h3>RM PM System</h3>
<hr>
</head>
<body>
<?php
	$rcs = $_POST['rcs'];
	$recip = $_POST['id'];
	$subj = "Automated RC Notification";
	$body = "You have " . $rcs . " RCs.\r\n(If no number was displayed, there was an error)";
echo($recip."<br>".$body);
	
	$username = "";
	$password = "";
	
	$cookies = "";
	$ch = curl_init("https://www.roblox.com/newlogin");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch,CURLOPT_POST, 2);
	curl_setopt($ch,CURLOPT_POSTFIELDS, "username=$username&password=$password"); // dem credentials
	$result = curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^\r;]*)/mi', $result, $ms);
	foreach ($ms[1] as $m) {
		$cookies = $cookies . $m . "; ";
	}
	curl_close($ch);
	
	// Get the request validation token that is needed to send messages.
	$url = "http://www.roblox.com/User.aspx?ID=9179740&ForcePublicView=true";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, " ");
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookies"));
	$content = curl_exec($ch);
	curl_close($ch);
	if (strpos($content,"Roblox.XsrfToken.setToken('") != false) {
		$start = strpos($content,"Roblox.XsrfToken.setToken('") + 27;
		$length = strpos($content,"');",$start) - $start;
		$key = substr($content,$start,$length);
echo("<br>Got key: ".$key);
$xcsrf=$key;
	}
else{
echo("Did not find Token in headers");
}
	
	// Get some extra cookies that are needed to send Messages.
	$ch = curl_init("http://web.roblox.com/build/upload?groupId=1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: $cookies"));
	$result = curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^\r;]*)/mi', $result, $ms);
	foreach ($ms[1] as $m) {
		$cookies = $cookies . $m . "; ";
	}
	curl_close($ch);
	$cookies = "nopeyoucanthavemycookies=1";
	$url = "http://www.roblox.com/messages/send?token=" . urlencode($key);
	$ch = curl_init($url);
	$fields_string = "";
	$fields = array(
		'subject' => $subj,
		'body' => $body,
		'recipientid' => $recip,
		'cachebuster' => urlencode("120398120948" + $time),
	);
	foreach($fields as $key=>$value) {
		if ($key == "cachebuster") {
			$fields_string .= $key.'='.$value;
		} else {
			$fields_string .= $key.'='.$value.'&';
		}
	}
$len=strlen($fields_string);
	rtrim($fields_string, '&');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Host: www.roblox.com",
		"Connection: keep-alive",
		"Content-Length: 149",
		"Accept: application/json, text/javascript",
		"Origin: http://www.roblox.com",
"X-CSRF-TOKEN: $xcsrf",
		"X-Requested-With: XMLHttpRequest",
		"User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36",
		"Content-Type: application/x-www-form-urlencoded",
		"Referer: http://www.roblox.com/My/NewMessage.aspx?RecipientID=$recip",
		"Accept-Encoding: gzip,deflate,sdch",
		"Accept-Language: en-US,en;q=0.8",
		"Cookie: $cookies",
	));
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	$result = curl_exec($ch);
echo $result;

?>
</body>
</html>			