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
        <center><h3>LOGO HERE</h3></center>
        <center><i>Authorization No: 0667MINSANTE/SG/DPML/SDLTS/SL/BNLALAM<br/>
E-mail: ghslltd.lab@gmail.com | Phone: +237 696 124 683/ 675 148 894</i></center>
    </header>
    <footer>
         <hr/><div class="footer-left">
                <!-- Page <span class="page-num"></span> of <span class="page-count"></span> -->
            </div>
        <!-- <strong style="width:100%">{PAGE_NUM} | {PAGE_COUNT} Page</strong> -->
       <center>
       <br/>
        {!! $footerContent !!}
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
    
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>TESTER:</b></p></td>
        
            <!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>VALIDATOR:</b></p></td> -->
        </tr>

    

    </table>


    </main>
    <script type="text/php">
        if ( isset($pdf) ) { 
            $pdf->page_script('
                if ($PAGE_COUNT >= 1) {
                    $size = 10;
                    $pageText = $PAGE_NUM . " | " . $PAGE_COUNT. " Page";

                    $font = $fontMetrics->get_font("serif", "bold");
                    $y = 790;  // Position at the bottom
                    $x = 35;  // Position on the right
                    $pdf->text($x, $y, $pageText, $font, $size);
                } 
            ');
        }
    </script>

</body>

</html>
