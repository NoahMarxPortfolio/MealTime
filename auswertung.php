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
$pdf->SetHeaderData('logo.png', PDF_HEADER_LOGO_WIDTH, 'Essensbestellung', "Warschauerstraße");

$pdf->AddPage();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bestellung";

$conn = new mysqli($servername, $username, $password, $dbname);
$result = $conn->query("SELECT * FROM bestellung WHERE datum='" . date("d.m.y") . "';");
$rows = array();

$html = "";


while($row = (array) mysqli_fetch_array($result)){
	array_push($rows, $row);	
}

function time_compare($a, $b)
{
	$r = 0;
    $t1 = $a['uhrzeit'];
    $t2 = $b['uhrzeit'];
	if($t1 == $t2 ){
	$r = 0;
	}
    if($t1 < $t2 ){
	$r = 1;
	}
	if($t1 > $t2 ){
	$r = -1;
	}
	
	return $r;
}    

usort($rows, 'time_compare');

$salat = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE salat='ja' AND datum='" . date("d.m.y") . "';"))[0];
$fleisch = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE bestellung='fleisch' AND datum='" . date("d.m.y") . "';"))[0];
$veg = mysqli_fetch_array($conn->query("SELECT COUNT(*) FROM bestellung WHERE bestellung='vegetarisch' AND datum='" . date("d.m.y") . "';"))[0];
$gesamt = $veg + $fleisch;

$html = $html . '<html><head><style>
table {
  border-collapse: collapse;
}

td, th {
  border: 1px solid #999;
  padding: 0.5rem;
  text-align: left;
}
</style></head><body><p>Fleisch: ' . $fleisch . ' </p><br><p>Vegetarisch: ' . $veg . ' </p><br><p>Salat: ' . $salat . ' </p><br><p>Gesamt: ' . $gesamt . ' </p><br>';


$html = $html . '<table><tr><td style="background-color:#CEDDEC">Essen</td>
				 <td style="background-color:#CEDDEC">Salat</td>
				 <td style="background-color:#CEDDEC">Datum</td>
				 <td style="background-color:#CEDDEC">Uhrzeit</td>
				 <td style="background-color:#CEDDEC">Kürzel</td></tr>';

for($i = 0; $i < count($rows); $i++){
	$html = $html . '<tr>';
	for($i1 = 0; $i1 < 5 ; $i1++){
		$html = $html . '<td>' . $rows[$i][$i1] . '</td>';
	}
	$html = $html . '</tr>';
}
$html = $html . '</table></body></html>';
#echo $html;

ob_end_clean();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('essensListe.pdf', 'I');

?>
