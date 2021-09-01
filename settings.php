<?php
session_start();
$admin = $_SESSION['admin']; 

if($admin == true){
	echo "<h3>Kürzel:</h3>";
	
	$csv = array_map('str_getcsv', file('users.csv'));
	
	foreach($csv[0] as $element){
	echo "<p>" . $element . "</p>";
	}
	#

	if(isset($_POST['erstellen'])) {
		$kürzel = $_POST['kürzel'];
		
		$fp = fopen('users.csv', 'a');
		fwrite($fp,'"' . $kürzel . '",');
		
		unset($_COOKIE[session_name()]);
		setcookie(session_name(), null, -1, '/'); 	
		echo '<script type="text/javascript"> window.location = "index.php"</script>';

	}elseif(isset($_POST['löschen'])){

		$kürzel = $_POST['kürzel'];
		$search = array_search($kürzel, $csv[0]);
		
		if ($search !== False) {
			unset($csv[0][$search]);
			
			$handle = fopen("users.csv","w");
			foreach(array_filter($csv[0]) as $element){
				fwrite($handle,'"' . $element . '",');
			}
			fclose($handle);
		}
		unset($_COOKIE[session_name()]);
		setcookie(session_name(), null, -1, '/'); 	
		echo '<script type="text/javascript"> window.location = "index.php"</script>';
	}
}else{
echo '<script type="text/javascript"> window.location = "index.php"</script>';
}
?>
<html> 
	<head>
	  <title>Login</title>    
	</head> 
	<body>
		<form action="settings.php" method="post">
			<input type="text" size="40" maxlength="4" name="kürzel"><br><br>
			<input type="submit" value="Erstellen" name="erstellen">
			<input type="submit" value="Löschen" name="löschen" >
		</form> 
	</body>
</html>