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
            margin-bottom:100px; 
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
            height: 50px;
            /* text-align: center; */
            font-size: 12px;
        }
        .content {
            margin: 20px 0;
            margin-top: 0px; 
            
            /* background:red; */
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

        body {
            /* change margin top if the header is more */
            margin-top: 230px; /* This is the value that finally helped me */
        }
    </style>
</head>
<body>
    <header>
        <!-- Header content here -->
        <center>
            <?php
            
                //remote files disturb to load . let me load the base64 server side and send 
                $path = public_path('/toplogo.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>

        <img src="{{$base64}}" height="70"/>
        <br/>
        <br/>
        </center>
        <center><i>Authorization No: 0667 MINSANTE/SG/DPML/SDLTS/SL/BNLALAM<br/>
E-mail: ghslltd.lab@gmail.com | Phone: +237 696 124 683/ 675 148 894</i></center>

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
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date of result delivery: {{formatDate($specimen['enteredat']??now()->toDateTimeString())}}</p></td>
        </tr>

        <tr style="margin:0;padding:0">
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px" class="highlight">Age: {{calculateAge($specimen['patient']['dob'])}}</p></td>
            <!-- <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px"></p></td> -->
            <td style="width:50%;padding:0!important;margin:0!important;"><p style="margin:3px">Date of specimen collection: {{formatDate(($specimen['receptiondate']??"")." ".($specimen['receptiontime']??""))}}</p></td>

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
    <br/>
    <table class="table">
            <tr>
                <th colspan="4" style="text-align:start">GENERAL INFORMATION</th>
            </tr>
            <tr>
                <td>Specimen type</td>
                <td colspan="3" class="field"> {{ $specimen['specimen']['name']}}</td>
            </tr>
            <tr>
                <td>Place of collection</td>
                <td colspan="3" class="field">{{ $specimen['placeofcollection']??""}}</td>
            </tr>
            <tr>
                <td>Time of collection</td>
                <td colspan="3" class="field">{{formatDate(($specimen['receptiondate']??"")." ".($specimen['receptiontime']??""))}}</td>
            </tr>
            <tr>
                <td>Time of testing</td>
                <td  colspan="3" class="field">{{formatDate(($specimen['testingdate']??"")." ".($specimen['testingtime']??""))}}</td>
            </tr>
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
                <th colspan="4" class="highlight">{{strtoupper($labsection)}}</th>
            </tr>
            <?php

                    $setOfResults = [$specimen];
                    $tableData =[];
                    $total_rows=0;
                    foreach($setOfResults as $resultSet){
                        $rsData=[];
                        
                        $rs_total_rows=0;
                        foreach( $resultSet['meta']['results'] as $result){
                            $subRows=0;
                             if(isset($result['subs']) && count($result['subs'])>0){
                                $rs_total_rows+=count($result['subs'])+2;
                                $total_rows+=count($result['subs'])+2;

                                $rsData[]=[
                                    "contents"=>[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>2,
                                            "text"=>"<center><b>".strtoupper($result['name'])."</b></center>"
                                        ],
                                    ]
                                ];

                                foreach($result['subs'] as $subresult){
                                    $rsData[]=[
                                        "contents"=>[
                                            [
                                                "rowspan"=>1,
                                                "colspan"=>1,
                                                "text"=>"<b>".$subresult['name']."</b> ".$subresult['value'].''
                                            ],
                                            [
                                                "rowspan"=>1,
                                                "colspan"=>1,
                                                "text"=>(isset($subresult['maxValue'])&&isset($subresult['minValue']))? ($subresult['minValue']. " - ".$subresult['maxValue']." ".($subresult['unit']??'')):($subresult['unit']??'')
                                            ],
                                        ]
                                    ];
                                }


                                $rsData[]=[
                                    "contents"=>[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>2,
                                            "text"=>"<center><b>&nbsp;</b></center>"
                                        ],
                                    ]
                                ];

                            }else{
                                $rs_total_rows+=1;
                                $total_rows+=1;
                                $rsData[]=[
                                    "contents"=>[
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>1,
                                            "text"=>"<b>".$result['name']."</b> ".$result['value'],  
                                        ],
                                        [
                                            "rowspan"=>1,
                                            "colspan"=>1,
                                            "text"=> (isset($result['maxValue'])&&isset($result['minValue']))? ($result['minValue']. " - ".$result['maxValue']." ".($result['unit']??'')):($result['unit']??'')
                                        ],
                                    ]
                                ];
                            }                     
                        }
                  
                        $firstRowContent = $rsData[0]["contents"];
                        $rsData[0]["contents"]=array_merge([[
                            "text"=>$resultSet['test']['name'],
                            "rowspan"=>$rs_total_rows,
                            "colspan"=>1,
                        ]],$firstRowContent); 


                        $currentTableDataIndex=count($tableData);


                        $tableData = array_merge($tableData,$rsData); 

               
                        $firstRowContent = $tableData[$currentTableDataIndex]["contents"];
                        $tableData[$currentTableDataIndex]["contents"]=array_merge([[
                            "toplevel"=>true,
                            "rowspan"=>$total_rows,
                            "colspan"=>1,
                            "text"=>$resultSet['technique']??""]],$firstRowContent); 
                        $tableData[$currentTableDataIndex]["toplevel"]=true;
                    }

               

                    // dd($tableData);
            ?>
            <tr>
                <td></td>
                <td>TESTS</td>
                <td>RESULTS</td>
                <td>REFERENCE RANGE</td>
            </tr>
            @foreach($tableData as $d)
                <tr>

                    @foreach ($d['contents'] as $content)

                            <td   
                            
                            @if($content['toplevel']??false)
                                style="font-style: italic;" class="highlight"
                            @endif 


                            rowspan="{{$content['rowspan']??1}}"
                            colspan="{{$content['colspan']??1}}"

                             
                             
                             
                             > {!! $content['text'] !!} </td>
                    
                    @endforeach
                 
                
                </tr>
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
