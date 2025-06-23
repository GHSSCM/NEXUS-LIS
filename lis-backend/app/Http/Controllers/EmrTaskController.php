<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\EmrTask;
use Illuminate\Http\Client\Request;

class EmrTaskController extends Controller
{

    public function verifyPatient()
{
    $emrUrl = getEmrAddress() . '/emr/verify-patient';

    $request = request();
    $request->validate([
        'code' => 'required|string',
    ]);

    $code = $request->input('code');

    try {
        $response = Http::timeout(5)->post($emrUrl, ['idCode' => $code]);

        if ($response->successful()) {
            return response()->json([
                'verified' => true,
                'patient' => $response->json()['data'] ?? null,
            ]);
        }

        return error_response(404,"Not found");
    
    } catch (\Throwable $e) {
        return error_response(500,$e->getMessage());
     
    }
}



   public function processPending()
{

    $tasks = EmrTask::whereIn('status', ['pending', 'failed'])
                    ->orderBy('created_at')
                    ->limit(5)
                    ->get();

                    // dd(EmrTask::all()->toArray());
    $connected = true;
    $processed = 0;

    
    $serverAdd = getEmrAddress();
    
    foreach ($tasks as $task) {
        try {
            $payload = array_merge([
                'patient_id' => $task->patient_id,
                'offlineID' => $task->payload['offlineID'] ?? null,
            ], ['data' => $task->payload]);
            if(!isset($payload['data']['images'])){
                $payload['data']['images']=[];
            }
            
            $response = Http::post($serverAdd .$task->endpoint_url, $payload);

            if ($response->successful()) {
                $task->status = 'completed';
                $task->executed_at = now();
                $task->save();
                $processed++;
            } else {
                throw new \Exception($response->body());
            }

        } catch (\Throwable $e) {
            $task->attempts += 1;
            $task->status = 'failed';
            $task->error_message = $e->getMessage();
            $task->save();

            // Only flag as disconnected on connection failure (e.g., timeout, unreachable)
            if ($e instanceof \Illuminate\Http\Client\ConnectionException) {
                $connected = false;
                break; // no need to continue if server is unreachable
            }
        }
        // dd($payload);
    }

    return response()->json([
        'message' => 'EMR task sync attempted.',
        'connected' => $connected,
        'tasks_processed' => $processed,
        'host'=>$serverAdd ,
        'u'=>getCurrentUserId()
    ]);
}


    public function queueTask(Request $request)
    {
        $validated = $request->validate([
            'collection' => 'required|string',
            'operation' => 'required|in:create,edit,delete',
            'patient_id' => 'required|string',
            'object_id' => 'nullable|string',
            'payload' => 'required|array',
        ]);

        $endpoint = match($validated['operation']) {
            'create' => "/emr/{$validated['collection']}/add",
            'edit' => "/emr/{$validated['collection']}/edit",
            'delete' => "/emr/{$validated['collection']}/delete",
        };



        EmrTask::create([
            'uniqid' => \Illuminate\Support\Str::uuid(),
            'collection' => $validated['collection'],
            'operation' => $validated['operation'],
            'patient_id' => $validated['patient_id'],
            'object_id' => $validated['object_id'],
            'payload' => $validated['payload'],
            'endpoint_url' => $endpoint,
        ]);

        return response()->json(['message' => 'Task queued']);
    }



        public function linkPatient()
    {
        $request = request();

        $request->validate([
            'user_id' => 'required|exists:patients,id',
            'patient' => 'required|array',
            'patient.user_id' => 'required|string', // EMR ID
        ]);

        $user = \App\Models\Patient::findOrFail($request->user_id);

        $meta = $user->meta ?? [];
        $meta['linked_emr_patient'] = $request->patient;

        $user->meta = $meta;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Patient successfully linked to EMR.',
            'linked_patient' => $request->patient,
        ]);
    }

    public function unlinkPatient()
    {

        $request = request();

        $request->validate([
            'user_id' => 'required|exists:patients,id',
        ]);

        $user = \App\Models\Patient::findOrFail($request->user_id);
        $meta = $user->meta ?? [];

        unset($meta['linked_emr_patient']);

        $user->meta = $meta;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'EMR linkage removed.',
        ]);
    }
}
