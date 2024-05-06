<?php

use App\Models\CustomField;
use App\Models\Patient;
use App\Models\UserAccount;
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


# user accounts

Route::get("/accounts",function(){
   
    return UserAccount::query()->where(request()->all())->get();
});

Route::get("/account/{id}",function($id){
    return UserAccount::query()->findOrFail($id);
});
Route::post("/account/{id}",function($id){
    $data= request()->all();
    if(empty($data['password'])){
        try{
            unset($data['password']);
        }catch(\Exception $e){

        }
    }else{
        $data['password']=sha1( $data['password']);
    }
    return UserAccount::find($id)->update($data);
});

Route::post("/account",function(){

    if(UserAccount::query()->where('username',request()->get('username'))->count()>0){
        return error_response(400,"Username already in use. Use a different username");
    }  
    $data= request()->all();
    $data['password']=sha1( $data['password']);
    return UserAccount::create($data);
});

Route::post("/login",function(){

    if(UserAccount::query()->where('username',request()->get('username'))->count()==0){
        return error_response(400,"Incorrect username. Verify and try again!");
    }  
   
    $account = UserAccount::query()->where('username',request()->get('username'))->where('password',sha1(request()->get('password')))->first();
    if(empty($account)){
        return error_response(400,"Incorrect password. Verify and try again!");
    }

    return  $account;
});

Route::get("/search-patient",function(){
    return  Patient::where('name', 'like', '%' . request()->get("query") . '%')->get();
});