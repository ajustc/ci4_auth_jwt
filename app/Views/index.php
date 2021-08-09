<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Index HOME</title>
</head>

<body>
	<?php

	// $json = file_get_contents("http://localhost/4ci4/restful/public/users");
	$json = file_get_contents("http://192.168.1.10/ci4_auth_jwt/public/apiproduk/");
	$data = json_decode($json, true);
	var_dump($data);

	?>
	<!-- <a href="http://localhost/4ci4/restful/public/users">Click Me JSON</a> -->
</body>

</html>