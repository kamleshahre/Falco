<?php
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require_once ('classes/class.db.php');
require_once 'includes/constants.php';
$db = new MySQL(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME, false);


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Falco System');
$pdf->SetTitle('Llogaria');
$pdf->SetSubject('Llogaria');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE , PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setPrintHeader(false);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
$image = $pdf->Image("tcpdf/images/logo.png", 15, 10, 60, 15, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
$id = $_GET['id'];
if(isset($id)) 
	$result = $db->query("SELECT * FROM orders WHERE order_id=$id;");
else
	$result = $db->query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 1;");
$row = mysql_fetch_array($result);
$emri = $row['name'];			$mbiemri = $row['surname'];
$prej = $row['prej'];			$deri 	 = $row['deri'];
$data = $row['date'];			$cmimi   = $row['cost'];

if (!empty($row['KthyesePrej']) && !empty($row['KthyeseDeri'])) {
	$returned = '
<tr>
	<td><strong>Kthyese</strong></td>
	<td>'.$row['KthyesePrej'].'</td>
	<td>'.$row['KthyeseDeri'].'</td>
</tr>';

}

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>

	h1 {
		color: navy;
		font-family: times;
		font-size: 24pt;
		text-decoration: underline;
	}
	p.first {
		color: #003300;
		font-family: helvetica;
		font-size: 12pt;
	}
	p.first span {
		color: #006600;
		font-style: italic;
	}
	p#second {
		color:#000;
		font-family: helvetica;
		font-size: 8pt;
		text-align: justify;
	}
	p#falemenderim {
		color:#000;
		font-family: times;
		font-size: 12pt;
		text-align: justify;
	}
	
	p#second > span {
		background-color: #FFFFAA;
	}
	table.first {
		color: #003300;
		font-family: helvetica;
		font-size: 8pt;
		background-color: #FFFFFF;
	}
	td {
	border: 1px solid #BFBFBF;	
	background-color: #FFFFFF;
	}
	div.test {
		color: #CC0000;
		background-color: #FFFF66;
		font-family: helvetica;
		font-size: 10pt;
		border-style: solid solid solid solid;
		border-width: 2px 2px 2px 2px;
		border-color: green #FF00FF blue red;
		text-align: center;
	}
	td.Addressa {
		border:1px solid #FFFFFF;
		text-align:right;
	}
	td.logo {
		border:1px solid #FFFFFF;
	}
	.bolder {
		font-weight:bold;
	}
	.hide {
	border-left:3px solid #FFFFFF;
	border-bottom:3px solid #FFFFFF;
	}
	.kuq {
	background-color: red;
	color:#FFFFFF;
	}
</style>

<br/><br/>
<table class="thise" cellpadding="0" cellspacing="0">
<tr>
	<td height="50" class="logo">$image</td>
	<td class="Addressa">
		Falco system<br/>
		123 Rruga<br/>
		Tetove, MKD<br/>
		000 - 000 000<br/>
		email@firma.com
	</td>
</tr>
</table>


<br />

<table class="first" cellpadding="4" cellspacing="0">
<tr class="bolder">
	<td class="kuq">Pasagjeri</td>
	<td class="kuq">Prej</td>
	<td class="kuq">Deri</td>
</tr>
<tr>
	<td>$emri $mbiemri</td>
	<td>$prej</td>
	<td>$deri</td>
</tr>

$returned

</table>

<table cellpadding="4" cellspacing="0" >

<tr>
	<td class="hide" width="345"></td>
	<td class="bolder" width="80">&Ccedil;mimi</td>
	<td >$ $cmimi</td>
</tr>
</table>

<p id="falemenderim">
	Ju falemenderojme qe keni zgjedhur te udhetoni me agjensionin tone, ju deshirojme nje rruge te mbare!
</p>

<p id="second">
- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porta nisl at dui semper ut semper lectus volutpat. 
Integer sollicitudin cursus mi et fermentum. Pellentesque in sem id felis commodo auctor. Nulla fringilla dui ac odio
 iaculis vel posuere eros dignissim. Donec nulla odio, pretium vitae consectetur sit amet, hendrerit interdum mauris.<br/> 
- Proin tincidunt consectetur nisi vel pellentesque. Ut ac felis quis lorem porttitor convallis at in diam. Sed molestie, 
 sem at molestie posuere, nibh justo auctor nunc, eu posuere sem purus eget ipsum. In auctor gravida vulputate. Aenean in<br/> 
- sapien purus, non ornare tortor. Cras nec risus lacus. Integer dictum sodales bibendum. 
</p>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('tiketa.pdf', 'I');


?>