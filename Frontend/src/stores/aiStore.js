import { defineStore } from 'pinia'
import axios from 'axios'

export const useAiStore = defineStore('ai', {
  state: () => ({
    isLoading: false,
    predictionResult: null,
    confidenceScore: null,
    error: null,
  }),

  actions: {
    // Aksi untuk Fitur 1: Prediksi Penyakit Jagung 
    async predictCornDisease(file, modelName) {
      this.isLoading = true
      this.error = null
      this.predictionResult = null
      this.confidenceScore = null

      try {
        const formData = new FormData()
        formData.append('file', file)

        // API FastAPI 
        const url = `http://localhost:8080/cnn/predict-leaf?model_name=${modelName}`
        const response = await axios.post(url, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })

        if (response.data.status === 'success') {
          this.predictionResult = response.data.prediction
          this.confidenceScore = response.data.confidence
          return true
        }
      } catch (err) {
        console.error("Gagal menganalisis gambar:", err)
        this.error = err.response?.data?.detail || "Terjadi kesalahan saat menghubungi server AI."
        return false
      } finally {
        this.isLoading = false
      }
    },
    
    // digunakan untuk menghapus hasil prediksi sebelumnya agar tidak menumpuk di UI
      clearResults() {
        this.predictionResult = null
        this.confidenceScore = null
        this.error = null
      }
    }
  })