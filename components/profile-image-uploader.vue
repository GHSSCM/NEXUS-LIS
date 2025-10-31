<template>
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Facility Logo</h5>
    </div>
    <div class="card-body text-center">

      <!-- Image Preview -->
      <img v-if="imageUrl || defaultPlaceholder"
        :src="imageUrl || defaultPlaceholder"
        alt="Facility Logo"
        class="img-thumbnail mb-3"
        style="max-height: 150px; object-fit: contain;"
      />

      <!-- File Input -->
      <div class="mb-3">
        <input
          type="file"
          accept="image/*"
          class="form-control"
          @change="onFileChange"
        />
      </div>

      <!-- Upload Button -->
      <button type="button"
        class="btn btn-success"
        :disabled="!rawFile"
        @click="uploadImage"
      >
        Upload
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useNuxtApp } from '#app'

const props = defineProps({
  initialImageUrl: {
    type: String,
    default: null
  }
})

const emit = defineEmits(['uploaded'])

const imageUrl = ref(props.initialImageUrl)
const rawFile = ref(null)
const defaultPlaceholder = '../assets/cropped-HBR-logo.png' // Replace with your fallback



watch(() => props.initialImageUrl, (val) => {
  imageUrl.value = val
})

function onFileChange(event) {
  const file = event.target.files[0]
  if (!file) return
  rawFile.value = file
  imageUrl.value = URL.createObjectURL(file)
}

function fileToBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader()
    reader.onload = () => resolve(reader.result)
    reader.onerror = reject
    reader.readAsDataURL(file)
  })
}

async function uploadImage() {
  if (!rawFile.value) {
    alert('Please select an image.')
    return
  }

  const base64 = await fileToBase64(rawFile.value)

 if(confirm("Are you sure you want to update the logo?")){
    postRequestLoad_(
      '/nx/upload-profile-image',
      { image: base64 },
      (resp) => {
        successToast("Saved successfully");
        // alert('Upload successful!')
        if (resp?.data?.url) {
          imageUrl.value = resp.data.url
          emit('uploaded', resp.data.url)
        }
      },
      (err) => {
        console.error(err)
        alert('Upload failed')
      }
    )
 }
}
</script>
