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
use App\Models\ResultSheetExportation;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PDFController;
use App\Models\Bill;
use App\Models\LabSection;
use App\Models\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\ImageUploadController;


Route::
// ->middleware('api')
    prefix('nx')
    // ->namespace('App\Http\Controllers\Api')
    ->group(function () {
        Route::get('/services', function () {
            return response()->json(['data' => [

                [
                    'name' => 'Nexus - Patient Information System',
                    'description' => 'A system to manage patient data and operations.',
                    'route'=>'/p',
                    'short_name'=>'Patients',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Covid Icons by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 20.679a3.429 3.429 0 1 0 0-6.858a3.429 3.429 0 0 0 0 6.858m-.571-9.429h1.142m-.571 0v2.571m3.839-1.218l.808.808m-.404-.404l-1.819 1.819m3.576 1.853v1.142m0-.571h-2.571m1.218 3.839l-.808.808m.404-.404l-1.819-1.819m-1.853 3.576h-1.142m.571 0v-2.571m-3.839 1.218l-.808-.808m.404.404l1.819-1.819m-3.576-1.853v-1.142m0 .571h2.571m-1.218-3.839l.808-.808m-.404.404l1.819 1.819M7.5 9a4.125 4.125 0 1 0 0-8.25A4.125 4.125 0 0 0 7.5 9M.75 17.25a6.753 6.753 0 0 1 9.4-6.208"/></svg>',
                ],
                [
                    'name' => 'Nexus - Laboratory Information System',
                    'description' => 'A system to manage laboratory data and operations.',
                    'route'=>'/nexus.lab',
                    'short_name'=>'Laboratory',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Guidance by Streamline - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" d="M6.5 12.5h.146c2.206 0 4.381.514 6.354 1.5s4.148 1.5 6.354 1.5H20.5m-13-14h9v.25l-.707.972a6.76 6.76 0 0 0 .688 8.759L22.5 17.5c0 2-1 3.5-3 5h-15c-2-1.5-3-3-3-5l6.02-6.02a6.76 6.76 0 0 0 .687-8.758L7.5 1.75z"/></svg>',
                ],
                [
                    'name' => 'Nexus - Billing Information System',
                    'description' => 'A system to manage billing and financial operations.',
                    'route'=>'/bl',
                    'short_name'=>'Billing',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Stash Icons by Pingback LLC - https://github.com/stash-ui/icons/blob/master/LICENSE --><path fill="currentColor" d="M7.179 3.5h5.642c.542 0 .98 0 1.333.029c.365.03.685.093.981.243a2.5 2.5 0 0 1 1.092 1.093c.151.296.214.616.244.98c.029.355.029.792.029 1.334v3.071a.5.5 0 0 1-1 0V7.2c0-.568 0-.964-.026-1.273c-.024-.302-.07-.476-.138-.608a1.5 1.5 0 0 0-.655-.656c-.132-.067-.305-.113-.608-.137c-.309-.026-.705-.026-1.273-.026H7.2c-.568 0-.964 0-1.273.026c-.302.024-.476.07-.608.137a1.5 1.5 0 0 0-.656.656c-.067.132-.113.306-.137.608C4.5 6.236 4.5 6.632 4.5 7.2v9.6c0 .568 0 .965.026 1.273c.024.302.07.476.137.608a1.5 1.5 0 0 0 .646.65l.01.002c.018.004.062.014.144.026q.189.028.495.05c.404.03.92.05 1.466.064c1.089.027 2.265.027 2.826.027a.5.5 0 0 1 0 1h-.001c-.56 0-1.748 0-2.85-.027a33 33 0 0 1-1.515-.066a8 8 0 0 1-.566-.058a1.5 1.5 0 0 1-.453-.122a2.5 2.5 0 0 1-1.093-1.092c-.15-.296-.213-.616-.243-.98C3.5 17.8 3.5 17.362 3.5 16.82V7.18c0-.542 0-.98.029-1.333c.03-.365.093-.685.243-.981a2.5 2.5 0 0 1 1.093-1.093c.296-.15.616-.213.98-.243c.355-.03.793-.03 1.335-.03"/><path fill="currentColor" d="M18.62 12.5c.403 0 .735 0 1.006.022c.281.023.54.072.782.196a2 2 0 0 1 .874.874c.124.243.173.501.196.782c.022.27.022.603.022 1.005v2.242c0 .402 0 .734-.022 1.005c-.023.281-.072.54-.196.782a2 2 0 0 1-.874.874c-.243.124-.501.173-.782.196c-.27.022-.603.022-1.005.022h-4.242c-.402 0-.734 0-1.005-.022c-.281-.023-.54-.072-.782-.196a2 2 0 0 1-.874-.874c-.124-.243-.173-.501-.196-.782c-.022-.27-.022-.603-.022-1.005v-2.242c0-.402 0-.734.022-1.005c.023-.281.072-.54.196-.782a2 2 0 0 1 .874-.874c.243-.124.501-.173.782-.196c.27-.022.603-.022 1.005-.022zm-5.164 1.019c-.22.018-.332.05-.41.09a1 1 0 0 0-.437.437c-.04.078-.072.19-.09.41l-.004.044h7.97l-.004-.044c-.018-.22-.05-.332-.09-.41a1 1 0 0 0-.437-.437c-.078-.04-.19-.072-.41-.09a13 13 0 0 0-.944-.019h-4.2c-.428 0-.72 0-.944.019M20.5 16.5h-8v1.1c0 .428 0 .72.019.944c.018.22.05.332.09.41a1 1 0 0 0 .437.437c.078.04.19.072.41.09c.225.019.516.019.944.019h4.2c.428 0 .72 0 .944-.019c.22-.018.332-.05.41-.09a1 1 0 0 0 .437-.437c.04-.078.072-.19.09-.41c.019-.225.019-.516.019-.944zm-14-10a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zM6 10a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 6 10m.5 2.5a.5.5 0 0 0 0 1H10a.5.5 0 0 0 0-1zM6 17a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 6 17"/></svg>',
                ],
                [
                    'name' => 'Nexus - Blood Bank Information System',
                    'description' => 'A system to manage blood bank operations and data.',
                    'route'=>'/bb',
                    'short_name'=>'Blood Bank',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48"><!-- Icon from Health Icons by Resolve to Save Lives - https://github.com/resolvetosavelives/healthicons/blob/main/LICENSE --><g fill="currentColor"><path d="M15.465 31.398a1 1 0 1 0-1.902.62a11.53 11.53 0 0 0 4.178 5.767a11.48 11.48 0 0 0 6.759 2.203c.552 0 1-.449 1-1.003s-.448-1.003-1-1.003a9.5 9.5 0 0 1-5.584-1.82a9.53 9.53 0 0 1-3.451-4.764"/><path fill-rule="evenodd" d="m24 4l-.69.66l-.004.004l-.009.008l-.032.032l-.122.119q-.16.157-.456.455a72 72 0 0 0-6.492 7.621C12.681 17.68 9 24.082 9 30.08C9 37.845 15.796 44 24 44s15-6.155 15-13.92c0-6-3.681-12.401-7.195-17.18a72 72 0 0 0-6.492-7.622a42 42 0 0 0-.578-.574l-.032-.032l-.01-.008zm-1.451 4.334A64 64 0 0 1 24 6.8a70 70 0 0 1 6.195 7.29C33.681 18.832 37 24.777 37 30.08c0 6.503-5.74 11.914-13 11.914S11 36.583 11 30.08c0-5.303 3.319-11.248 6.805-15.99a70 70 0 0 1 4.744-5.756" clip-rule="evenodd"/></g></svg>',
                ],
                [
                    'name' => 'Nexus - Phamarcy Information System',
                    'description' => 'A system to manage pharmacy operations and data.',
                    'route'=>'/pis',
                    'short_name'=>'Phamarcy',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26"><!-- Icon from Pepicons Pencil by CyCraft - https://github.com/CyCraft/pepicons/blob/dev/LICENSE --><g fill="currentColor"><path fill-rule="evenodd" d="m18.85 13.192l-6.365-6.364a4 4 0 0 0-5.657 5.657l6.364 6.364a4 4 0 1 0 5.657-5.657M7.535 7.536a3 3 0 0 1 4.242 0l6.364 6.364a3 3 0 1 1-4.242 4.242l-6.364-6.364a3 3 0 0 1 0-4.242" clip-rule="evenodd"/><path d="m16.037 10.58l-.243.97c-1.201-.3-2.223-.154-3.101.432c-.87.58-1.454 1.687-1.73 3.355l-.987-.164c.318-1.917 1.032-3.27 2.162-4.023c1.122-.748 2.434-.936 3.899-.57"/><path fill-rule="evenodd" d="M13 24.5c6.351 0 11.5-5.149 11.5-11.5S19.351 1.5 13 1.5S1.5 6.649 1.5 13S6.649 24.5 13 24.5m0 1c6.904 0 12.5-5.596 12.5-12.5S19.904.5 13 .5S.5 6.096.5 13S6.096 25.5 13 25.5" clip-rule="evenodd"/></g></svg>',
                ],
                [
                    'name' => 'Nexus - Configuration',
                    'description' => 'Configure your health information system & data',
                    'route'=>'/config',
                    'short_name'=>'Configuration',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M7.5 15H9v-4H7.5v1.25H6v1.5h1.5zm2.5-1.25h8v-1.5h-8zM15 11h1.5V9.75H18v-1.5h-1.5V7H15zM6 9.75h8v-1.5H6zM8 21v-2H4q-.825 0-1.412-.587T2 17V5q0-.825.588-1.412T4 3h16q.825 0 1.413.588T22 5v12q0 .825-.587 1.413T20 19h-4v2zm-4-4h16V5H4zm0 0V5z"/></svg>',
                ],
            ]]);
        });
    });




Route::get('/run-migrations', [MigrationController::class, 'runMigrations']);

Route::get('/test-report', [PDFController::class, 'generatePDF']);
Route::get('/test-report-data',function(){

    $find = ResultSheetExportation::query()->where('registered_specimen',request('id'))->first();
    if($find){
        return [
            'data'=>$find->html
        ];
    }
    
    $pdfController = new PDFController();
    return [
        'data'=>$pdfController->generatePDF()->render()
    ];
});

Route::post('/test-report-save',function(){
    if(empty(request('html'))||empty(request('registered_specimen'))){
        return error_response(400,"Faulty data");
    }
    $html = request('html'); // The HTML from TinyMCE



    $params = request()->all();

    $params['html'] = fixTinyMCEHtml($html);

    $find = ResultSheetExportation::query()->where('registered_specimen',$params['registered_specimen'])->first();
    if($find){
        $find->update($params);
        // return $params['html'];
        return ['data'=>'ok'];
    }
    ResultSheetExportation::create($params);
    // return $params['html'];
    return ['data'=>'ok'];
});

Route::get('/test-report-delete',function(){
    if(empty(request('id'))){
        return error_response(400,"Faulty data");
    }
    $find = ResultSheetExportation::query()->where('registered_specimen',request('id'))->first();
    if($find){
        $find->delete();
    }
    $pdfController = new PDFController();
    return ['data'=> $pdfController->generatePDF()->render()];
});

Route::post('/upload/image', [ImageUploadController::class, 'upload'])->name('tinymce.upload');

Route::get('/bill-report', [PDFController::class, 'generatePDFBill']);

Route::get('/export-database', [DatabaseController::class, 'exportDatabase']);
Route::post('/import-database', [DatabaseController::class, 'importDatabase'])->name('importDatabase');

Route::get("/permissions",function(){
    $lab =  Laboratory::query()->where('ref',request('lab_ref'))->first();
    $labName="";
    if(empty($lab)){
        $labName =  $lab->name;
    }
    if(request('user_id')){
        $user =  \App\Models\UserAccount::find(request('user_id'));
        if($user){
            return [
                "permissions"=>$user->perms??[],
                "labName"=>$labName
            ];
        }
    }
    return [
        "labName"=>$labName,
        "permissions"=>[]
    ];
});
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
    $data =request()->all();
    $lab = getCurrentLab();
    $meta = $lab['meta']??[];
    $periodicity = $meta['patient_counterperiod']??'daily';
    $period_id = "";

    switch($periodicity){
        case 'daily':  $period_id =\Carbon\Carbon::now()->format('dmY');break;
        case 'monthly':  $period_id =\Carbon\Carbon::now()->format('mY');break;
        case 'yearly':  $period_id =\Carbon\Carbon::now()->format('Y');break;
        default:  $period_id =\Carbon\Carbon::now()->format('Y');
    }

    $current_period_id = $meta['current_period_id']??\Carbon\Carbon::now()->format('dmY');

    $last_counter= $meta['last_counter']??0;


    if($current_period_id==$period_id){
        $counter = $last_counter+1; 
    }else{
        $current_period_id=$period_id;    
        $counter=1;
    }

    $last_counter=$counter;
    $meta['last_counter']=$last_counter;
    $meta['current_period_id']=$current_period_id;
    $meta['patient_counterperiod']=$periodicity;

    $lab->meta=$meta;
    $lab->save();

    $data['reference']=trim($meta['patient_prefix']??'')."$counter"."$current_period_id".trim($meta['patient_suffix']??'');


    return Patient::create($data);
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

Route::get("/permissions-available",function(){
    return array_map(fn($perm) => $perm->value, Permission::cases());
});

Route::get("/account/{id}",function($id){
    $u = UserAccount::query()->findOrFail($id)->toArray();
    $u['permissions']= array_map(fn($perm) => $perm->value, Permission::cases());
    return $u;
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


Route::get("/lab",function(){
    $labref = request()->get("lab_ref");
    if(empty($labref)){
        return  error_response(400,"Incorrect lab data");
    }
    $lab =  Laboratory::query()->where('ref',$labref)->first();
    if(empty($lab)){

        return  error_response(400,"Incorrect lab data [2]");
    }
    return $lab;
});

Route::post("/lab",function(){
    
    $labref = request()->get("lab_ref");
    if(empty($labref)){
        return  error_response(400,"Incorrect lab data");
    }
    $lab =  Laboratory::query()->where('ref',$labref)->first();
    if(empty($lab)){

        return  error_response(400,"Incorrect lab data [2]");
    }

    $data = request()->all();
    // unset($data['lab_ref']);

    $lab->update($data);
    // $lab->save();
    return $lab;

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
            $testType = TestType::query()->where("uniqid",$t)->first();
            $b['clinical']= $testType->clinicaldata;
            RegisteredSpecimen::create($b);
        }
    }
    return "ok";
 });

 Route::get("/specimen/{id}",function($id){

    // fields: measures: {"type":"freeinput","subs":[],"numericrangevalues":[],"alphanumericvalues":[],"autocompletevalues":[],"id":1718536245230,"name":"m4","unit":"u4"}

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
            $specimen['test']['meta']['fields']["measures"][]=[
                "type"=>"noop",
                "subs"=>[],
                "numericrangevalues"=>[],
                "alphanumericvalues"=>[],
                "autocompletevalues"=>[],
                "id"=>sha1($subtest->id),
                "name"=>$subtest->name,
                "unit"=>"",
                // "canremove"=>true,
                "noremarks"=>true
            ];
            $specimen['test']['meta']['fields']["measures"]=array_merge( $specimen['test']['meta']['fields']["measures"],$subtest['meta']['fields']["measures"]); 
            $lab_section= LabSection::query()->where('uniqid',$subtest['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }
        }
        if(isset($specimen['meta']['results'])){
            foreach($specimen['meta']['results'] as $r){
                if(!empty($r['isNew'])){
                    $specimen['test']['meta']['fields']["measures"][]=[
                        "type"=>"freeinput",
                        "subs"=>[],
                        "numericrangevalues"=>[],
                        "alphanumericvalues"=>[],
                        "autocompletevalues"=>[],
                        "id"=>$r['id'],
                        "name"=>$r['name'],
                        "unit"=>"",
                        "canremove"=>true
                    ]; 
                }
            }
        }
        
    }else{
        $lab_section= LabSection::query()->where('uniqid',$specimen['test']['lab_section'])->first();
        if(!empty($lab_section)){
            $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
        }

        if(isset($specimen['meta']['results'])){
            foreach($specimen['meta']['results'] as $r){
                if(!empty($r['isNew'])){
                    $specimen['test']['meta']['fields']["measures"][]=[
                        "type"=>"freeinput",
                        "subs"=>[],
                        "numericrangevalues"=>[],
                        "alphanumericvalues"=>[],
                        "autocompletevalues"=>[],
                        "id"=>$r['id'],
                        "name"=>$r['name'],
                        "unit"=>"",
                        "canremove"=>true
                    ]; 
                }
            }
        }

    }

    
    if($specimen['groupID']){
        $others= RegisteredSpecimen::query()->where('groupID',$specimen['groupID'])->whereNot("id",$specimen['id'])->get()->toArray();
        $specimen['others']=[$specimen];
        foreach($others as $other){
            $other['patient']=$specimen['patient'];
            $other['specimen']=SpecimenType::query()->where("uniqid",$other['specimen'])->first();
            $other['test']=TestType::query()->where("uniqid",$other['test'])->first()->toArray();
            $other['billing']= Bill::query()->where("specimen_id",$other['uniqid'])->first();

            $lab_section= LabSection::query()->where('uniqid',$other['test']['lab_section'])->first();
            if(!empty($lab_section)){
                $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
            }

            if($other['test']['type']=='GROUP'){
                
                $other['test']['meta']['fields']=["measures"=>[]];
                $subtests = $other['test']['meta']['subtests']; //am array
                $subtests = TestType::query()->whereIn("uniqid",$subtests)->get();
                foreach($subtests as $subtest){
                    $other['test']['meta']['fields']["measures"][]=[
                        "type"=>"noop",
                        "subs"=>[],
                        "numericrangevalues"=>[],
                        "alphanumericvalues"=>[],
                        "autocompletevalues"=>[],
                        "id"=>sha1($subtest->id),
                        "name"=>$subtest->name,
                        "unit"=>"",
                        // "canremove"=>true,
                        "noremarks"=>true
                    ];
                    $other['test']['meta']['fields']["measures"]=array_merge( $other['test']['meta']['fields']["measures"],$subtest['meta']['fields']["measures"]); 
                    $lab_section= LabSection::query()->where('uniqid',$subtest['lab_section'])->first();
                    if(!empty($lab_section)){
                        $techniques= array_unique(array_merge($techniques,$lab_section->techniques??[]));
                    }
                }




            }

       
        if(isset($other['meta']['results'])){
            foreach($other['meta']['results'] as $r){
                if(!empty($r['isNew'])){
                    $other['test']['meta']['fields']["measures"][]=[
                        "type"=>"freeinput",
                        "subs"=>[],
                        "numericrangevalues"=>[],
                        "alphanumericvalues"=>[],
                        "autocompletevalues"=>[],
                        "id"=>$r['id'],
                        "name"=>$r['name'],
                        "unit"=>"",
                        "canremove"=>true
                    ]; 
                }
            }
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
        $specimen->state="Results Available";
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
        'physicians'=>array_filter($uniquePhysicians,function($elt){return !!$elt;}),
        'preleveurs'=>array_filter($uniquePreleveurs,function($elt){return !!$elt;}),
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