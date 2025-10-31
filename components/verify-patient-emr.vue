<template>
  <div class="card shadow-sm mb-3 p-3">
    <div class="text-black fw-bold">
      {{linkedPatient?"Patient Online EMR":"Link Patient with EMR Code"}}
    </div>

    <div class="card-body p-0 pt-2">
      <!-- Already Linked Info -->
      <div v-if="linkedPatient" class="alert alert-primary d-flex justify-content-between align-items-center">
        <div>
          <strong>Linked to EMR:</strong><br />
          Name: {{ linkedPatient.full_name }}<br />
          Phone: {{ linkedPatient.phone }}<br />
          Gender: {{ linkedPatient.gender }}<br />
          DOB: {{ linkedPatient.dob }}<br />
          <small class="text-muted">SYSTEM ID: {{ linkedPatient.user_id }}</small>
        </div>
        <button class="btn btn-sm btn-outline-danger" @click="unlinkPatient">
          Unlink
        </button>
      </div>

      <!-- Input to verify patient code -->
      <div class="mb-3" v-if="!linkedPatient">
        <label for="codeInput" class="form-label">Patient Code (idCode)</label>
        <input
          v-model="code"
          id="codeInput"
          type="text"
          class="form-control"
          placeholder="Enter patient code"
          :disabled="!!linkedPatient"
        />
      </div>

      <!-- Verify Button -->
      <button
        v-if="!linkedPatient"
        class="btn btn-primary"
        :disabled="loading || !code"
        @click="verifyCode"
      >
        {{ loading ? 'Verifying...' : 'Verify Patient' }}
      </button>

      <!-- Verification Error -->
      <div v-if="error" class="mt-2 text-danger">
        {{ error }}
      </div>

      <!-- Verified EMR Patient Details -->
      <div v-if="patient" class="alert alert-primary mt-3">
        <strong>Patient EMR Details:</strong><br />
        Name: {{ patient.full_name }}<br />
        Phone: {{ patient.phone }}<br />
        Gender: {{ patient.gender }}<br />
        DOB: {{ patient.dob }}<br />
        <small class="text-muted">SYSTEM ID: {{ patient.user_id }}</small><br />

        <!-- Link Button -->
        <button class="btn btn-success btn-sm mt-2" @click="linkPatient">
          Link to HIS
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  userId: {
    type: String,
    required: true
  },
  linkedPatient: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['linked', 'unlinked'])

const code = ref("")
const patient = ref(null)
const error = ref("")
const loading = ref(false)

const verifyCode = () => {
  error.value = ""
  patient.value = null
  loading.value = true

  getRequest_(
    '/emr/verify-patient',
    { code: code.value },
    (res) => {
      if (res.verified) {
        patient.value = res.patient
      } else {
        error.value = "Patient not found."
      }
    },
    (err) => {
      error.value = "Error verifying patient."
      console.error(err)
    },
    () => {
      loading.value = false
    }
  )
}

const linkPatient = () => {
  if (!patient.value || !props.userId) return

  postRequest_(
    '/emr/link-patient',
    {
      user_id: props.userId,
      patient: patient.value
    },
    (res) => {
      emit('linked', patient.value)
      code.value = ""
      patient.value = null
    },
    (err) => {
      error.value = "Linking failed."
      console.error(err)
    }
  )
}

const unlinkPatient = () => {
  if (!props.userId) return

  if (!confirm("Are you sure you want to unlink this patient from EMR?")) return

  postRequest_(
    '/emr/unlink-patient',
    {
      user_id: props.userId
    },
    () => {
      emit('unlinked')
    },
    (err) => {
      error.value = "Unlinking failed."
      console.error(err)
    }
  )
}
</script>
