<?php
error_reporting(0);

require_once('TCPDF-master/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('rki bbw');
$pdf->SetTitle(date("d.m.j"));
$pdf->SetSubject('Bestelliste');

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// set default header data
$pdf->SetHeaderData('logo.png', PDF_HEADER_LOGO_WIDTH, 'Auswertung', "Warschauerstraße");

$pdf->AddPage();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bestellung";

$conn = new mysqli($servername, $username, $password, $dbname);
$result = $conn->query("SELECT * FROM bestellung WHERE datum='" . date("d.m.y") . "';");
$rows = array();

$html = "";

$monat = date("m");
$jahr = date("Y");
if($monat < 10){
$monat = (string)$monat;
$monat = intval($monat[1]) -1;	
}else{
$monat = $monat -1;	
}

$salat = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE salat='ja' AND MONTH(datum)= " . $monat . " ;"))[0];
$fleisch = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE bestellung='fleisch' AND MONTH(datum)= " . $monat . " ;"))[0];
$veg = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE bestellung='vegetarisch' AND MONTH(datum)= " . $monat . " ;"))[0];
$gesamt = $veg + $fleisch;

$html = "<html><head></head><body><h1>Essensauswertung vom " . date("m") . "." . $jahr . "</h1> <br><br> <p>Vollkost: ". $fleisch ."  </p>  <p>Vegetarisch: ". $veg ."  </p>  <p>Beilage Salat: ". $salat ."  </p><hr> <p>Gesamtanzahl: ". $gesamt ."  </p> </body></html>";

 
ob_end_clean();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('essensListe.pdf', 'I');

?>