<script setup>
import { ref } from 'vue'
import { useAiStore } from '@/stores/aiStore' 
import { useToastStore } from '@/stores/toastStore' 
import cornIcon from '@/assets/images/ai/corn.png'
import uploadIcon from '@/assets/images/ai/camera.png'
import robotIcon from '@/assets/images/ai/ai-icon.png'
import targetIcon from '@/assets/images/about/mision.png'

const aiStore = useAiStore()
const toastStore = useToastStore()
const diseaseInfo = {
  'Blight': {
    name: 'Hawar Daun',
    treatment: '1. Gunakan fungisida berbahan aktif mankozeb atau azoksistrobin.\n2. Potong dan musnahkan daun yang terinfeksi agar spora tidak menyebar ke tanaman lain.\n3. Atur jarak tanam agar sirkulasi udara lebih baik dan kelembapan berkurang.'
  },
  'Common Rust': {
    name: 'Karat Daun',
    treatment: '1. Semprotkan fungisida sistemik berbahan aktif difenokonazol.\n2. Hindari pengairan dengan metode percik (sprinkler) berlebihan yang membasahi permukaan daun.\n3. Bersihkan gulma di sekitar lahan agar tidak menjadi inang penyakit.'
  },
  'Gray Leaf Spot': {
    name: 'Bercak Daun Abu-abu',
    treatment: '1. Aplikasikan fungisida berbahan aktif piraklostrobin atau propikonazol.\n2. Lakukan rotasi tanaman pada musim tanam berikutnya untuk memutus siklus hidup jamur.\n3. Bersihkan dan bakar sisa-sisa tanaman jagung setelah panen sebelumnya.'
  },
  'Healthy': {
    name: 'Sehat',
    treatment: 'Luar biasa! Pertahankan perawatan lahan yang sudah sangat baik ini. Tetap pastikan asupan pupuk (NPK) seimbang, pengairan cukup, dan lakukan pengecekan rutin untuk pencegahan hama dini.'
  }
}

const selectedImage = ref(null)
const imagePreviewUrl = ref(null)
const selectedModel = ref('efficientnet')
const isDragging = ref(false)

const handleFileSelect = (event) => {
  const file = event.target.files[0]
  if (file) processFile(file)
}

const handleDrop = (event) => {
  isDragging.value = false
  const file = event.dataTransfer.files[0]
  if (file && file.type.startsWith('image/')) processFile(file)
}

const processFile = (file) => {
  selectedImage.value = file
  imagePreviewUrl.value = URL.createObjectURL(file)
  aiStore.clearResults() 
}

const removeImage = () => {
  selectedImage.value = null
  imagePreviewUrl.value = null
  aiStore.clearResults()
}

const analyzeImage = async () => {
  if (!selectedImage.value) return

  const success = await aiStore.predictCornDisease(selectedImage.value, selectedModel.value)
  
  if (!success && aiStore.error) {
    toastStore.showToast(aiStore.error) 
  }
}
</script>

<template>
  <div class="ai-page-wrapper">
    <div class="ai-header animate-fade-up">
      <h1>
        <img :src="cornIcon" class="title-icon">
        AI Penyakit Daun Jagung
      </h1>
      <p>Unggah foto daun jagung Anda, dan kecerdasan buatan kami akan mendeteksi apakah tanaman tersebut sehat atau terjangkit penyakit.</p>
    </div>

    <div class="ai-card animate-fade-up" style="animation-delay: 0.1s;">
      
      <div v-if="!imagePreviewUrl" 
           class="upload-zone" 
           :class="{ 'drag-active': isDragging }"
           @dragover.prevent="isDragging = true"
           @dragleave.prevent="isDragging = false"
           @drop.prevent="handleDrop"
           @click="$refs.fileInput.click()">
        
        <img :src="uploadIcon" class="upload-icon">
        <p class="upload-text">Klik untuk unggah atau seret gambar ke sini</p>
        <p class="upload-subtext">Format yang didukung: JPG, PNG, JPEG</p>
        <input type="file" ref="fileInput" @change="handleFileSelect" accept="image/jpeg, image/png, image/jpg" class="hidden-input">
      </div>

      <div v-else class="preview-container">
        <img :src="imagePreviewUrl" alt="Preview Daun Jagung" class="preview-image" />
        <button @click="removeImage" class="btn-remove-image" title="Hapus Gambar">×</button>
      </div>

      <div class="form-group">
        <label>Pilih Model Kecerdasan Buatan (AI):</label>
        <select v-model="selectedModel" class="model-select">
          <option value="efficientnet">EfficientNet (Akurasi Tinggi, Lebih Cepat)</option>
          <option value="resnet">ResNet (Analisis Mendalam)</option>
        </select>
      </div>

      <button @click="analyzeImage" :disabled="!selectedImage || aiStore.isLoading" class="btn-predict">
        <span v-if="aiStore.isLoading" class="btn-content-loading">
          <span class="spinner-icon"></span> AI Sedang Menganalisis...
        </span>
        <span v-else>Deteksi Penyakit</span>
      </button>

      <div v-if="aiStore.predictionResult" 
           class="result-box animate-fade-up" 
           :class="aiStore.predictionResult === 'Healthy' ? 'result-healthy' : 'result-sick'">
        
        <h3 class="result-label">Hasil Diagnosis AI:</h3>
        
        <p class="result-disease">
          {{ diseaseInfo[aiStore.predictionResult].name }} 
          <span class="original-name">/ {{ aiStore.predictionResult }}</span>
        </p>
        
        <div class="ai-stats-row">
          <span class="stat-badge"><img :src="robotIcon" class="stat-icon"> Model:{{ selectedModel === 'efficientnet' ? 'EfficientNet' : 'ResNet' }}</span>
          <span class="stat-badge"> <img :src="targetIcon" class="stat-icon"> Keyakinan AI: {{ aiStore.confidenceScore }} </span>
        </div>
        
        <div class="treatment-box">
          <h4>Rekomendasi & Cara Penanganan:</h4>
          <p class="treatment-text">{{ diseaseInfo[aiStore.predictionResult].treatment }}</p>
        </div>

      </div>

    </div>
  </div>
</template>

<style scoped src="@/assets/styles/views/ai/AIPrediksiJagung.css"></style>