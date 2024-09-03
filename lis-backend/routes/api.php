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
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PDFController;
use App\Models\Bill;
use App\Models\LabSection;
use Illuminate\Support\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);

Route::get('/test-report', [PDFController::class, 'generatePDF']);
Route::get('/bill-report', [PDFController::class, 'generatePDFBill']);

Route::get('/export-database', [DatabaseController::class, 'exportDatabase']);
Route::get('/import-database', [DatabaseController::class, 'importDatabase']);

// Route::get("/tt",function(){
//     Schema::table('test_types', function (Blueprint $table) {
//         $table->string("type")->default("SINGLE")->change();
//     });
// });
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
    if(!empty($test['lab_section'])){
        $test['lab_section']=LabSection::query()->where('uniqid',$test['lab_section'])->first();
    }
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

   $techniques=[];
   for($i=0;$i<count($sp);$i++){
    $specimen=$sp[$i];
        $t = SpecimenTest::where('specimen',$specimen['uniqid'])->get()->pluck('test')->toArray();
        $tests=TestType::query()->whereIn('uniqid',$t)->where('lab_ref',request('lab_ref'))->get()->toArray();
       

  
        foreach($tests as $attachedtesttype ){
            $lab_section= LabSection::query()->where('uniqid',$attachedtesttype['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }
        }
     
        $sp[$i]['tests'] =  $tests;
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
    'specimens'=>$sp,
    'techniques'=>$techniques
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
            $b['state']=$b['state']??"N/A";
            RegisteredSpecimen::create($b);
        }
    }
    return "ok";
 });

 Route::get("/specimen/{id}",function($id){

    $specimen=RegisteredSpecimen::query()->find($id)->toArray();
    $specimen['patient']=Patient::query()->where("uniqid",$specimen['patient'])->first();
    $specimen['specimen']=SpecimenType::query()->where("uniqid",$specimen['specimen'])->first();
    $specimen['test']=TestType::query()->where("uniqid",$specimen['test'])->first()->toArray();
   
    $specimen['billing']= Bill::query()->where("specimen_id",$specimen['uniqid'])->first();

    $techniques=[];

    if($specimen['test']['type']=='GROUP'){
        $specimen['test']['meta']['fields']=["measures"=>[]];
        $subtests = $specimen['test']['meta']['subtests']; //am array
        $subtests = TestType::query()->whereIn("uniqid",$subtests)->get();
        foreach($subtests as $subtest){
            $specimen['test']['meta']['fields']["measures"]=array_merge( $specimen['test']['meta']['fields']["measures"],$subtest['meta']['fields']["measures"]); 
            $lab_section= LabSection::query()->where('uniqid',$subtest['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }
        }
        
    }else{
        $lab_section= LabSection::query()->where('uniqid',$specimen['test']['lab_section'])->first();
        if(!empty($lab_section)){
            $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
        }
    }

    
    if($specimen['groupID']){
        $others= RegisteredSpecimen::query()->where('groupID',$specimen['groupID'])->whereNot("id",$specimen['id'])->get();
        $specimen['others']=[$specimen];
        foreach($others as $other){
            $other['patient']=$specimen['patient'];
            $other['specimen']=SpecimenType::query()->where("uniqid",$other['specimen'])->first();
            $other['test']=TestType::query()->where("uniqid",$other['test'])->first();
            $other['billing']= Bill::query()->where("specimen_id",$other['uniqid'])->first();

            $lab_section= LabSection::query()->where('uniqid',$other['test']['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }

            $specimen['others'][]=$other;
        }
    }else{
        $specimen['others']=[$specimen];
    }
    $specimen['techniques']=$techniques;
    return $specimen;

 });


 Route::post("/specimenupdate/{id}",function($id){
    $specimen=RegisteredSpecimen::query()->find($id);
    $meta = request("meta");
    $meta['enteredby'] = request('user');
    $specimen->testingdate=request('testingdate');
    $specimen->testingtime=request('testingtime');
    $specimen->technique=request('technique');
    
    $specimen->meta=$meta;
    $specimen->enteredat = now();
    $specimen->save();
    return $meta;
 });



 Route::post("/specimenbulkupdate",function(){
    $data = request('data');

    $resp=[];
    foreach($data as $donnee){
        $specimen=RegisteredSpecimen::query()->find($donnee['id']);
        $meta = $donnee['meta'];
        $meta['enteredby'] =  $donnee['user'];
        $specimen->testingdate=$donnee['testingdate'];
        $specimen->testingtime=$donnee['testingtime'];
        $specimen->clinical=$donnee['clinical'];
        $specimen->technique=$donnee['technique']??$specimen->technique;
        $specimen->meta=$meta;
        $specimen->enteredat = now();
        $specimen->save();
        $resp[]=$specimen;
    }
    
    return $resp;
 });


 Route::post("/specimenvalidate/{id}",function($id){
    $specimen=RegisteredSpecimen::query()->find($id);
    $meta = request("meta");
    $meta['verifiedby'] = request('user');
    $meta['validated']=true;
    $specimen->meta=$meta;
    $specimen->validatedat = now();

    $specimen->save();
    return $meta;
 });

 Route::post("/specimenbulkvalidate",function(){


    $data = request('data');

    $resp=[];
    foreach($data as $donnee){
        $specimen=RegisteredSpecimen::query()->find($donnee['id']);
        $meta = $donnee['meta'];
        $meta['verifiedby'] = $donnee['user'];
        $meta['validated'] = true;
        $specimen->testingdate=$donnee['testingdate'];
        $specimen->testingtime=$donnee['testingtime'];
        $specimen->clinical=$donnee['clinical'];
        $specimen->technique=$donnee['technique']??$specimen->technique;
        $specimen->meta=$meta;
        $specimen->validatedat = now();
        $specimen->save();
        $resp[]=$specimen;
    }
    
    return $resp;
 });
//  

function parseListOfSpecimens($specimens){
    $data=[];
    $i=0;
    $patientsLoaded=[];//hashmap
    $specimensLoaded=[];//hashmap
    $testsLoaded=[];//hashmap

    $groupIDhashmap=[];

    foreach($specimens as $specimen){
        $patientsLoaded[$specimen['patient']] = isset($patientsLoaded[$specimen['patient']])?$patientsLoaded[$specimen['patient']]:Patient::query()->where("uniqid",$specimen['patient'])->first();
        $specimensLoaded[$specimen['specimen']] = isset($specimensLoaded[$specimen['specimen']])?$specimensLoaded[$specimen['specimen']]:SpecimenType::query()->where("uniqid",$specimen['specimen'])->first();
        $testsLoaded[$specimen['test']] = isset($testsLoaded[$specimen['test']])?$testsLoaded[$specimen['test']]:TestType::query()->where("uniqid",$specimen['test'])->first();
   
        $data[$i]['billing']= Bill::query()->where("specimen_id",$specimen['uniqid'])->first();

        $data[$i]['id']=$specimen['id'];

        $data[$i]['groupID'] = $specimen['groupID'];
        $data[$i]['state'] = $specimen['state'];

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
        $data[$i]['referredout']=$specimen['referredout'];
        $data[$i]['referredto']=$specimen['referredto'];
        $data[$i]['meta']=$specimen['meta'];


        //add to groupIDhashmap
        if($specimen['groupID']){
            if(!isset($groupIDhashmap[$specimen['groupID']])){
                $groupIDhashmap[$specimen['groupID']]=[];
            }
            $groupIDhashmap[$specimen['groupID']][]=$data[$i];
        }else{
            if(!isset($groupIDhashmap["NOTATTACHED"])){
                $groupIDhashmap["NOTATTACHED"]=[];
            }
            $groupIDhashmap["NOTATTACHED"][]=$data[$i];
        }
        $i++;
    }


    //final

    // $finalData=[];

    // foreach($groupIDhashmap as $key=>$value){
    //     if($key=="NOTATTACHED"){
    //         $finalData= array_merge($finalData,$groupIDhashmap[$key]);
    //     }else{
    //         $allExceptFirst = array_slice($value, 1);
    //         $value[0]["others"]=array_merge($value[0],$allExceptFirst);
    //         $finalData[]=$value[0];
    //     }
    // }

    // return $finalData;
    return $data;
}
 Route::get("/specimens",function(){
    if(request('count')){
        $count = request('count');
        $all=request()->all();
        unset($all['count']);
        $sps=  RegisteredSpecimen::query()->where($all)->orderByDesc('updated_at')->get()->take($count);
    }else{
        $sps=  RegisteredSpecimen::query()->where(request()->all())->orderByDesc('updated_at')->get();
    }
    return parseListOfSpecimens($sps);
 });


 Route::get("/lab-sections",function(){
    if(request('count')){
        $count = request('count');
        $all=request()->all();
        unset($all['count']);
        $ls=  LabSection::query()->where($all)->orderByDesc('updated_at')->get()->take($count);
    }else{
        $ls=  LabSection::query()->where(request()->all())->orderByDesc('updated_at')->get();
    }
    return $ls;
 });

 Route::post("/lab-section",function(){
    return LabSection::create(request()->all());
 });


 Route::post("/lab-section/{id}",function($id){
    return LabSection::findOrFail($id)->update(request()->all());
 });


 Route::get("/lab-section/{id}",function($id){
    return LabSection::findOrFail($id);
 });




 Route::get("/tests",function(){
    return parseListOfSpecimens(RegisteredSpecimen::query()->where(request()->all())->get()->filter(function($val){
        return isset($val->meta['enteredby']) && $val->meta['enteredby'];
    }));
 });



 Route::get("/editspecimen-data/{id}",function($id){

    $registeredSpecimen = RegisteredSpecimen::findOrFail($id)->toArray();

    $registeredSpecimen['test']=TestType::query()->where('uniqid',$registeredSpecimen["test"])->firstOrFail();
    $registeredSpecimen['specimen']=SpecimenType::query()->where('uniqid',$registeredSpecimen["specimen"])->firstOrFail()->toArray();

    $patient = Patient::query()->where('uniqid',$registeredSpecimen["patient"])->firstOrFail();
    $sp =  SpecimenType::query()->where('lab_ref',request('lab_ref'))->get()->toArray();

    $techniques=[];

    for($i=0;$i<count($sp);$i++){
     $specimen=$sp[$i];
         $t = SpecimenTest::where('specimen',$specimen['uniqid'])->get()->pluck('test')->toArray();
         $sp[$i]['tests'] = TestType::query()->whereIn('uniqid',$t)->where('lab_ref',request('lab_ref'))->get();

         if($sp[$i]['uniqid']== $registeredSpecimen['specimen']['uniqid']){
            $registeredSpecimen['specimen']['tests']=$sp[$i]['tests'];
         }

         foreach($sp[$i]['tests'] as $attachedtesttype ){
            $lab_section= LabSection::query()->where('uniqid',$attachedtesttype['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }
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
            'id'=>$patient->id,
        ],
        'physicians'=>$uniquePhysicians,
        'preleveurs'=>$uniquePreleveurs,
        'specimens'=>$sp,
        'inputdata'=>$registeredSpecimen,
        'techniques'=>$techniques
    ];
 });
 


 Route::get("/statistica",function(){

    $today = Carbon::today();

    $patientsTodayCount = Patient::whereDate('created_at', $today)->where(request()->all())->count();
    $patientsCount = Patient::where(request()->all())->count();

    $specimensTodayCount = RegisteredSpecimen::whereDate('created_at', $today)->where(request()->all())->count();
    $specimensCount = RegisteredSpecimen::where(request()->all())->count();

    $specimensTodayCount = RegisteredSpecimen::whereDate('created_at', $today)->where(request()->all())->count();
    $specimensCount = RegisteredSpecimen::where(request()->all())->count();

    $resultsEnterredTodayCount =  $specimensCount==0?0:RegisteredSpecimen::whereDate('testingdate', $today)->where(request()->all())->whereJsonContains('meta', ['results' => []])
    // ->whereRaw('JSON_LENGTH(meta->"$.results") > 0')
    ->get()->filter(function($element){
        if(!isset($element['meta']) || !isset($element['meta']['results'])){
            return false;
        }
       return count($element['meta']['results']) >0;
    })->count();

    $resultsEnterredCount =  $specimensCount==0?0: RegisteredSpecimen::where(request()->all())->whereJsonContains('meta', ['results' => []])
    ->get()->filter(function($element){
        if(!isset($element['meta']) || !isset($element['meta']['results'])){
            return false;
        }
       return count($element['meta']['results']) >0;
    })->count();

    return [
        "patientsToday"=>$patientsTodayCount,
        "totalPatients"=>$patientsCount,
        "specimensToday"=>$specimensTodayCount,
        "totalSpecimens"=>$specimensCount,
        "resultsToday"=>$resultsEnterredTodayCount,
        "totalResults"=>$resultsEnterredCount
    ];
 });


 Route::post("/editspecimen/{id}",function($id){
    return RegisteredSpecimen::findOrFail($id)->update(request()->all());
 });

 Route::get("/bill/{id}/delete",function($id){
    return Bill::findOrFail($id)->delete();
 });


 Route::get("/bills",function(){
    $bills =  Bill::query()->where(request()->all())->get();

    $specimentsLoaded=[];//hashmap
    $testsLoaded=[];//hashmap
    $patientsLoaded=[];//hashmap
    
    $finalData=[];

    foreach($bills as $bill){
        $billData=$bill->toArray();
        $billData['tests']=[];
        if(isset($bill->meta['specimens'])){
            foreach($bill->meta['specimens'] as $specimentData){
                $billData['created_at']=formatDate($bill['created_at']??"");
                $specimentUniqid= $specimentData['uniqid'];
                if(!isset($specimentsLoaded[$specimentUniqid])){
                    $specimentsLoaded[$specimentUniqid]=RegisteredSpecimen::query()->where('uniqid',$specimentUniqid)->get()->first();
                }
                if(!isset($testsLoaded[$specimentsLoaded[$specimentUniqid]['test']])){
                    $testsLoaded[$specimentsLoaded[$specimentUniqid]['test']]=TestType::query()->where('uniqid',$specimentsLoaded[$specimentUniqid]['test'])->get()->first();
                }
                $billData['tests'][]=$testsLoaded[$specimentsLoaded[$specimentUniqid]['test']]['name'];
            }

          
        }

        if(!isset($patientsLoaded[$specimentsLoaded[$specimentUniqid]['patient']])){
            $patientsLoaded[$specimentsLoaded[$specimentUniqid]['patient']]=Patient::query()->where('uniqid',$specimentsLoaded[$specimentUniqid]['patient'])->get()->first();
        }

        $billData['patientname']=$patientsLoaded[$specimentsLoaded[$specimentUniqid]['patient']]['name'];
        $finalData[]=$billData;
            
    }
    return $finalData;
 });

 Route::get('/initbilling-patient/{patientId}',function($patientId){
    $patient= Patient::query()->find($patientId);
    $data=[];
    $specimens= RegisteredSpecimen::query()->where("patient",$patient->uniqid)->get();
    foreach($specimens as $specimen){
        $test = TestType::query()->where('uniqid',$specimen->test)->get()->first();
        $sp = SpecimenType::query()->where('uniqid',$specimen->specimen)->get()->first();
     
        $data[]=[
            "amount"=>$test->cost,
            "test"=>$test->name,
            "specimen"=>$sp->name,
            "patient"=>$patient->name,
            "patientId"=>$patient->uniqid,
            "receptiondate"=>$specimen->receptiondate,
            "uniqid"=>$specimen->uniqid,
            "label"=>"$test->name, $sp->name, received on: $specimen->receptiondate"
        ];
    }
    return $data;
 });


 Route::get('/initbilling-speciment/{registeredspecimentid}',function($registeredspecimentid){

    $registeredSpecimen = RegisteredSpecimen::query()->find($registeredspecimentid);
    $patient= Patient::query()->where("uniqid",$registeredSpecimen->patient)->first();
    $data=[];


    $test = TestType::query()->where('uniqid',$registeredSpecimen->test)->get()->first();
    $sp = SpecimenType::query()->where('uniqid',$registeredSpecimen->specimen)->get()->first();
 
    $data[]=[
        "amount"=>$test->cost,
        "test"=>$test->name,
        "specimen"=>$sp->name,
        "patient"=>$patient->name,
        "patientId"=>$patient->uniqid,
        "receptiondate"=>$registeredSpecimen->receptiondate,
        "uniqid"=>$registeredSpecimen->uniqid,
        "label"=>"$test->name, $sp->name, received on: $registeredSpecimen->receptiondate"
    ];

    $specimens= RegisteredSpecimen::query()->where("patient",$patient->uniqid)->whereNot("id",$registeredspecimentid)->get();
    foreach($specimens as $specimen){
        $test = TestType::query()->where('uniqid',$specimen->test)->get()->first();
        $sp = SpecimenType::query()->where('uniqid',$specimen->specimen)->get()->first();
     
        $data[]=[
            "amount"=>$test->cost,
            "test"=>$test->name,
            "specimen"=>$sp->name,
            "patient"=>$patient->name,
            "patientId"=>$patient->uniqid,
            "receptiondate"=>$specimen->receptiondate,
            "uniqid"=>$specimen->uniqid,
            "label"=>"$test->name, $sp->name, received on: $specimen->receptiondate"
        ];
    }
    return $data;
 });

 Route::post("/makebill",function(){
    // "meta","generatedby","specimen_id","total","patient"

    $requestData = request()->all();
    if(count( $requestData['meta']['specimens'])==0){
        return error_response(400,"Incorrect data");
    }else if(count( $requestData['meta']['specimens'])==1){
        $requestData['specimen_id']= $requestData['meta']['specimens'][0]['uniqid'];
    }else{
        $requestData['specimen_id']=null;
    }
    return Bill::query()->create($requestData);

 });