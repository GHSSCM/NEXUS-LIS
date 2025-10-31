<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <style>
        @page {
            margin-left: 50px;
            margin-right: 50px;
            margin-top:00px;  
            margin-bottom:10px; 
            font-size: 10pt;
        }
        header {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            /* background:blue; */
            /* height: 50px; */
            /* height:1000px; */
            /* text-align: center; */
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 80px;
            /* text-align: center; */
            font-size: 12px;
        }
        .content {
            margin: 20px 0;
            margin-top: 0px; 
            margin-right: 0px;
            
            /* background:red; */
        }
        .table {
            width: 100%;
            /* border-collapse:collapse; */
            border-spacing: 0px;
            /* margin-right:105px; */
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 8px;
            
        }
        .table th {
            background-color: #cccccc;
        }
        .highlight {
            /* background-color: #ffff00; */
        }
        .field {
            /* background-color: #00ff00; */
        }

        .container {
            display: flex;
            justify-content: space-between;
        }
        .left-column {
            width: 50%;
        }
        .right-column {
            width: 50%;
            text-align: right;
        }
        p.highlight {
            font-weight: bold;
        }

        body {
            /* change margin top if the header is more */
            margin-top: 230px; /* This is the value that finally helped me */
            margin-bottom: 0px; 
        }
        body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 8pt;
}

        .page-break-before{
            /* page-break-before: always; */
        }
        .page-break {
            page-break-before: always;
        }
/*  
        table{
            page-break-inside: avoid;
        }
        tr{
            page-break-inside: avoid;
            page-break-after:auto;
        }
        td,th{
            page-break-inside: avoid;
        }  */
    </style>
</head>
<body>
    <header>
<h1>asdasdasdfdgdfgfdgfdg</h1>
<br><hr>
<table style="width: 100%; border-collapse: collapse;">
<tbody>
<tr style="margin: 0; padding: 0;">
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p class="highlight" style="margin: 3px;">NAME: Demo</p>
</td>
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p class="highlight" style="margin: 3px;">PATIENT NUMBER/CODE: 01</p>
</td>
</tr>
<tr style="margin: 0; padding: 0;">
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p class="highlight" style="margin: 3px;">Sex: Male</p>
</td>
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p style="margin: 3px;">Date of issue: 11/12/2024 14:59</p>
</td>
</tr>
<tr style="margin: 0; padding: 0;">
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p class="highlight" style="margin: 3px;">Age: 24 years</p>
</td>
<!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"></p></td> -->
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p style="margin: 3px;">Date of specimen reception: 11/12/2024</p>
</td>
</tr>
</tbody>
</table>
</header>

<hr><footer><hr>
<div class="footer-left"><!-- Page <span class="page-num"></span> of <span class="page-count"></span> --></div>
<!-- <strong style="width:100%">{PAGE_NUM} | {PAGE_COUNT} Page</strong> --><center><br>
<p>asdadasd</p>
</center></footer><main class="content"><!-- <div style="height: 450px;">

    </div> --><center>
<h2><u>LABORATORY TESTS REPORTS</u></h2>
</center>
<table class="table">
<tbody>
<tr>
<th style="text-align: start;" colspan="4">GENERAL INFORMATION</th>
</tr>
<tr>
<td>Specimen type</td>
<td class="field" colspan="3">Semen</td>
</tr>
<tr>
<td>Place of collection</td>
<td class="field" colspan="3">&nbsp;</td>
</tr>
<tr>
<td>Time of reception</td>
<td class="field" colspan="3">11/12/2024</td>
</tr>
<tr>
<td>Date of collection</td>
<td class="field" colspan="3">11/12/2024</td>
</tr>
<tr>
<th class="highlight" colspan="4">&nbsp;</th>
</tr>
<tr>
<td>&nbsp;</td>
<td>TESTS</td>
<td>RESULTS</td>
<td>REFERENCE RANGE</td>
</tr>
<tr>
<td class="highlight" style="font-style: italic;" colspan="1" rowspan="14">&nbsp;</td>
<td colspan="1" rowspan="14">Semen Analysis</td>
<td colspan="2" rowspan="1"><center><strong>SEMEN</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Volume</strong> <span>1.3</span></td>
<td colspan="1" rowspan="1">(1.5 - 5.0) mL</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Colour</strong> <span>Ctream White</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="1" rowspan="1"><strong>Viscosity</strong> <span>2</span></td>
<td colspan="1" rowspan="1">≤2cm after 1hour</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Liquefaction</strong> <span>Complete</span></td>
<td colspan="1" rowspan="1">Complete within 30 minutes</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>pH</strong> <span>8</span></td>
<td colspan="1" rowspan="1">&gt;7.2</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Agglutination</strong> <span>Absent</span></td>
<td colspan="1" rowspan="1">None</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>WBC Count</strong> <span>0</span></td>
<td colspan="1" rowspan="1">&lt; 1 x 10^6 cells/mL</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>&nbsp;</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>SPERM</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Total Motility</strong> <span>90</span></td>
<td colspan="1" rowspan="1">&gt;40 %</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Progressive Motility</strong> <span>89</span></td>
<td colspan="1" rowspan="1">&gt;32 %</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Viability</strong> <span>67</span></td>
<td colspan="1" rowspan="1">≥58 %</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Sperm Concentration</strong> <span>45</span></td>
<td colspan="1" rowspan="1">≥ 15 x 10^6 spermatozoa/mL</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
</tbody>
</table>
<div class="page-break">&nbsp;</div>
<table class="table">
<tbody>
<tr>
<td>&nbsp;</td>
<td>TESTS</td>
<td>RESULTS</td>
<td>REFERENCE RANGE</td>
</tr>
<tr>
<td class="highlight" style="font-style: italic;" colspan="1" rowspan="14">&nbsp;</td>
<td colspan="1" rowspan="14">Semen Analysis</td>
<td colspan="1" rowspan="1"><strong>Total Spermatozoa in Ejaculate (Count)</strong> <span>91</span></td>
<td colspan="1" rowspan="1">≥ 39 x 10^6 spermatozoa</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>&nbsp;</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>MORPHOLOGY</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Normal Sperm Cells</strong> <span>90</span></td>
<td colspan="1" rowspan="1">&gt;4 %</td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>&nbsp;</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>HEAD DEFECTS</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>No Head</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="1" rowspan="1"><strong>Large Head</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="1" rowspan="1"><strong>Small Head</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>&nbsp;</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>Middle Piece Defects</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="2" rowspan="1"><center><strong>TAIL DEFECTS</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>No Tail</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="1" rowspan="1"><strong>Coiled Tail</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
</tbody>
</table>
<div class="page-break">&nbsp;</div>
<table class="table">
<tbody>
<tr>
<td>&nbsp;</td>
<td>TESTS</td>
<td>RESULTS</td>
<td>REFERENCE RANGE</td>
</tr>
<tr>
<td class="highlight" style="font-style: italic;" colspan="1" rowspan="2">&nbsp;</td>
<td colspan="1" rowspan="2">Semen Analysis</td>
<td colspan="2" rowspan="1"><center><strong>&nbsp;</strong></center></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column --></tr>
<tr>
<td colspan="1" rowspan="1"><strong>CONCLUSION</strong> <span>0</span></td>
<!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
<td>&nbsp;</td>
</tr>
</tbody>
</table>
<br><br>
<table style="width: 100%; border-collapse: collapse;">
<tbody>
<tr style="margin: 0; padding: 0;">
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p style="margin: 3px;"><strong>TESTER:</strong></p>
</td>
<td style="width: 50%; padding: 0!important; margin: 0!important;">
<p style="margin: 3px;"><strong>VALIDATOR:</strong></p>
</td>
</tr>
</tbody>
</table>
</main>
    <script type="text/php">
    if ( isset($pdf) ) { 
        $pdf->page_script('
            if ($PAGE_COUNT >= 1) {
                $size = 10;

                // Text content
                $pageText = "Page " . $PAGE_NUM . " | " . $PAGE_COUNT;
                $headerText = "";//"QUALITY DIAGNOSTIC, QUALITY CARE";
                //$footerTextDouala = "Akwa at the Rue Prince des Galles, about 100m to Immeuble Activa, Douala, Littoral Region, Republic of Cameroon";
                $footerText = "Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon";

                // Load fonts
                $fontRegular = $fontMetrics->get_font("serif", "normal");
                $fontItalic = $fontMetrics->get_font("serif", "italic");

                // Get page width
                $pageWidth = $pdf->get_width();

                // Position for page number (bottom-left corner)
                $yPage = 790;  // Adjust as needed
                $xPage = 35;   // Left-aligned
                $pdf->text($xPage, $yPage, $pageText, $fontRegular, $size);

                // Position and styling for centered header text
                $headerWidth = $fontMetrics->get_text_width($headerText, $fontItalic, $size);
                $xHeader = ($pageWidth - $headerWidth) / 2; // Center alignment
                $yHeader = $yPage; // Same Y position as page text
                $pdf->text($xHeader, $yHeader, $headerText, $fontItalic, $size);

                // Position and styling for footer text (centered, below header)
                $footerWidth = $fontMetrics->get_text_width($footerText, $fontItalic, $size);
                $xFooter = ($pageWidth - $footerWidth) / 2; // Center alignment
                $yFooter = $yHeader + 12; // Below header text
                $pdf->text($xFooter, $yFooter, $footerText, $fontItalic, $size);
            } 
        ');
    }
</script>

   




</body></html>