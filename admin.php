<?php
if(isset($_GET['done'])) {
$password = $_POST['passwort'];
$hashed_password = '$2y$10$Xwt3/H19QsPXJptiq2tH2uUdmvA3V38Ps82R7T1A40QrH3re3jZ32';
if(password_verify($password, $hashed_password)) {
	session_start();
	$_SESSION['admin'] = true;
	echo '<script type="text/javascript"> window.location = "settings.php?send=1"    </script>';
}else{echo "falsches password";} 
}
?>
<html> 
	<head>
	  <title>Login</title>    
	</head> 
	<body>
		<form action="?done=1" method="post">
			passwort:<br>
			<input type="password" size="40" maxlength="20" name="passwort"><br><br>
			<input type="submit" value="Abschicken">
		</form> 
	</body>
</html>