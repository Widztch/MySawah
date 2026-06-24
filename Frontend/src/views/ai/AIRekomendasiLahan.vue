<script setup>
import { ref, onMounted } from 'vue'
import { useAiStore } from '@/stores/aiStore' 
import { useToastStore } from '@/stores/toastStore' 

import landIcon from '@/assets/images/ai/ground.png'
import robotIcon from '@/assets/images/ai/ai-icon.png'

const aiStore = useAiStore()
const toastStore = useToastStore()

const nValue = ref('')
const pValue = ref('')
const kValue = ref('')
const temperature = ref('')
const humidity = ref('')
const phValue = ref('')
const rainfall = ref('')

const aiExplanation = ref('')

onMounted(() => {
  aiStore.clearResults()
})

const analyzeSoil = async () => {
  if (!nValue.value || !pValue.value || !kValue.value || !temperature.value || !humidity.value || !phValue.value || !rainfall.value) {
    toastStore.showToast("Mohon isi seluruh data parameter lahan terlebih dahulu.", "error")
    return
  }

  aiExplanation.value = ''

  // Proses berjalan, aiStore.isLoading otomatis true dari dalam store
  const success = await aiStore.predictCropRecommendation(
    parseFloat(nValue.value),
    parseFloat(pValue.value),
    parseFloat(kValue.value),
    parseFloat(temperature.value),
    parseFloat(humidity.value),
    parseFloat(phValue.value),
    parseFloat(rainfall.value)
  )

  if (success && aiStore.predictionResult) {
    const crop = String(aiStore.predictionResult).toUpperCase()
    
    aiExplanation.value = `Berdasarkan analisis algoritma Random Forest dari 7 parameter tanah dan cuaca yang Anda masukkan, lahan ini memiliki kecocokan tertinggi untuk ditanami **${crop}**. Kondisi rasio **N-P-K**, tingkat keasaman (**pH ${phValue.value}**), serta iklim mikro (suhu **${temperature.value}°C** & kelembapan **${humidity.value}%**) di area tersebut sangat mendukung fase pertumbuhan dan hasil panen yang maksimal.`
    
    toastStore.showToast("Analisis lahan berhasil diselesaikan!", "success")
    
  } else if (aiStore.error) {
    toastStore.showToast(aiStore.error, "error")
  }
}
</script>

<template>
  <div class="ai-page-wrapper">
    <div class="ai-header animate-fade-up">
      <h1 class="title-with-icon">
        <img :src="landIcon">
        AI Rekomendasi Lahan
      </h1>
      <p>Masukkan data tanah dan cuaca di lahan Anda. Algoritma cerdas kami akan mencarikan jenis tanaman yang paling cocok untuk dikembangkan.</p>
    </div>

    <div class="ai-card animate-fade-up" style="animation-delay: 0.1s;">
      
      <form @submit.prevent="analyzeSoil">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label>Nitrogen (N):</label>
            <input type="number" step="any" v-model="nValue" placeholder="Contoh: 90.0" class="model-select" required />
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label>Fosfor (P):</label>
            <input type="number" step="any" v-model="pValue" placeholder="Contoh: 42.0" class="model-select" required />
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label>Kalium (K):</label>
            <input type="number" step="any" v-model="kValue" placeholder="Contoh: 43.0" class="model-select" required />
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label>Suhu (°C):</label>
            <input type="number" step="any" v-model="temperature" placeholder="Contoh: 20.8" class="model-select" required />
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label>Kelembapan (%):</label>
            <input type="number" step="any" v-model="humidity" placeholder="Contoh: 82.0" class="model-select" required />
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label>pH Tanah:</label>
            <input type="number" step="any" v-model="phValue" placeholder="Contoh: 6.5" class="model-select" required />
          </div>
        </div>

        <div class="form-group" style="margin-top: 16px;">
          <label>Curah Hujan (mm):</label>
          <input type="number" step="any" v-model="rainfall" placeholder="Contoh: 202.9" class="model-select" required />
        </div>

        <button type="submit" :disabled="aiStore.isLoading" class="btn-predict" style="margin-top: 10px;">
          <span v-if="aiStore.isLoading" class="btn-content-loading">
            <span class="spinner-icon"></span> AI Sedang Menghitung...
          </span>
          <span v-else> Cari Tanaman Yang Cocok</span>
        </button>

      </form>

      <div v-if="aiStore.predictionResult" 
           class="result-box animate-fade-up result-good">
        
        <h3>Rekomendasi Tanaman Terbaik:</h3>
        <p class="result-disease result-title-text" style="font-size: 32px; text-transform: uppercase;">
          {{ aiStore.predictionResult }}
        </p>

        <div class="ai-stats-row">
          <span class="stat-badge">
            <img :src="robotIcon" class="stat-icon"> Model: Random Forest 
          </span>
        </div>
        
        <div class="ai-message" v-html="aiExplanation.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')"></div>
        
      </div>

    </div>
  </div>
</template>

<style scoped src="@/assets/styles/views/ai/AIRekomendasiLahan.css"></style>