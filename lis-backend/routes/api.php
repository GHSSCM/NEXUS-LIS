<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Authorization, Content-Type');

use App\Http\Controllers\MigrationController;
use App\Models\CustomField;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\RegisteredSpecimen;
use App\Models\SpecimenTest;
use App\Models\SpecimenType;
use App\Models\TestType;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);



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

Route::post("/patient/{id}",function($id){
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

    $lab =  Laboratory::query()->where('ref',$account->lab_ref)->first();
    if(empty($lab)){

        return  error_response(400,"Incorrect lab data [2]");
    }

    $data = $account->toArray();
    $data['config'] = $lab->meta;
    return  $data;
});

Route::get("/search-patient",function(){
    $q = request()->get("query");
    return  Patient::whereRaw('name like ? or extraid like ? or reference like ? or id like ?',["%$q%","%$q%","%$q%","%$q%"])->get();
});

Route::get('/duplicate-test/{id}',function($id){
    $data = TestType::where('id',$id)->first();
    if(empty($data)){
        return error_response(400,"Duplication error [1]");
    }
    $data =  $data->toArray();
    unset($data['uniqid']);
    unset($data['id']);
    $data['name'] = '[DUPLICATA] '.$data['name'];
    return TestType::create($data);
});


Route::get('/duplicate-specimen/{id}',function($id){
    $data = SpecimenType::where('id',$id)->first();
    if(empty($data)){
        return error_response(400,"Duplication error [1]");
    }
    $data =  $data->toArray();
    unset($data['uniqid']);
    unset($data['id']);
    $data['name'] = '[DUPLICATA] '.$data['name'];
    return SpecimenType::create($data);
});


Route::get("/config",function(){
    $labref = request()->get("lab_ref");
    if(empty($labref)){
        return  error_response(400,"Incorrect lab data");
    }
    $lab =  Laboratory::query()->where('ref',$labref)->first();
    if(empty($lab)){

        return  error_response(400,"Incorrect lab data [2]");
    }
    return $lab->meta;
});

Route::post("/config",function(){
    
    $labref = request()->get("lab_ref");
    if(empty($labref)){
        return  error_response(400,"Incorrect lab data");
    }
    $lab =  Laboratory::query()->where('ref',$labref)->first();
    if(empty($lab)){

        return  error_response(400,"Incorrect lab data [2]");
    }

    $data = request()->all();
    unset($data['lab_ref']);

    $lab->meta = $data;
    $lab->save();
    return $lab->meta;

});



Route::get("/testtypes",function(){
    return  TestType::where(request()->all())->get();
});

Route::get("/specimentypes",function(){
    return  SpecimenType::where(request()->all())->get();
});

Route::post("/specimentype",function(){
    $sp =   SpecimenType::create(request()->all());
    foreach(request()->get('tests') as $test){
        SpecimenTest::create([
            'specimen'=>$sp->uniqid,
            'test'=>$test
        ]);
    }
    return $sp;
});

Route::post("/testtype",function(){
    $type =   TestType::create(request()->all());
    foreach(request()->get('specimens') as $specimen){
        SpecimenTest::create([
            'specimen'=>$specimen,
            'test'=>$type->uniqid
        ]);
    }
    return $type;
});

Route::get("/testtype/{id}",function($id){
    $test =   TestType::findOrFail($id);
    if($test->type!="SINGLE"){
        return error_response(400,"This is a group test type!");
    }   
    $test=$test->toArray();

    $sp = SpecimenTest::where('test',$test['uniqid'])->get()->pluck('specimen')->toArray();
 
    $test['specimens'] = SpecimenType::query()->whereIn('uniqid',$sp)->where('lab_ref',request('lab_ref'))->get();
    return $test;
});

Route::post("/testtype/{id}",function($id){
    $type =  TestType::findOrFail($id);
    
    $type->update(request()->all());

    SpecimenTest::where('test',$type['uniqid'])->delete();
    foreach(request()->get('specimens') as $specimen){
        SpecimenTest::create([
            'specimen'=>$specimen,
            'test'=>$type->uniqid
        ]);
    }
    return $type;
});

Route::get("/grouptesttype/{id}",function($id){
    $test =   TestType::findOrFail($id);
    if($test->type!="GROUP"){
        return error_response(400,"This is a single test type!");
    }
    $test = $test->toArray();


    $sp = SpecimenTest::where('test',$test['uniqid'])->get()->pluck('specimen')->toArray();
 
    $test['specimens'] = SpecimenType::query()->whereIn('uniqid',$sp)->where('lab_ref',request('lab_ref'))->get();

    $test['subtests']=TestType::query()->whereIn('uniqid',($test['meta']??[])['subtests']??[])->where('lab_ref',request('lab_ref'))->get();
    return $test;
});

Route::get("/specimentype/{id}",function($id){
    $specimen =   SpecimenType::findOrFail($id);
    $specimen=$specimen->toArray();

    $t = SpecimenTest::where('specimen',$specimen['uniqid'])->get()->pluck('test')->toArray();
 
    $specimen['tests'] = TestType::query()->whereIn('uniqid',$t)->where('lab_ref',request('lab_ref'))->get();
    return $specimen;
});


Route::post("/specimentype/{id}",function($id){
    $sp =  SpecimenType::findOrFail($id);
    
    $sp->update(request()->all());

    SpecimenTest::where('specimen',$sp['uniqid'])->delete();
    foreach(request()->get('tests') as $test){
        SpecimenTest::create([
            'specimen'=>$sp->uniqid,
            'test'=>$test
        ]);
    }
    return $sp;
});

Route::get("/addspecimen-data/{id}",function($id){
   $patient = Patient::findOrFail($id);
   $sp =  SpecimenType::query()->where('lab_ref',request('lab_ref'))->get()->toArray();
   for($i=0;$i<count($sp);$i++){
    $specimen=$sp[$i];
        $t = SpecimenTest::where('specimen',$specimen['uniqid'])->get()->pluck('test')->toArray();
        $sp[$i]['tests'] = TestType::query()->whereIn('uniqid',$t)->where('lab_ref',request('lab_ref'))->get();
   }

   $uniquePhysicians= RegisteredSpecimen::pluck('physician')->unique()->values()->all();
   $uniquePreleveurs= RegisteredSpecimen::pluck('preleveur')->unique()->values()->all();
   return [
    'patient'=>[
        'name'=>$patient->name,
        'reference'=>$patient->reference,
        'dob'=>$patient->dob,
        'uniqid'=>$patient->uniqid
    ],
    'physicians'=>$uniquePhysicians,
    'preleveurs'=>$uniquePreleveurs,
    'specimens'=>$sp
    ];
});

Route::post("/addspecimen",function(){
    $ata =  request()->get('ata');
    foreach($ata as $a){
        foreach($a['tests'] as $t){
            $b = $a;
            $b['test']=$t;
            unset($b['tests']);
            $b['lab_ref']=request('lab_ref');
            RegisteredSpecimen::create($b);
        }
    }
    return "ok";
 });

 Route::get("/specimens",function(){
    $specimens = RegisteredSpecimen::query()->where(request()->all())->get();
    $data=[];
    $i=0;
    $patientsLoaded=[];//hashmap
    $specimensLoaded=[];//hashmap
    $testsLoaded=[];//hashmap
    foreach($specimens as $specimen){
        $patientsLoaded[$specimen['patient']] = isset($patientsLoaded[$specimen['patient']])?$patientsLoaded[$specimen['patient']]:Patient::query()->where("uniqid",$specimen['patient'])->first();
        $specimensLoaded[$specimen['specimen']] = isset($specimensLoaded[$specimen['specimen']])?$specimensLoaded[$specimen['specimen']]:SpecimenType::query()->where("uniqid",$specimen['specimen'])->first();
        $testsLoaded[$specimen['test']] = isset($testsLoaded[$specimen['test']])?$testsLoaded[$specimen['test']]:TestType::query()->where("uniqid",$specimen['test'])->first();
   
        $data[$i]['id']=$specimen['id'];

        $data[$i]['patient']=[
            "name"=>$patientsLoaded[$specimen['patient']]["name"],
            "id"=>$patientsLoaded[$specimen['patient']]["id"]
        ];

        $data[$i]['specimen']=[
                "name"=>$specimensLoaded[$specimen['specimen']]['name']
        ];

        $data[$i]['test']=[
            "name"=>$testsLoaded[$specimen['test']]['name']
        ];

        $data[$i]['received']=[
            "receptiondate"=>$specimen['receptiondate'],
            "receptiontime"=>$specimen['receptiontime']
        ];

        $data[$i]['physician']=$specimen['physician'];
        $data[$i]['preleveur']=$specimen['preleveur'];
    }
    return $data;
 });



 Route::get("/editspecimen-data/{id}",function($id){

    $registeredSpecimen = RegisteredSpecimen::findOrFail($id)->toArray();

    $registeredSpecimen['test']=TestType::query()->where('uniqid',$registeredSpecimen["test"])->firstOrFail();
    $registeredSpecimen['specimen']=SpecimenType::query()->where('uniqid',$registeredSpecimen["specimen"])->firstOrFail()->toArray();

    $patient = Patient::query()->where('uniqid',$registeredSpecimen["patient"])->firstOrFail();
    $sp =  SpecimenType::query()->where('lab_ref',request('lab_ref'))->get()->toArray();

    for($i=0;$i<count($sp);$i++){
     $specimen=$sp[$i];
         $t = SpecimenTest::where('specimen',$specimen['uniqid'])->get()->pluck('test')->toArray();
         $sp[$i]['tests'] = TestType::query()->whereIn('uniqid',$t)->where('lab_ref',request('lab_ref'))->get();

         if($sp[$i]['uniqid']== $registeredSpecimen['specimen']['uniqid']){
            $registeredSpecimen['specimen']['tests']=$sp[$i]['tests'];
         }
    }
 
    $uniquePhysicians= RegisteredSpecimen::pluck('physician')->unique()->values()->all();
    $uniquePreleveurs= RegisteredSpecimen::pluck('preleveur')->unique()->values()->all();
    return [
        'patient'=>[
            'name'=>$patient->name,
            'reference'=>$patient->reference,
            'dob'=>$patient->dob,
            'uniqid'=>$patient->uniqid,
            'id'=>$patient->id
        ],
        'physicians'=>$uniquePhysicians,
        'preleveurs'=>$uniquePreleveurs,
        'specimens'=>$sp,
        'inputdata'=>$registeredSpecimen
    ];
 });
 

 Route::post("/editspecimen/{id}",function($id){
    return RegisteredSpecimen::findOrFail($id)->update(request()->all());
 });