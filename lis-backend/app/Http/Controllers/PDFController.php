<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    
    public function generatePDF($id)
    {


    $specimen=\App\Models\RegisteredSpecimen::query()->find($id)->toArray();
    $specimen['patient']=\App\Models\Patient::query()->where("uniqid",$specimen['patient'])->first();
    $specimen['specimen']=\App\Models\SpecimenType::query()->where("uniqid",$specimen['specimen'])->first();
    $specimen['test']=\App\Models\TestType::query()->where("uniqid",$specimen['test'])->first();


        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = '<i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>';
    
        $pdf = Pdf::loadView('pdf_test_details', compact( 'specimen','footerContent'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        return $pdf->stream('document.pdf');
    }
    //


    public function generatePDFBill($id)
    {


    $bill=\App\Models\Bill::query()->find($id);
    $bill['patient']=Patient::query()->where('uniqid',$bill->patient)->get()->first();

        // $htmlContent = '<h1>Hello World</h1>'; // Replace with your dynamic content
        $footerContent = '<i>QUALITY DIAGNOSTICS, QUALITY CARE<br/>Aminatou Square, Mokindi layout, Isokolo. P.O. Box 729, Limbe, South West Region - Republic of Cameroon</i>';
    
        $pdf = Pdf::loadView('pdf_bill_details', compact( 'bill','footerContent'))->setPaper('a4')
        ->setWarnings(false);
        $pdf->set_option('isPhpEnabled', true);
        return $pdf->stream('document.pdf');
    }

}
