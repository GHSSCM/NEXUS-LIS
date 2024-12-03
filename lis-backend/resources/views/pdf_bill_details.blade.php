<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <style>
        @page {
            margin: 100px 50px;
            font-size: 10pt;
        }
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            /* text-align: center; */
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            /* text-align: center; */
            font-size: 12px;
        }
        .content {
            margin: 20px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
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

    </style>
</head>
<body>
    <header>
        <!-- Header content here -->
        <!-- Header content here -->
        <center>
            <?php
            
                //remote files disturb to load . let me load the base64 server side and send 
                $path = public_path('/toplogonew2.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>

        <img src="{{$base64}}" height="100"/>
<br/>
<br/>


    </header>
    <footer>
         <hr/><div class="footer-left">
                <!-- Page <span class="page-num"></span> of <span class="page-count"></span> -->
            </div>
        <!-- <strong style="width:100%">{PAGE_NUM} | {PAGE_COUNT} Page</strong> -->
       <center>
       <br/>
        {{-- $footerContent --}}
       </center>
    </footer>
    <main class="content">
        


    <br/>    <br/>
    <hr/>

    <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
      
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">NAME: {{$bill['patient']['name']}}</p></td>
 

            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date: {{formatDate($bill['created_at']??"")}}</p></td>
        </tr>


    </table>


    <hr/>
    <br/>
    <center><h2><u>BILL REPORT</u></h2></center>
    <br/>
    <?php $total=0;?>
    <table class="table">
            
        <tr>
            <th colspan="1" style="text-align:start">TEST</th>
            <th colspan="1" style="text-align:start">SPECIMEN</th>
            <th colspan="1" style="text-align:start">BASE AMOUNT</th>
            <th colspan="1" style="text-align:start">DISCOUNT</th>
            <th colspan="1" style="text-align:start">TOTAL</th>
        </tr>
            
        @foreach ($bill['meta']['specimens'] as $specimenBillingData )
        <tr>
            <td>
                {{$specimenBillingData['test']}}
            </td>
            <td>
                {{$specimenBillingData['specimen']}}
            </td>
            <td>
                {{$specimenBillingData['amount']}}
            </td>
            <?php
                $discounttype = $specimenBillingData['discounttype']??"NONE";
                $finalAmount=$specimenBillingData['amount'];
                switch($discounttype){
                    case "NONE":$finalAmount=$specimenBillingData['amount'];break;
                    case "PERC":$finalAmount=$specimenBillingData['amount']-($specimenBillingData['amount']*(($specimenBillingData['discountamount']??0)/100));break;
                    case "FLAT":$finalAmount=$specimenBillingData['amount'] - ($specimenBillingData['discountamount']??0) ;break;
                }
                $total+=$finalAmount;
            ?>
            <td>
                @if($discounttype=='NONE')
                    NONE
                @elseif($discounttype=='PERC')
                    {{$specimenBillingData['discountamount']??0}}%
                @else
                    {{$specimenBillingData['discountamount']??0}} {{$bill['meta']['currency']}}
                @endif
            </td>
                 
            <td>
            {{$finalAmount}} {{$bill['meta']['currency']}}
            </td>
        </tr>
        @endforeach
            <tr>
                <td colspan="4"> <strong>TOTAL</strong></td>
                <td><strong>{{$total}} {{$bill['meta']['currency']}}</strong></td>
            </tr>
           
        </table>

        <br/>
        <br/>


        <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
    
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>FINANCE:</b></p></td>
        
            <!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>VALIDATOR:</b></p></td> -->
        </tr>

    

    </table>


    </main>
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
