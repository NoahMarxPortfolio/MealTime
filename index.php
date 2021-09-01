<!doctype html>
<html lang="en">
	<head>
	<!-- 
	==============================
	Made by Anna Wysocka, ver. 0.2
	==============================
	-->
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="asset/css/bootstrap.min.css"> <!-- implementiert CSS stylesheet -->
	<title>Essensbestellung</title>
	<style> 
	html, body {
	/* height: 100%;  gibt die Höhe der Seite an, um sich auf fullscreen anzupassen */
	background-image: url("food1b.jpeg");
	background-size: cover;
	background-repeat:no-repeat;  /* Hintergrund ohne Wiederholung */
	 <!-- background-position:right bottom; -->
	}
	.custom {
    width: 250px !important; /* Länge von Buttons */
	}
	.dropdown-toggle {
		background-color: #e7e7e7;
	}
	.erste-reihe{
		height: 250px;
	}
	
	.zweite-reihe{
		height: 340px;
	}
	.btn{
		
		height:80px;
	}
	.btn-success{
		background-color: #4eb14e;
		color:#FFF;
		
	}
	.btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active, .open .dropdown-toggle.btn-success {
	background-color: #1f471f;
	color:#FFF;
	border-color: #1f471f;
	}
	
	.btn-danger{
		background-color: #d64843;
		color:#FFF;
		
	}
	.btn-danger:hover, .btn-danger:focus, .btn-danger:active, .btn-danger.active, .open .dropdown-toggle.btn-danger {
	background-color: #7d1f1c;
	color:#FFF;
	
	}
	
	.btn-info{
		background-color: #41b5d8;
		color:#FFF;
		
	}
	.btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active, .open .dropdown-toggle.btn-info {
	background-color: #114555;
	color:#FFF;
	border-color: #114555;
	}

	</style>
	</head>
	<body>
	<main>
		<div  class="container">
		<div class="col align-self-center">
		<div class="row erste-reihe">
		<div class="col">
		</div>
		</div>
		<div style="line-height:150px;">
			<div class="row">
				<div class="col-sm-8">
					
					<h2 align="center" id = "status">Hauptgerichte</h2>
					<div class="text-center">
					<div style="line-height:200px;">
					<button type="button" id="veg" class="btn btn-success btn-lg custom" aria-label="Klicke hier um vegetarisches Gericht auszuwählen" onclick="veg()"><i class='fas fa-carrot'></i> Vegetarisches Gericht </button>
					<button type="button" id="fleisch" class="btn btn-danger btn-lg custom" aria-label="Klicke hier um ein Fleischgericht auszuwählen" onclick="fleisch()"><i class='fas fa-drumstick-bite'></i> Fleischgericht </button>
					</div>
					</div>
				</div>
					<div class="col-sm-4">
					
					<div class="text-center">
					<h2 align="center">Zusatz</h2>
					<div style="line-height:200px;">
					<button type="button" id="salat" class="btn btn-info btn-lg custom" aria-label="Klicke hier um ein Salat auszuwählen" onclick="salat()"><i class='fas fa-seedling'></i> Salat </button>
					
					</div>
					</div>
					</div>
			</div>
			</div>
					
				<div class="row zweite-reihe">
				<div class="col">
				
				<h6>Benutzername</h6>
				<form>
				<div class="input-group">
				
					<input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Bitte Kürzel eingeben" id="validationDefault01" value="" required>
					<div class="input-group-append">
					
						<select class="custom-select" id="Pausenzeit">
						<option selected>Mittagspausezeiten</option>
						<option value="0" >12:30</option>
						<option value="1" >13:00</option>
						</select>
					</div>
					
				</div>
				<small id="passwordHelpBlock" class="form-text text-muted">
				Ein Kürzel besteht aus der ersten Buchstabe des Vornamens und zwei Buchstaben des Nachnamens. Beispielname: Max Mustermann - mmu
				</small>
				<div class="text-center">
				<button class="btn btn-primary" type="button" aria-label="Klicke hier um deine Bestellung zu bestätigen" onclick="send()">Auswahl bestätigen</button>
				</div>
					</form>
					</div>
					</div>
					</div>
						
						
	</main>			
	</body>
	<script src="asset/js/jquery-3.4.1.slim.min.js"></script> <!-- Implementiert javascript Dateien -->
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/fontawesome.js"></script>
<script>
state = 0;
state2 = 0;

function veg(){
	state = "vegetarisch"; 
	document.getElementById("fleisch").style.backgroundColor = "#d64843"
	document.getElementById("veg").style.backgroundColor = "#1f471f"
}

function fleisch(){
	state = "fleisch";
	document.getElementById("veg").style.backgroundColor = "#4eb14e"
	document.getElementById("fleisch").style.backgroundColor =  "#7d1f1c"
}

function salat(){
	if (state2 < 1) {
		state2++; 
		document.getElementById("salat").style.backgroundColor =  "#114555"
	} else {state2--; 
		document.getElementById("salat").style.backgroundColor =  null
	}
}

function send(){
	if(state2 == 1){
		state2 = "ja"; 
	}else{state2 = "nein";}
	var kürzel = document.getElementById("validationDefault01").value;
	var t = document.getElementById("Pausenzeit");
	var uhrzeit = t.options[t.selectedIndex].innerHTML;
	window.location = "index.php?state=" + state + "&state2=" + state2 + "&kürzel=" + kürzel + "&zeit=" + uhrzeit;   
}

</script>	
</html>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bestellung";

$conn = new mysqli($servername, $username, $password, $dbname);
$result1 = $conn->prepare("INSERT INTO bestellung (kürzel,bestellung,salat,datum,uhrzeit) VALUES (?, ?, ?, ?, ?)");
$result1->bind_param("sssss", $kürzel, $state, $state2,$date1,$uhrzeit);

$result2 = $conn->prepare("UPDATE bestellung SET bestellung=?, salat=?, datum=?, uhrzeit=? WHERE kürzel =?");
$result2->bind_param("sssss", $state, $state2, $date1, $uhrzeit, $kürzel);

if(isset($_GET['status'])) {
	if ($_GET['status'] == 1){
		echo '<script>document.getElementById("status").innerHTML = "Bestellung geändert";</script>';
		echo '<script> setTimeout(function() {document.getElementById("status").innerHTML = "Hauptgerichte";},2500)</script>';
	}

	if ($_GET['status'] == 2){
		echo '<script>document.getElementById("status").innerHTML = "Unbekanntes Kürzel";</script>';
		echo '<script> setTimeout(function() {document.getElementById("status").innerHTML = "Hauptgerichte";},2500)</script>';
	}

	if ($_GET['status'] == 3){
		echo '<script>document.getElementById("status").innerHTML = "Danke für die Bestellung";</script>';
		echo '<script> setTimeout(function() {document.getElementById("status").innerHTML = "Hauptgerichte";},2500)</script>';
	}

	if ($_GET['status'] == 4){
		echo '<script>document.getElementById("status").innerHTML = "Essen kann nur vor 10 Uhr bestellt werden";</script>';
		echo '<script> setTimeout(function() {document.getElementById("status").innerHTML = "Hauptgerichte";},2500)</script>';
	}
}

$t1 = date('H');

if(isset($_GET['state'])) {
	$result3 = $conn->query("SELECT * FROM bestellung WHERE datum='" . date("d.m.y") . "';");
	$csv = array();
	
	$kürzel = $_GET['kürzel'];
	$uhrzeit = $_GET['zeit'];
	$state = $_GET['state'];
	$state2 = $_GET['state2'];
	$date1 = date("d.m.y");
	
	$csvUsers = array_map('str_getcsv', file('users.csv'));
	
	if($kürzel == "koch"){echo '<script type="text/javascript"> window.location = "auswertung.php"</script>';}
	if($kürzel == "root"){echo '<script type="text/javascript"> window.location = "admin.php?send=1"</script>';}
	if($kürzel == "monat"){echo '<script type="text/javascript"> window.location = "month.php"</script>';}
	
	if($t1 < 10){
		if(in_array($kürzel, $csvUsers[0])){
			while($row = (array) mysqli_fetch_array($result3))
			{
				array_push($csv, $row);	
			}
			$result = $conn->query("SELECT COUNT(*) FROM bestellung WHERE datum='" . date("d.m.y") . "' AND kürzel= '". $kürzel . "';");
			$i10 = mysqli_fetch_array($result);
			
			if($i10[0] == 0){
				$result1->execute();  // insert 
				echo '<script type="text/javascript"> window.location = "index.php?status=3"</script>';
			}elseif($i10[0] == 1){
				
				$result2->execute(); // update
				
				echo '<script type="text/javascript"> window.location = "index.php?status=1"</script>';
			}	
		}else{
			echo '<script type="text/javascript"> window.location = "index.php?status=2"</script>';
		}   
	}else{echo '<script type="text/javascript"> window.location = "index.php?status=4"</script>';}	
}
?>
