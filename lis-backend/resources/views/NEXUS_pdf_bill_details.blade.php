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
        <!-- <center> -->
            <!-- <?php
            
                //remote files disturb to load . let me load the base64 server side and send 
                $path = public_path('/toplogonew2.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>

        <img src="{{$base64}}" height="100"/>
<br/>
<br/> -->
        {!! $headerContent !!}

    </header>
    <footer>
         <hr/><div class="footer-left">
                <!-- Page <span class="page-num"></span> of <span class="page-count"></span> -->
            </div>
        <!-- <strong style="width:100%">{PAGE_NUM} | {PAGE_COUNT} Page</strong> -->
       <center>
       <br/>
        <!-- {{-- $footerContent --}}
        {{$footerContent}}
        <h1>a</h1> -->
       </center>
    </footer>
    <main class="content">
        


    <br/>    <br/>
    <hr/>

    <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
      
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">NAME: {{isset($bill['patient']['name'])?$bill['patient']['name']:""}}</p></td>
 

            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date: {{formatDate($bill['created_at']??"")}}</p></td>
        </tr>


        <tr style="margin:0;padding:0">
      
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">BILL No:{{ $bill['id'] }}</p></td>
 

            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"></p></td>
        </tr>


    </table>


    <hr/>
    <br/>
    <center><h2><u>{{$bill['type']!=="PRESCRIPTION"?"BILL DETAILS":"PHARMACY PRESCRIPTION"}}: </u></h2></center>
    <br/>
    <?php $total=0;?>
    <table class="table">
            
        <tr>
            <th colspan="1" style="text-align:start">ITEM</th>
            <th colspan="1" style="text-align:start">
                {{ $bill['type']==="PRESCRIPTION" ? "DETAILS":"QUANTITY" }}
            </th>
            <th colspan="1" style="text-align:start">UNIT PRICE</th>
            <th colspan="1" style="text-align:start">DISCOUNT</th>
            <th colspan="1" style="text-align:start">TOTAL</th>
        </tr>
        <?php
        
        $constituents = \App\Models\NexusBillConstituent::where('nexus_bill_ref', $bill['uniqid'])->get();
        ?>
        @foreach ($constituents as $consty )
        <tr>
            <td>
                <p style="margin-bottom: 0;">{{$consty['name']}}  
                    @if($bill['type']==="PRESCRIPTION" && !empty($consty['quantifiable']))
                        ({{$consty['quantity']??""}}  {{ $consty['consty.quantity_unit']??'' }})
                    @endif 
                </p>

                @if(isset($consty['subname']))
                    <small style="opacity: 0.5">{{$consty['subname']}}</small>
                @endif
            </td>
            <td>
               @if(!$bill['type']==="PRESCRIPTION" && !empty($consty['quantifiable']))
                    {{$consty['quantity']??""}}  {{ $consty['consty.quantity_unit']??'' }}
               @endif 

               @if($bill['type']==="PRESCRIPTION")
                    {{$consty['description']}}
               @endif
           
            </td>
            <td>
                {{$consty['unit_price']??""}}
            </td>
            <?php
                $discounttype = strtoupper( $consty['reduction_rate']??"NONE");
                $finalAmount=($consty['quantity']??1)*($consty['unit_price']??0);
                switch($discounttype){
                    case "NONE":break;
                    case "PERCENTAGE":$finalAmount=$finalAmount-($finalAmount*(($consty['reduction']??0)/100));break;
                    case "FLAT":$finalAmount=$finalAmount - ($consty['reduction']??0) ;break;
                }
                $total+=$finalAmount;
            ?>
            <td>
                @if($discounttype=='NONE')
                    NONE
                @elseif($discounttype=='PERC')
                    {{$consty['reduction']??0}}%
                @else
                    {{$consty['reduction']??0}} {{$bill['labMeta']['currency']??''}}
                @endif
            </td>
                 
            <td>
            {{$finalAmount}} {{$bill['labMeta']['currency']??'XAF'}}
            </td>
        </tr>
        @endforeach
            <tr>
                <td colspan="4"> <strong>TOTAL</strong></td>
                <td><strong>{{$total}} {{$bill['labMeta']['currency']??'XAF'}}</strong></td>
            </tr>
           
        </table>

        <br/>
        <br/>


        <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
    
            <!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>FINANCE:</b></p></td> -->
        
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
                $headerText = "";//"QUALITY DIAGNOSTIC, QUALITY CARE";
                //$footerTextDouala = "Akwa at the Rue Prince des Galles, about 100m to Immeuble Activa, Douala, Littoral Region, Republic of Cameroon";
                $footerText =  "{{$credits}}"; //"Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon";

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
