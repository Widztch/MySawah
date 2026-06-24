<script setup>
import { ref, onMounted } from 'vue'
import { useAiStore } from '@/stores/aiStore' 
import { useToastStore } from '@/stores/toastStore'

import plantIcon from '@/assets/images/ai/plant.png'
import robotIcon from '@/assets/images/ai/ai-icon.png'

const aiStore = useAiStore()
const toastStore = useToastStore()

// State Form
const tanaman1 = ref('')
const tanaman2 = ref('')
const sourceType = ref('Sayuran')
const aiExplanation = ref('')

onMounted(() => {
  aiStore.clearResults()
})

const analyzeCompanion = async () => {
  if (!tanaman1.value || !tanaman2.value) {
    toastStore.showToast(
  "Mohon isi kedua nama tanaman terlebih dahulu.")
    return
  }

  aiExplanation.value = ''

  const success = await aiStore.predictCompanionPlant(tanaman1.value, tanaman2.value, sourceType.value)

  if (success && aiStore.predictionResult) {
    const t1 = tanaman1.value.toUpperCase()
    const t2 = tanaman2.value.toUpperCase()
    const result = String(aiStore.predictionResult).toLowerCase() 

    if (result === 'membantu') {
      aiExplanation.value = `Kombinasi mantap, Menanam **${t1}** di dekat **${t2}** itu bakal **SANGAT MEMBANTU**. Tanaman jenis ${sourceType.value} ini secara alami bisa bertindak sebagai bodyguard (pelindung) dari hama jahat atau menyumbang nutrisi ekstra ke dalam tanah. Bikin tanaman tetangganya makin subur!`
    } 
    else if (result === 'dibantu') {
      aiExplanation.value = `Pilihan tepat buat kelangsungan lahan! Pertumbuhan **${t1}** bakal **DIBANTU** banget oleh kehadiran **${t2}**. Keduanya membentuk tim solid di ekosistem mini lahan Anda, bikin penyerapan pupuk dan air jadi jauh lebih maksimal!`
    } 
    else if (result === 'hindari') {
      aiExplanation.value = `Waduh, mending **HINDARI** dulu deh, Menanam **${t1}** berdekatan langsung dengan **${t2}** kurang disarankan. Mereka berisiko besar buat rebutan makanan (unsur hara) di dalam tanah atau malah bisa saling menularkan penyakit bawaan.`
    } 
    else {
      // Penanganan jika backend mengirimkan status di luar dugaan atau 'belum terdaftar'
      aiExplanation.value = `Kombinasi untuk **${t1}** dan **${t2}** dengan kategori ${sourceType.value} rupanya **BELUM TERDAFTAR** di database pintar kami. Tim ahli MySawah akan segera memperbarui datanya agar lahan bisa dianalisis dengan akurat!`
    }
  } else if (result === 'belum_terdaftar') {
      aiExplanation.value = `Mohon maaf. Kombinasi tanaman **${t1}** dan **${t2}** rupanya **BELUM TERDAFTAR** di dalam database pintar (CSV) kami saat ini. Silakan periksa kembali ejaan namanya atau coba kombinasi tanaman lain!`
    }
}
</script>

<template>
  <div class="ai-page-wrapper">
    <div class="ai-header animate-fade-up">
      <h1 class="title-with-icon">
        <img :src="plantIcon">
        AI Tanaman Pendamping
      </h1>
      <p>Cek kecocokan tumpang sari tanaman Anda. Ketahui mana yang saling mendukung dan mana yang harus dipisah biar hasil panen melimpah!</p>
    </div>

    <div class="ai-card animate-fade-up" style="animation-delay: 0.1s;">
      
      <form @submit.prevent="analyzeCompanion">
        
        <div class="form-group">
          <label>Tanaman Utama (Tanaman 1):</label>
          <input 
            type="text" 
            v-model="tanaman1" 
            placeholder="Contoh: Kentang, Tomat, Cabai" 
            class="model-select" 
            required 
          />
        </div>

        <div class="form-group">
          <label>Tanaman Pendamping (Tanaman 2):</label>
          <input 
            type="text" 
            v-model="tanaman2" 
            placeholder="Contoh: Jagung, Bawang Merah" 
            class="model-select" 
            required 
          />
        </div>

        <div class="form-group">
          <label>Tipe Tanaman (Source Type):</label>
          <select v-model="sourceType" class="model-select">
            <option value="Sayuran">Sayuran</option>
            <option value="Herbal">Herbal</option>
            <option value="Bunga">Bunga</option>
            <option value="Buah">Buah</option>
          </select>
        </div>

        <button type="submit" :disabled="aiStore.isLoading || !tanaman1 || !tanaman2" class="btn-predict">
          <span v-if="aiStore.isLoading" class="btn-content-loading">
            <span class="spinner-icon"></span> AI Sedang Mengelola Data Lahan...
          </span>
          <span v-else>Cek Kecocokan</span>
        </button>

      </form>

      <div v-if="aiStore.predictionResult || aiStore.error" 
           class="result-box animate-fade-up" 
           :class="{
             'result-good': ['membantu', 'dibantu'].includes(String(aiStore.predictionResult).toLowerCase()),
             'result-bad': String(aiStore.predictionResult).toLowerCase() === 'hindari',
             'result-unknown': String(aiStore.predictionResult).toLowerCase() === 'belum_terdaftar'
           }">
        
        <h3>Rekomendasi Ekosistem:</h3>
        <p class="result-disease result-title-text" style="text-transform: uppercase;">
          {{ aiStore.predictionResult === 'belum_terdaftar' ? 'BELUM TERDAFTAR' : aiStore.predictionResult }}
        </p>

        <div class="ai-stats-row">
          <span class="stat-badge">
            <img :src="robotIcon" class="stat-icon">
            Model: CatBoost
          </span>
        </div>
        
        <div class="ai-message" v-html="aiExplanation.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')"></div>
        
      </div>

    </div>
  </div>
</template>

<style scoped src="@/assets/styles/views/ai/AITanamanPendamping.css"></style>