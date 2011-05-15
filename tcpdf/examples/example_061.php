<?php
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2010-08-08
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Shpetim Islami
//
// (c) Copyright:
//               Shpetim Islami
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Shpetim Islami
 * @since 2010-05-25
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Shpetim Islami');
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

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
$image = $pdf->Image("../images/logo.png", 15, 10, 60, 20, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
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
	<td>Shpetim Islami</td>
	<td>Tetove</td>
	<td>Berlin</td>
</tr>
</table>
<table cellpadding="4" cellspacing="0" >

<tr>
	<td class="hide" width="345"></td>
	<td class="bolder" width="80">&Ccedil;mimi</td>
	<td >$ 100.00</td>
</tr>
</table>

<p id="second">
	Ju falemenderojme qe keni zgjedhur te udhetoni me agjensionin tonde, ju deshirojme nje rruge te mbare!
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

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// *******************************************************************
// HTML TIPS & TRICKS
// *******************************************************************

// REMOVE CELL PADDING
//
// $pdf->SetCellPadding(0);
// 
// This is used to remove any additional vertical space inside a 
// single cell of text.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// REMOVE TAG TOP AND BOTTOM MARGINS
//
// $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
// $pdf->setHtmlVSpace($tagvs);
// 
// Since the CSS margin command is not yet implemented on TCPDF, you
// need to set the spacing of block tags using the following method.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// SET LINE HEIGHT
//
// $pdf->setCellHeightRatio(1.25);
// 
// You can use the following method to fine tune the line height
// (the number is a percentage relative to font height).

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// CHANGE THE PIXEL CONVERSION RATIO
//
// $pdf->setImageScale(0.47);
// 
// This is used to adjust the conversion ratio between pixels and 
// document units. Increase the value to get smaller objects.
// Since you are using pixel unit, this method is important to set the
// right zoom factor.
// 
// Suppose that you want to print a web page larger 1024 pixels to 
// fill all the available page width.
// An A4 page is larger 210mm equivalent to 8.268 inches, if you 
// subtract 13mm (0.512") of margins for each side, the remaining 
// space is 184mm (7.244 inches).
// The default resolution for a PDF document is 300 DPI (dots per 
// inch), so you have 7.244 * 300 = 2173.2 dots (this is the maximum 
// number of points you can print at 300 DPI for the given width).
// The conversion ratio is approximatively 1024 / 2173.2 = 0.47 px/dots
// If the web page is larger 1280 pixels, on the same A4 page the 
// conversion ratio to use is 1280 / 2173.2 = 0.59 pixels/dots

// *******************************************************************

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
