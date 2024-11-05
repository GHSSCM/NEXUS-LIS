<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    
    public function generatePDF()
    {

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


        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = '<i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>';
    
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
        // return view('pdf_test_details', compact('specimen', 'specimens','footerContent'));
        $pdf = Pdf::loadView('pdf_test_details_new', compact('specimen', 'specimens','footerContent'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        if(request('dl')){
            return $pdf->download("test-report-".str_replace(" ","-",strtolower($specimen['patient']['name'])).'-'. str_replace(" ","-",strtolower($specimen['specimen']['name'])).'.pdf');
        }
        return $pdf->stream('document.pdf');
    }
    //


    public function generatePDFBill()
    {


        $id= request('id');
        if(empty($id)){
            return abort(404);
        }

    $bill=\App\Models\Bill::query()->find($id);
    $bill['patient']=Patient::query()->where('uniqid',$bill->patient)->get()->first();

        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = '<i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>';
    
        $pdf = Pdf::loadView('pdf_bill_details', compact( 'bill','footerContent'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        $pdf->set_option('isRemoteEnabled', true); 
        if(request('dl')){
            return $pdf->download('document.pdf');
        }
        return $pdf->stream('document.pdf');
    }

}
