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
    <header>
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
        {{--<br/>
        <br/>
        </center>
        <center><i>Authorization No: 0667 MINSANTE/SG/DPML/SDLTS/SL/BNLALAM<br/>
E-mail: ghslltd.lab@gmail.com | Phone: +237 696 124 683/ 675 148 894</i></center>--}}

<br/>    
    <hr/>

    <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
        @if(empty($specimen['test']['hidename']))
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">NAME: {{$specimen['patient']['name']}}</p></td>
        @endif

        <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">PATIENT NUMBER/CODE: {{$specimen['patient']['reference']??""}}</p></td>

        </tr>

        <tr style="margin:0;padding:0">
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">Sex: {{$specimen['patient']['gender']=='M'?"Male":"Female"}}</p></td>
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date of issue: {{formatDate($specimen['enteredat']??now()->toDateTimeString())}}</p></td>
        </tr>

        <tr style="margin:0;padding:0">
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">Age: {{calculateAge($specimen['patient']['dob'])}}</p></td>
            <!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"></p></td> -->
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date of specimen reception: {{formatDate(($specimen['receptiondate']??"")." ".($specimen['receptiontime']??""))}}</p></td>

        </tr>

    </table>


    <hr/>
    <br/>
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
        


   

    

    <!-- <div style="height: 450px;">

    </div> -->
    <center><h2><u>LABORATORY TESTS REPORT</u></h2></center>



    <table class="table">
            <?php

                $hasColumnForReference=false;
                   
                    $setOfResults =$specimens;
                    $tableData =[];
                    $total_rows=0;
                    $counter=-1;
                    foreach($setOfResults as $resultSet){
                        $counter++;
                        $rsData=[];
                        
                        $rs_total_rows=0;
                        foreach( $resultSet['meta']['results'] as $result){
                            $subRows=0;
                            // if( isset($result['noop'])){
                            //     $rsData[]=[
                            //         "contents"=>[
                            //             [
                            //                 "rowspan"=>1,
                            //                 "colspan"=>2,
                            //                 "dependsOnLastColumn"=>true,
                            //                 "text"=>"<center><b>".strtoupper($result['name'])."</b></center>"
                            //             ],
                            //         ]
                            //     ];
                            // }
                            //  else
                              if(isset($result['subs']) && count($result['subs'])>0){
                                $rs_total_rows+=count($result['subs'])+2;
                                $total_rows+=count($result['subs'])+2;

                                $rsData[]=[
                                    "contents"=>[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>2,
                                            "dependsOnLastColumn"=>true,
                                            "text"=>"<center><b>".strtoupper($result['name']??'')."</b></center>"
                                        ],
                                    ]
                                ];


                                foreach($result['subs'] as $subresult){

                                 
                                    $isRed=(isset($subresult['maxValue'])&&isset($subresult['minValue']))?($subresult['maxValue']<$subresult['value']||$subresult['minValue']>$subresult['value']):false;
                                    
                            
                                    $tempData00XY=[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>1,
                                            "text"=>"<b  style='".($isRed?'color:red!important':'')."'>".($subresult['name']??'')."</b> <span style='".($isRed?'color:red!important':'')."'>".($subresult['value']??  (!empty($subresult['values'])?implode(", ",$subresult['values']):"")  ).'</span>'
                                        ]
                                    ];


                                    // YOU CAN BLOCK HERE
                                    if(!empty($subresult['guide'])||!empty($subresult['unit'])){

                                        $hasColumnForReference=true;
                                        $tempData00XY[]=[
                                            'isRef'=>true,
                                            "rowspan"=>1,
                                            "colspan"=>1,
                                            "text"=>(isset($subresult['maxValue'])&&isset($subresult['minValue']))? ("<span style='".($isRed?'color:red':'')."'>".(!empty($subresult['comparison'])?($subresult['comparisonvalue']." ".$subresult['comparisonoperand']):($subresult['minValue']. " - ".$subresult['maxValue'])." ".($subresult['unit']??'')). ($isRed?' * ':' ')."</span>"):($subresult['unit']??'')
                                        ];
                                    }


                                    $rsData[]=[
                                        "contents"=>$tempData00XY
                                    ];
                                }


                                $rsData[]=[
                                    "contents"=>[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>2,
                                            "dependsOnLastColumn"=>true,
                                            "text"=>"<center><b>&nbsp;</b></center>"
                                        ],
                                    ]
                                ];

                            }else{
                                $rs_total_rows+=1;

                                $total_rows+=1;
                                $isRed=(isset($result['maxValue'])&&isset($result['minValue']))?($result['maxValue']<$result['value']||$result['minValue']>$result['value']):false;


                                $tempData00XYZZ=[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>isset($result['noop'])?2:1,
                                            "text"=>"<b style='".($isRed?'color:red':'')."'>".($result['name']??'')."</b> <span style='".($isRed?'color:red':'')."'>".($result['value']?? (!empty($result['values'])?implode(", ",$result['values']):"") )."</span>",  
                                        ]
                                ];


                                //  YOU CAN BLOCK HERE
                                 if(!empty($result['guide'])||!empty($result['unit'])){
                                    
                                    $hasColumnForReference=true;
                                    $tempData00XYZZ[]= [
                                            'isRef'=>true,
                                            "rowspan"=>1,
                                            "colspan"=>1,
                                            "text"=> (isset($result['maxValue'])&&isset($result['minValue']))? ("<span style='".($isRed?'color:red':'')."'>".($result['guide']??$result['unit'])/*." ".($result['units']??'')*/. ($isRed?' * ':' ')."</span>"):($result['unit']??'')
                                        ];
                                }

                                $rsData[]=[
                                    "contents"=>$tempData00XYZZ
                                ];

                                
                            }           

                        }
                  
                        if(!empty($resultSet['clinical'])){
                            $rsData[]=[
                                "contents"=>[
                                    [
                                        "rowspan"=>1,
                                        "colspan"=>4,
                                        "dependsOnLastColumn"=>true,
                                        "text"=>$resultSet['clinical']
                                    ],
                                ]
                            ]; 
                        }
                        

                        $firstRowContent = $rsData[0]["contents"];

                        $rsData[0]["contents"]=array_merge([[
                            "text"=>$resultSet['test']['name']??'',
                            "rowspan"=>$rs_total_rows,
                            "colspan"=>1,
                        ]],$firstRowContent); 


                        
                        $currentTableDataIndex=count($tableData);


                        $tableData = array_merge($tableData,$rsData); 

               
                        $firstRowContent = $tableData[$currentTableDataIndex]["contents"];
                        $tableData[$currentTableDataIndex]["contents"]=array_merge([[
                            "toplevel"=>true,
                            "rowspan"=>$rs_total_rows,
                            "colspan"=>1,
                            "text"=>$resultSet['technique']??""]],$firstRowContent); 

                      
                    }

                    // $firstRowContent = $tableData[$currentTableDataIndex]["contents"];
                    // $tableData[$currentTableDataIndex]["contents"]=array_merge([[
                    //     "toplevel"=>true,
                    //     "rowspan"=>$total_rows,
                    //     "colspan"=>1,
                    //     "text"=>$resultSet['technique']??""]],$firstRowContent); 
                    // $tableData[$currentTableDataIndex]["toplevel"]=true;

                    // if($counter==1){
                    //     dd($tableData);
                    // }
                   
               

                    // dd($tableData);
            ?>


            <tr>
                <th colspan="{{!$hasColumnForReference?3:4}}" style="text-align:start">GENERAL INFORMATION</th>
            </tr>
            <tr>
                <td>Specimen type</td>
                <td colspan="{{!$hasColumnForReference?2:3}}" class="field"> {{ $specimen['specimen']['name']}}</td>
            </tr>
            <tr>
                <td>Place of collection</td>
                <td colspan="{{!$hasColumnForReference?2:3}}" class="field">{{ $specimen['placeofcollection']??""}}</td>
            </tr>
            <tr>
                <td>Time of reception</td>
                <td colspan="{{!$hasColumnForReference?2:3}}" class="field">{{formatDate(($specimen['receptiondate']??"")." ".($specimen['receptiontime']??""))}}</td>
            </tr>
            @if(isset($specimen['collectiondate']))
                <tr>
                    <td>Date of collection</td>
                    <td colspan="{{!$hasColumnForReference?2:3}}" class="field">{{formatDate(($specimen['collectiondate']??"")." ".($specimen['collectiontime']??""))}}</td>
                </tr>
            @endif
            <tr>
                <?php
                
                try{
                    $keys = ['Laboratory Section','lab section','labsection','laboratory section','laboratorysection','Laboratory section','Lab section','Lab Section','lab_section'];
                    $labsection ="";
                    foreach ($keys as $key){
                        $labsection =$specimen['test']['meta']['fields'][$key];
                        if(!empty($labsection)){
                            break;
                        }
                    }
                    if(is_array($labsection)){
                        $labsection = $labsection[0];
                    }

                    
                }catch(Exception $e){
                    
                }
                ?>
                <th colspan="{{$hasColumnForReference?4:3}}" class="highlight">{{strtoupper($labsection)}}</th>
            </tr>
            <tr>
                <td></td>
                <td>TESTS</td>
                <td>RESULTS</td>
                @if($hasColumnForReference)
                    <td>REFERENCE RANGE</td>
                @endif
            </tr>
            

            <?php
                $pageData=[];
                $currentIndex=0;
                $perPage=14;
                $rowPosition=1; $rowColumnsOccuppied=[];//at times, some rows have elements that cross above the accepted number of columns. let me try to do something manual
                //the assoc rowColumnsOccupied, shows the number of columns already consumed by a row such that it should be the max possible (4 or 3 depending on if there is reference or not)
              
              
                // dd($tableData);
                foreach($tableData as $d){
                    foreach($d['contents'] as $content){


                        /*
                         This is the one that checks if the colspan should consider the last column for reference or not
                            
                         The last column of reference is only to show when there is a unit (others) or a reference (numeric).

                         In case the column is there, keep the value i passed on. Else do -1.
                         */
                        if(!empty($content['dependsOnLastColumn'])){
                            $colspan=$content['colspan']?(!$hasColumnForReference?($content['colspan']-1):$content['colspan']):1;
                        }else{
                            $colspan=$content['colspan']??1;
                        }

                        //count here
                        $rpCounter = 0;
                        while($rpCounter<$content['rowspan']??1){ //do not forget that the content can span through multiple rows
                            if(!isset($rowColumnsOccuppied[$rowPosition+$rpCounter])){
                                $rowColumnsOccuppied[$rowPosition+$rpCounter]=0;
                            }
                            $rowColumnsOccuppied[$rowPosition+$rpCounter]+=$content['colspan'];
                            if($rowColumnsOccuppied[$rowPosition+$rpCounter]>($hasColumnForReference?4:3)){
                                $content['colspan'] = ($content['colspan'] -1);//let me just substract one to see
                                $content['colspan'] = $content['colspan']>0?$content['colspan']:1; //make sure the min is 1
                               
                            }
                            $rpCounter++;
                        }
                       
                        $spanData = getRowSpanForPage($currentIndex%$perPage,$content['rowspan'],$perPage, $currentIndex);
                        if($currentIndex==4){
                            // dd($spanData);
                        }
                        $startPage = floor($currentIndex/$perPage) ;
                        $spanDataCounter=0;
                        foreach($spanData as $d){
                            if(!isset($pageData[$spanDataCounter+$startPage])){
                                $pageData[$spanDataCounter+$startPage]=[];
                            }
                            $copiedContent = $content;
                            $copiedContent['rowspan']= $d;
                            if($spanDataCounter==0){
                                // $pageData[$spanDataCounter+$startPage][]= $copiedContent;
                                if(!isset($pageData[$spanDataCounter+$startPage][$currentIndex%$perPage])){
                                    $pageData[$spanDataCounter+$startPage][$currentIndex%$perPage]=[];
                                }

                                $pageData[$spanDataCounter+$startPage][$currentIndex%$perPage][]=$copiedContent;
                                //could not forcefully be on row 1. 
                            }else{
                                // $pageData[$spanDataCounter+$startPage][]= $copiedContent;
                                $pageData[$spanDataCounter+$startPage][0][]=$copiedContent;
                                //has crossed through pages and is on row 1 forcefully
                            }
                            $spanDataCounter++;
                        }
                    }

                    $currentIndex++;
                    $rowPosition++;
                }
                // dd($pageData);
            
            
            ?>
            <?php $c=0; $pageNumber=1; ?>

            @foreach($pageData as $pD)
                    @foreach($pD as $d)
                        <tr >
                          
                            @foreach ($d as $content)
                                   
                                    <td   
                                    
                                    @if($content['toplevel']??false)
                                        style="font-style: italic;" class="highlight"
                                    @endif 


                                    {{-- This is the one that checks if the colspan should consider the last column for reference or not
                                    
                                            The last column of reference is only to show when there is a unit (others) or a reference (numeric).

                                            In case the column is there, keep the value i passed on. Else do -1.
                                
                                    @if(!empty($content['dependsOnLastColumn']))
                                        colspan="{{$content['colspan']?(!$hasColumnForReference?($content['colspan']-1):$content['colspan']):1}}"
                                    @else
                                        colspan="{{$content['colspan']??1}}"
                                    @endif --}}

                                    colspan="{{$content['colspan']??1}}"

                                    rowspan="{{$content['rowspan']??1}}"

                                    
                                    
                                    
                                    > {!! $content['text'] !!} </td>
                            
                            @endforeach
                          <!-- in case the reference value is not there, but there is a reference column, it is totally left without a cell. i have to cover it. i'll check the last column -->
                           
                            @if($hasColumnForReference&& empty(end($d)['isRef'])&&  (end($d)['colspan']??1)==1)
                                <td></td>
                            @endif
                            
                        
                        </tr>
                    @endforeach

       
                <?php
                    $c++;
                ?>
              @if(isset($pageData[$c]))         
                    </table>
                    <div class="page-break"></div>
                    <table class="table">
                    <tr>
                        <td></td>
                        <td>TESTS</td>
                        <td>RESULTS</td>
                        @if($hasColumnForReference)
                            <td>REFERENCE RANGE</td>
                        @endif
                    </tr>
                @endif 
            @endforeach
           </table>
           
        

        <br/>
        <br/>


        <table style="width: 100%; border-collapse: collapse;" >
        <tr style="margin:0;padding:0">
    
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>TESTER:</b></p></td>
        
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"><b>VALIDATOR:</b></p></td>
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
