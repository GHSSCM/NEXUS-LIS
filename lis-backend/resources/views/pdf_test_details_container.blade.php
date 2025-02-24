<!DOCTYPE html>
<html lang="en">
<head>
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
    {!! $html !!}
    <script type="text/php">
    if ( isset($pdf) ) { 
        $pdf->page_script('
            if ($PAGE_COUNT >= 1) {
                $size = 10;

                // Text content
                $pageText = "Page " . $PAGE_NUM . " | " . $PAGE_COUNT;
                $headerText = "QUALITY DIAGNOSTIC, QUALITY CARE";
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

   

</body>

</html>
