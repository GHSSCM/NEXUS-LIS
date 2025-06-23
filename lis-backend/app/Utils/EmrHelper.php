<?php

namespace App\Utils;

use App\Models\EmrTask;
use Illuminate\Support\Str;

class EmrHelper
{
    public static function queueEmrTask(string $collection, string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
  

        $endpoint = match ($operation) {
            'create' => "/emr/{$collection}/add",
            'edit'   => "/emr/{$collection}/edit",
            'delete' => "/emr/{$collection}/delete",
            default  => throw new \InvalidArgumentException("[TKC] Invalid operation: $operation")
        };

        return EmrTask::create([
            'uuid'         => Str::uuid(),
            'collection'   => $collection,
            'operation'    => $operation,
            'patient_id'   => $patientId,
            'offlineID'    => $payload['offlineID'] ?? null,
            'payload'      => $payload,
            'endpoint_url' => $endpoint,
            'facility_ref' => getFacilityRef(),
            'status'       => 'pending',
            'meta'=>$meta??['a'=>'n']
        ]);
    }

    public static function queueMedicalHistoryTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('medical_history', $operation, $patientId, $payload,$meta);
    }

    public static function queuePrescriptionTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('prescriptions', $operation, $patientId, $payload,$meta);
    }

    public static function queueDiagnosticTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('diagnostics', $operation, $patientId, $payload,$meta);
    }

    public static function queueAllergyTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('allergies', $operation, $patientId, $payload, $meta);
    }

    public static function queueImmunizationTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('immunizations', $operation, $patientId, $payload, $meta);
    }

    public static function queueTransfusionTask(string $operation, string $patientId, array $payload, ?array $meta=[]): EmrTask
    {
        return self::queueEmrTask('transfusions', $operation, $patientId, $payload,$meta);
    }
}


// MEDICAL HISTORY
// Example usage:
// // Create
// EmrHelper::queueMedicalHistoryTask('create', $patientId, [
//     'name' => 'Hypertension',
//     'startDate' => now()->subMonths(6),
//     'endDate' => now(),
//     'healthFacility' => 'City Clinic',
//     'severity' => 'High',
//     'doctorName' => 'Dr. Ngu',
//     'description' => 'Patient diagnosed with stage 2 hypertension',
                    // 'offlineID' => $bill->uniqid
// ]);

// // Edit
// EmrHelper::queueMedicalHistoryTask('edit', $patientId, [
//     'severity' => 'Moderate',
//     'description' => 'Condition improving with medication',
                    // 'offlineID' => $bill->uniqid
// ], $objectId);

// // Delete
// EmrHelper::queueMedicalHistoryTask('delete', $patientId, [], $objectId);


// PRESCRIPTIONS
// Example usage:
// Create
// EmrHelper::queuePrescriptionTask('create', $patientId, [
//     'doctor_name' => 'Dr. Fote',
//     'pharmacy' => 'Central Pharmacy',
//     'medications_prescribed' => 'Amoxicillin 500mg',
//     'date' => now()->toDateTimeString(),,
                    // 'offlineID' => $bill->uniqid
//     'cost' => 2000
// ]);

// // Edit
// EmrHelper::queuePrescriptionTask('edit', $patientId, [
//     'cost' => 2500,
                    // 'offlineID' => $bill->uniqid
// ], $objectId);

// // Delete
// EmrHelper::queuePrescriptionTask('delete', $patientId, [], $objectId);


// DIAGNOSTICS
// Example usage:
// Create
// EmrHelper::queueDiagnosticTask('create', $patientId, [
//     'type' => 'Blood Test',
//     'date' => now()->toDateTimeString(),
//     'referring_doctor' => 'Dr. Yao',
//     'facility' => 'LabTech',
//     'diagnosis' => 'Malaria positive',,
                    // 'offlineID' => $bill->uniqid
//     'cost' => 4000
// ]);

// // Edit
// EmrHelper::queueDiagnosticTask('edit', $patientId, [
//     'diagnosis' => 'Malaria with anemia',
                    // 'offlineID' => $bill->uniqid
// ], $objectId);

// // Delete
// EmrHelper::queueDiagnosticTask('delete', $patientId, [], $objectId);,
                    // 'offlineID' => $bill->uniqid


// ALLERGIES
// Example usage:

// // Create
// EmrHelper::queueAllergyTask('create', $patientId, [
//     'name' => 'Peanuts',
//     'allergy_type' => 'Food',,
                    // 'offlineID' => $bill->uniqid
//     'reaction' => 'Swelling, difficulty breathing',
//     'severity' => 'Severe',
//     'date' => now()->subYear()
// ]);

// // Edit
// EmrHelper::queueAllergyTask('edit', $patientId, [
//     'severity' => 'Moderate'
// ], $objectId);

// // Delete
// EmrHelper::queueAllergyTask('delete', $patientId, [], $objectId);,
                    // 'offlineID' => $bill->uniqid



// IMMUNIZATIONS
// Example usage:
// Create
// EmrHelper::queueImmunizationTask('create', $patientId, [
//     'vaccin_name' => 'Hepatitis B',
//     'date_taken' => now()->subMonths(1),
//     'next_scheduled_date' => now()->addMonths(11),
//     'is_completion_dose' => false,
//     'facility_name' => 'District Hospital'
// ]);

// // Edit
// EmrHelper::queueImmunizationTask('edit', $patientId, [
//     'is_completion_dose' => true,
                    // 'offlineID' => $bill->uniqid
// ], $objectId);

// // Delete
// EmrHelper::queueImmunizationTask('delete', $patientId, [], $objectId);,
                    // 'offlineID' => $bill->uniqid


// TRANSFUSIONS
// Example usage:

// Create
// EmrHelper::queueTransfusionTask('create', $patientId, [
//     'type' => 'Blood',
//     'qty' => '500ml',
//     'facility' => 'CHU',,
                    // 'offlineID' => $bill->uniqid
//     'date' => now()->toDateTimeString(),
//     'group' => 'O+',
//     'cost' => 12000
// ]);

// // Edit
// EmrHelper::queueTransfusionTask('edit', $patientId, [
//     'cost' => 13500,
                    // 'offlineID' => $bill->uniqid
// ], $objectId);

// // Delete
// EmrHelper::queueTransfusionTask('delete', $patientId, [], $objectId);,
                    // 'offlineID' => $bill->uniqid



