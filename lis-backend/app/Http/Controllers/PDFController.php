<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Facility;
// For testing only, to see if you still time out:
ini_set('max_execution_time', 300); // 5 minutes
ini_set('memory_limit', '512M');
    
class PDFController extends Controller
{
    
    public function generatePDF($viewOnly=false)
    {

        $find = \App\Models\ResultSheetExportation::query()->where('registered_specimen',request('id'))->first();
        if($find){
            return  $this->genPDFFromHTML($find->html);
        }

//         $dompdf = new Pdf();
// $html = '<html><body><p>Test: ≥</p></body></html>';
// $dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'portrait');
// $dompdf->render();
// $dompdf->stream();
// return;

        $id= request('id');
        if(empty($id)){
            return abort(404);
        }

    $specimen=\App\Models\RegisteredSpecimen::query()->find($id);

    $specimen->state="Results Printed";
    $specimen->save();
    $specimen=$specimen->toArray();
    $specimen['patient']=\App\Models\Patient::query()->where("uniqid",$specimen['patient'])->first();
    $specimen['specimen']=\App\Models\SpecimenType::query()->where("uniqid",$specimen['specimen'])->first();
    $specimen['test']=\App\Models\TestType::query()->where("uniqid",$specimen['test'])->first();

        $labData=getCurrentLab($specimen['facility_ref']);
        $labMeta = !empty($labData['meta'])?$labData['meta']:[];
        $footerContent = $labMeta['sheetfooter']??'';
        $headerContent = $labMeta['sheetheader']??'';
        $credits = addslashes($labMeta['credits']??'');

        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content

        // '<i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>';
    
        $multiple=request('multiple')?true:false;

        if(!isset($specimen['meta']['results'])){
            $specimen['meta']['results']=[];
        }else{
            $results=$specimen['meta']['results'];
            $specimen['meta']['results']= array_filter($results,function($item){
                return empty($item['ignore']);
            });
        }



        $specimens=[];
        if($multiple && $specimen['groupID']){
            \App\Models\RegisteredSpecimen::query()->where('groupID',$specimen['groupID'])->whereNot("id",$specimen['id'])->update(['state'=>'Results Printed']);
            $others= \App\Models\RegisteredSpecimen::query()->where('groupID',$specimen['groupID'])->whereNot("id",$specimen['id'])->get()->toArray();
           
            $specimens=[$specimen];
            foreach($others as $other){
                $other['patient']=$specimen['patient'];
                $other['specimen']=\App\Models\SpecimenType::query()->where("uniqid",$other['specimen'])->first();
                $other['test']=\App\Models\TestType::query()->where("uniqid",$other['test'])->first();
                if(!isset($other['meta']['results'])){
                    $other['meta']['results']=[];
                }else{
                    $results=$other['meta']['results'];
                    $other['meta']['results']= array_filter($results,function($item){
                        return  empty($item['ignore']);
                    });
                }
                $specimens[]=$other;
            }
        }else{
            $specimens=[$specimen];
        }

     
    

        if(request('preview') || $viewOnly){
           
     
            return view('pdf_test_details_new', compact('specimen', 'specimens','footerContent','headerContent','credits'));
        }



        header('Content-Type: text/html; charset=utf-8');
        // return view('pdf_test_details', compact('specimen', 'specimens','footerContent'));

        

        $pdf = Pdf::loadView('pdf_test_details_new', compact('specimen', 'specimens','footerContent','headerContent','credits'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        $pdf->set_option('isFontSubsettingEnabled', true);

        if(request('dl')){
            return $pdf->download("test-report-".str_replace(" ","-",strtolower($specimen['patient']['name'])).'-'. str_replace(" ","-",strtolower($specimen['specimen']['name'])).'.pdf');
        }
       
        return $pdf->stream('document.pdf');
    }
    //


       public function generatePDFBill()
    {
      
        header('Content-Type: text/html; charset=utf-8');

        $id= request('id');
        if(empty($id)){
            return abort(404);
        }
        

        $bill=\App\Models\Bill::query()->find($id);
        $bill['patient']=Patient::query()->where('uniqid',$bill->patient)->get()->first();

        $labData=getCurrentLab($bill->facility_ref);
        $labMeta = !empty($labData['meta'])?$labData['meta']:[];

        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = $labMeta['sheetfooter']??'';
        $headerContent = $labMeta['sheetheader']??'';
        $credits = addslashes($labMeta['credits']??'');

        // <i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>
        $pdf = Pdf::loadView('pdf_bill_details', compact( 'bill','footerContent','headerContent','credits'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        

        if(request('dl')){
            return $pdf->download('document.pdf');
        }
        return $pdf->stream('document.pdf');
    }


    //THE NEW GENERATE PDF BILL FUNCTION
    public function generateNexusPDFBill()
    {
      
        header('Content-Type: text/html; charset=utf-8');

        $id= request('id');
        if(empty($id)){
            return abort(404);
        }
        

        $bill=\App\Models\NexusBill::query()->where('uniqid',$id)->first();
        if(!$bill){
            return abort(404, 'Bill not found');
        }
        $bill['patient']=Patient::query()->where('uniqid',$bill->patient_ref)->get()->first();

        $labData=getCurrentLab($bill->facility_ref);
        $labMeta = !empty($labData['meta'])?$labData['meta']:[];

        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = $labMeta['sheetfooter']??'';
        $headerContent = $labMeta['sheetheader']??'';
        $credits = addslashes($labMeta['credits']??'');

        $bill['labMeta']=$labMeta;

        // <i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>
        $pdf = Pdf::loadView('NEXUS_pdf_bill_details', compact( 'bill','footerContent','headerContent','credits'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        

        if(request('dl')){
            return $pdf->download('document.pdf');
        }
        return $pdf->stream('document.pdf');
    }


    public function genPDFFromHTML($html)
    {
        error_reporting(E_ALL & ~E_DEPRECATED);
        ini_set('memory_limit', '256M');
        set_time_limit(300);
        $html= replaceImagesWithBase64($html);
        // die('ss');
        header('Content-Type: text/html; charset=utf-8');
        
    
        // die('h');
        if(request('preview')){
            return view('pdf_test_details_container',['html'=>fixTinyMCEHtml($html)])->render();
        }
        $pdf = Pdf::loadView('pdf_test_details_container',['html'=>fixTinyMCEHtml($html)])->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        if(request('dl')){
            return $pdf->download('document.pdf');
        }
        return $pdf->stream('document.pdf');
    }

}
