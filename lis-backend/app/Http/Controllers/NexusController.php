<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NexusBill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NexusController extends Controller
{

    public function getNexusBillingStats(){
        $facilityRef = request('facility_ref');

        // Total sum
        $totalAmount = NexusBill::where('facility_ref', $facilityRef)->where('status','PAID')->sum('amount');

        // Total count
        $totalCount = NexusBill::where('facility_ref', $facilityRef)->where('status','PAID')->count();

        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $monthData = NexusBill::selectRaw('
                SUM(amount) as total_amount,
                COUNT(*) as total_count
            ')
            ->where('facility_ref', $facilityRef)
            ->where('status','PAID')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        return [
            "total_amount" => $totalAmount,
            "total_count" => $totalCount,
            "monthly_data" => [
                "total_amount" => $monthData->total_amount ?? 0,
                "total_count" => $monthData->total_count ?? 0,
            ]
        ];
    }



    public function getNexusPharmacyStats(){
        $facilityRef = request('facility_ref');

        // Total sum
        $totalAmount = NexusBill::where('facility_ref', $facilityRef)->where('status','PAID')->where('type','PRESCRIPTION')->sum('amount');

        // Total count
        $totalCount = NexusBill::where('facility_ref', $facilityRef)->where('status','PAID')->where('type','PRESCRIPTION')->count();

        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $monthData = NexusBill::selectRaw('
                SUM(amount) as total_amount,
                COUNT(*) as total_count
            ')
            ->where('facility_ref', $facilityRef)
            ->where('status','PAID')
            ->where('type','PRESCRIPTION')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->first();

        return [
            "total_amount" => $totalAmount,
            "total_count" => $totalCount,
            "monthly_data" => [
                "total_amount" => $monthData->total_amount ?? 0,
                "total_count" => $monthData->total_count ?? 0,
            ]
        ];
    }


    public function getAllNexusBills(Request $request)
    {

        $bills = \App\Models\NexusBill::query()->where('facility_ref',request('facility_ref'))->get();

        $bills->map(function ($bill) {
            $bill->facility = \App\Models\Facility::where('uniqid', $bill->facility_ref)->first();
            $bill->patient = \App\Models\Patient::where('uniqid', $bill->patient_ref)->first();
            $bill->total =  $bill->amount - $bill->reduction;
            return $bill;
        })->filter(function ($bill) {
            return $bill->facility && $bill->patient;
        });

        return response()->json([
            "data" => $bills,
            "columns" => [
                [
                    "label" => "ID",
                    "attribute" => "id",
                ],
                [
                    "label" => "Patient",
                    "attribute" => "patient.name",
                ],
                [
                    "label" => "Subtotal",
                    "attribute" => "amount",
                ],
                [
                    "label" => "Reduction",
                    "attribute" => "reduction",
                ],
                [
                    "label" => "Total",
                    "attribute" => "total",
                ],
                [
                    "label" => "Status",
                    "attribute" => "status",
                ],
                [
                    "label" => "Action",
                    "attribute" => "action",
                    "type" => "action",
                    "buttons" => [
                        [
                            "label" => "View Bill",
                            "route" => "/nexus.billing/bill/:uniqid?ro=true"
                        ],

                        [
                            "label" => "Edit Bill",
                            "route" => "/nexus.billing/bill/:uniqid"
                        ]
                    ]
                ]
            ]
        ]);

    }



    public function getAllNexusPrescriptions(Request $request)
    {

        $bills = \App\Models\NexusBill::query()->where('facility_ref',request('facility_ref'))->where('type','PRESCRIPTION')->get();

        $bills->map(function ($bill) {
            $bill->facility = \App\Models\Facility::where('uniqid', $bill->facility_ref)->first();
            $bill->patient = \App\Models\Patient::where('uniqid', $bill->patient_ref)->first();
            $bill->total =  $bill->amount - $bill->reduction;

            $prescriptions = \App\Models\NexusBillConstituent::where('nexus_bill_ref', $bill->uniqid)
                // ->where('nexus_bill_service_ref', 'nexus.pharmacy')
                ->get();

            $html="";

            foreach($prescriptions as $prescription){
                $html.="<span><div class='badge bg-primary me-1'>".$prescription->name.".</div> ".$prescription->description."</span><br/>";
            }
            $bill->prescriptions = $html;
            return $bill;
        })->filter(function ($bill) {
            return $bill->facility && $bill->patient;
        });

        return response()->json([
            "data" => $bills,
            "columns" => [
                [
                    "label" => "ID",
                    "attribute" => "id",
                ],
                [
                    "label" => "Patient",
                    "attribute" => "patient.name",
                ],
                [
                    "label" => "Prescriptions",
                    "attribute" => "prescriptions",
                    "type" => "html",
                ],
                // [
                //     "label" => "Subtotal",
                //     "attribute" => "amount",
                // ],
                // [
                //     "label" => "Reduction",
                //     "attribute" => "reduction",
                // ],
                [
                    "label" => "Total",
                    "attribute" => "total",
                ],
                [
                    "label" => "Status",
                    "attribute" => "status",
                ],
                [
                    "label" => "Action",
                    "attribute" => "action",
                    "type" => "action",
                    "buttons" => [
                        [
                            "label" => "View Prescription",
                            "route" => "/nexus.pharmacy/prescription/:uniqid?ro=true"
                        ],

                        [
                            "label" => "Edit Prescription",
                            "route" => "/nexus.pharmacy/prescription/:uniqid"
                        ]
                    ]
                ]
            ]
        ]);

    }


    
    private function getAllNexusBillServicesArray(){
   $services = \App\Models\NexusBillService::query()->where('facility_ref',request('facility_ref'))->where('state','ACTIVE')->get()->toArray();

        $defaultServices =[];

        $allowedServices = getAllowedServices();
        foreach($allowedServices as $sv){
            if($sv['code']=='nexus.lab'){
                array_push($defaultServices, [
                    "name"=>"Laboratory Test",
                    "description"=>"Laboratory test payments",
                    "unit_price"=>null,
                    "quantifiable"=>false,
                    "quantity_unit"=>null,
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                    'has_more_selection'=>true, //for the billing section to see if second dropdown will show
                    'uniqid'=>'nexus.lab',
                ]);
            }
            if($sv['code']=='nexus.bloodbank'){
                array_push($defaultServices, [
                    "name"=>"Blood Transfusion",
                    "description"=>"Blood Transfusion Payments",
                    "unit_price"=>null,
                    "quantifiable"=>true,
                    "quantity_unit"=>"litres",
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                    'has_more_selection'=>false, //for the billing section to see if second dropdown will show
                    'uniqid'=>'nexus.bloodbank',
                ]);
            }
            if($sv['code']=='nexus.pharmacy'){
                array_push($defaultServices, [
                    "name"=>"Pharmacy",
                    "description"=>"Payments for medications and drugs",
                    "unit_price"=>null,
                    "quantifiable"=>true,
                    "quantity_unit"=>null,
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                    'has_more_selection'=>true, //for the billing section to see if second dropdown will show
                    'uniqid'=>'nexus.pharmacy',
                ]);
            }
        }
        $services = array_merge($services,$defaultServices);
        return $services;
    }

    public function getAllNexusBillServices(Request $request)
    {
        $services = $this->getAllNexusBillServicesArray();
        return response()->json([
            "data"=>$services,
            "columns"=>[
                

                [
                    "label"=>"",
                  
                ],
                // [
                //     "label"=>"Ref",
                //     "attribute"=>"uniqid",
                // ],

                [
                    "label"=>"Name",
                    "attribute"=>"name"
                ],

                [
                    "label"=>"Description",
                    "attribute"=>"description"
                ],

                [
                    "label"=>"Unit Price",
                    "attribute"=>"unit_price",
                ],
                [
                    "label"=>"Quantifiable",
                    "attribute"=>"quantifiable",
                    "type"=>"boolean",
                ],
                [
                    "label"=>"Unit",
                    "attribute"=>"quantity_unit"
                ],
                [
                    "label"=>"State",
                    "attribute"=>"state"
                ],
                [
                    "label"=>"Action",
                    "attribute"=>"action",
                    "type"=>"action",
                    "buttons"=>[
                        [
                            "label"=>"Edit",
                            "route"=>"/nexus.billing/service/:uniqid"
                        ],
                        [
                            "label"=>"Delete",
                            "call"=>"/nx/nexus-bill-services/:uniqid/delete",
                            "ask"=>true,
                            "class"=>"btn btn-danger btn-sm me-2"
                        ]
                    ]
                ]
            ]
        
            
        ]);
    }

    public function deleteNexusBillService($uniqid){
    
        $service = \App\Models\NexusBillService::where('uniqid', $uniqid)->first();
        if ($service) {
            $service->delete();
            return response()->json(['message' => 'Service deleted successfully']);
        } else {
            return error_response(404,'Service not found');
        }
    }

    public function deleteDrugs($uniqid){
    
        $service = \App\Models\Drug::where('uniqid', $uniqid)->first();
        if ($service) {
            $service->delete();
            return response()->json(['message' => 'Drug deleted successfully']);
        } else {
            return error_response(404,'Drug not found');
        }
    }
    

    public function getNexusBillService($uniqid)
    {
        $service = \App\Models\NexusBillService::where('uniqid', $uniqid)->first();
        if ($service) {
            return response()->json($service);
        } else {
            return error_response(404,'Service not found');
        }
    }
    public function createNexusBillService(Request $request)
    {
        $service = \App\Models\NexusBillService::create($request->all());
        return response()->json($service);
    }
    public function updateNexusBillService(Request $request, $uniqid)
    {
        $service = \App\Models\NexusBillService::where('uniqid', $uniqid)->first();
        if ($service) {
            $service->update($request->all());
            return response()->json($service);
        } else {
            return error_response(404,'Service not found');
        }
    }




    public function getNexusBillCreationData(){
        $services = $this->getAllNexusBillServicesArray();

        switch(request('type')){
            // case 'nexus.lab':
            //     $services = array_filter($services, function($service) {
            //         return $service['uniqid'] == 'nexus.lab';
            //     });
            //     break;
            case 'PRESCRIPTION':
                $services = array_values(array_filter($services, function($service) {
                    return $service['uniqid'] == 'nexus.pharmacy';
                }));
                break;
            // case 'nexus.bloodbank':
            //     $services = array_filter($services, function($service) {
            //         return $service['uniqid'] == 'nexus.bloodbank';
            //     });
            //     break;
        }
        $patient=null;

        $constituents=null;
        $bill=null;
        if(request('pageId') && request('pageId')!='create'){
            $constituents = \App\Models\NexusBillConstituent::where('nexus_bill_ref', request('pageId'))->get();
            $bill = \App\Models\NexusBill::where('uniqid', request('pageId'))->first();
        }

        if(request('patientId')|| $bill){
            $patient = \App\Models\Patient::where('uniqid', request('patientId',$bill?$bill->patient_ref:null))->first();
        }

        return [
            "services"=>$services,
            "patient"=>$patient,
            "bill_constituents"=>$constituents,
            "bill"=>$bill
        ];
    }
    public function getNexusBillCreationDataSubItems($uniqid,$patientUId){
    
        switch($uniqid){
            case 'nexus.lab':
                 $tests=\App\Models\RegisteredSpecimen::query()
                    ->where('patient', $patientUId)
                    ->get()
                    ->map(function ($registeredSpecimen) use($uniqid) {
                        $specimen=\App\Models\SpecimenType::query()->where("uniqid",$registeredSpecimen['specimen'])->first();
                        $test=\App\Models\TestType::query()->where("uniqid",$registeredSpecimen['test'])->first();

                        return [
                            'name' => "#$registeredSpecimen->id: {$test->name}, {$specimen->name}".($registeredSpecimen->receptiondate?" | Received: {$registeredSpecimen->receptiondate} {$registeredSpecimen->receptiontime}":""),
                            'subname' => "Laboratory",
                            'nexus_bill_service_ref' => $registeredSpecimen->uniqid,
                            'quantity'=> 1,
                            'unit_price' => $test->cost,
                            'subtotal' => $test->cost,
                            'total' => $test->cost,
                            'reduction' => 0,
                            'reduction_rate' => "flat",
                            "quantifiable"=>false,
                            "parent"=>$uniqid,
                            "quantity_unit"=>null,
                        ];
                    });
                return response()->json($tests);
            case 'nexus.pharmacy':
                
                 $drugs=\App\Models\Drug::query()
                    ->where('facility_ref', request('facility_ref'))
                    ->where('state', 'ACTIVE')
                    ->get()
                    ->map(function ($drug) use($uniqid) {
                       
                        return [
                            'name' => $drug->name,
                            'subname' => "Pharmacy",
                            'nexus_bill_service_ref' => $drug->uniqid,
                            'quantity'=> 1,
                            'unit_price' => $drug->unit_price,
                            'subtotal' => $drug->unit_price,
                            'total' => $drug->unit_price,
                            'reduction' => 0,
                            'reduction_rate' => "flat",
                            "quantifiable"=>true,
                            "parent"=>$uniqid,
                            "quantity_unit"=>$drug->unit,
                        ];
                    });
                return response()->json($drugs);

            default:
                return [];
        }
    }
    public function getAllNexusBillConstituents(Request $request)
    {
        $constituents = \App\Models\NexusBillConstituent::all();
        return response()->json($constituents);
    }

    public function createNexusBill(){
        $billRequest= request()->input('bill');

        $billRequest['facility_ref'] = request('facility_ref');
        
        $createdBill = \App\Models\NexusBill::create($billRequest);

        $consituents =  request()->input('constituents',[]);
        foreach($consituents as $const){
            $const['nexus_bill_ref'] = $createdBill->uniqid;
            \App\Models\NexusBillConstituent::create($const);
        }

        return response()->json([
            "message" => "Bill created successfully",
            "bill" => $createdBill
        ]);

    }

    public function editNexusBill($billUId){
        $billRequest= request()->input('bill');

        $billRequest['facility_ref'] = request('facility_ref');

        $bill= \App\Models\NexusBill::where('uniqid', $billUId)->first();
        if(!$bill){
            return error_response(404,'Bill not found');
        }

        $bill->update($billRequest);


        
        \App\Models\NexusBillConstituent::where('nexus_bill_ref', $billUId)->delete();

        $consituents =  request()->input('constituents',[]);
        foreach($consituents as $const){
            $const['nexus_bill_ref'] = $bill->uniqid;
            \App\Models\NexusBillConstituent::create($const);
        }

        return response()->json([
            "message" => "Bill updated successfully",
            "bill" => $bill
        ]);

    }



    public function getAllDrugs(){
        
        $drugs = \App\Models\Drug::query()
            ->where('facility_ref', request('facility_ref'))
            ->where('state', 'ACTIVE')
            ->get();

        
        return response()->json([
            "data" => $drugs,
            "columns" => [
                [
                    "label" => "ID",
                    "attribute" => "id",
                ],
                [
                    "label" => "Name",
                    "attribute" => "name",
                ],
                [
                    "label" => "Code",
                    "attribute" => "code",
                ],
                [
                    "label" => "Type",
                    "attribute" => "type",
                ],
                [
                    "label" => "Quantity",
                    "attribute" => "quantity",
                ],
                [
                    "label" => "Unit",
                    "attribute" => "unit",
                ],
                [
                    "label" => "Unit Price",
                    "attribute" => "unit_price",
                    "type" => "currency",
                ],
                [
                    "label" => "State",
                    "attribute" => "state",
                ],
                [
                    "label" => "Action",
                    "attribute" => "action",
                    "type" => "action",
                    "buttons" => [
                        [
                            "label" => "Edit Drug",
                            "route" => "/nexus.pharmacy/drug/:uniqid"
                        ],
                        [
                            "label" => "Delete Drug",
                            "call" => "/nx/drugs/:uniqid/delete",
                            "ask"=>true,
                            'class'=>'btn btn-danger btn-sm me-2'
                        ]
                    ]
                ]
            ]
        ]);

    }

}
