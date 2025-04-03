<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/login");
});

Route::get("/launch-import",function(){
    return view('importer');
});

Route::get("/test-pdf",function(){
    $pdf= new PDFController();
    $data= $pdf->generatePDF(false);
    return $data;
});

Route::get("/test-pdf2",function(){
    $pdf= new PDFController();
    // $data= $pdf->generatePDF(false);
    $data =  view("pd2")->render();
    return $pdf->genPDFFromHTML($data);
});



