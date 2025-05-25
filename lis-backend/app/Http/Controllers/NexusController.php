<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NexusController extends Controller
{
    public function getAllNexusBills(Request $request)
    {

        $bills = \App\Models\NexusBill::query('facility_ref',request('facility_ref'))->get();

        $bills->map(function ($bill) {
            $bill->facility = \App\Models\Facility::where('uniqid', $bill->facility_ref)->first();
            $bill->patient = \App\Models\Patient::where('uniqid', $bill->facility_ref)->first();
            return $bill;
        });


        return response()->json($bills->filter(function ($bill) {
            return $bill->facility && $bill->patient;
        }));

    }

    

    public function getAllNexusBillServices(Request $request)
    {
        $services = \App\Models\NexusBillService::all()->toArray();

        $defaultServices =[];

        $allowedServices = getAllowedServices();
        foreach($allowedServices as $sv){
            if($sv['code']=='nexus.lab'){
                array_push($defaultServices, [
                    "uniqid"=>null,
                    "name"=>"Laboratory Test Payments",
                    "description"=>"Laboratory test payments",
                    "unit_price"=>null,
                    "quantifiable"=>false,
                    "quantity_unit"=>null,
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                ]);
            }
            if($sv['code']=='nexus.bloodbank'){
                array_push($defaultServices, [
                    "uniqid"=>null,
                    "name"=>"Blood Transfusion Payments",
                    "description"=>"Blood Transfusion Payments",
                    "unit_price"=>null,
                    "quantifiable"=>true,
                    "quantity_unit"=>"litres",
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                ]);
            }
            if($sv['code']=='nexus.pharmacy'){
                array_push($defaultServices, [
                    "uniqid"=>null,
                    "name"=>"Pharmacy Payments",
                    "description"=>"Payments for medications and drugs",
                    "unit_price"=>null,
                    "quantifiable"=>true,
                    "quantity_unit"=>null,
                    "state"=>'ACTIVE',
                    'noaction'=>true,
                ]);
            }
        }
        $services = array_merge($services,$defaultServices);
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
    public function getAllNexusBillConstituents(Request $request)
    {
        $constituents = \App\Models\NexusBillConstituent::all();
        return response()->json($constituents);
    }


}
