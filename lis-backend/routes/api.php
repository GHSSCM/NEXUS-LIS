<?php

use App\Models\CustomField;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// patients

Route::get("/patients",function(){
    return Patient::all();
});

Route::post("/patient",function(){
    return Patient::create(request()->all());
});

Route::get("/patient/{id}",function($id){
    return Patient::findOrFail($id);
});

Route::put("/patient/{id}",function($id){
    $patient =  Patient::findOrFail($id);
    $patient->update(request()->all());
    return $patient;
});


// custom fields


Route::get("/customfields",function(){
  
    return CustomField::query()->where(request()->all())->get();
});

Route::post("/customfields",function(){
    $fieldsdata = request()->get('fields');
    $category =  request()->get('category');
    foreach($fieldsdata as $data){
        $data['lab_ref']=request('lab_ref');
        if(isset($data['id'])){
            // unset($data[''])
            CustomField::find($data['id'])->update($data);
        }else{
            CustomField::query()->create($data);
        }
    }
    return CustomField::query()->where(['category'=>$category])->get();
});

Route::get("/customfield/{id}",function($id){
    return CustomField::findOrFail($id);
});

Route::get("/customfield/{id}/delete",function($id){
    $cf =  CustomField::findOrFail($id);
    return $cf->delete();
});

Route::put("/customfield/{id}",function($id){
    $patient =  CustomField::findOrFail($id);
    $patient->update(request()->all());
    return $patient;
});