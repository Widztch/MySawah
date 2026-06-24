<script setup>
import { ref, onMounted } from 'vue'
import api from '@/utils/axios'

import iconMoneyBag from '@/assets/images/admin/icon-total.png'
import iconBarChart from '@/assets/images/admin/icon-today.png'
import iconOfficeBuilding from '@/assets/images/admin/icon-month.png'
import iconHourglassHighlight from '@/assets/images/admin/icon-pending.png'


const omzetData = ref({
  omzet_hari_ini: 0,
  omzet_bulan_ini: 0,
  omzet_total: 0,
  pesanan_menunggu: 0
})

const isLoading = ref(true)
const error = ref('')

// FUNGSI MENGAMBIL DATA DARI BACKEND
const fetchOmzet = async () => {
  try {
    isLoading.value = true
    const response = await api.get('/admin/dashboard/omzet')
    
    if (response.data.status === 'success') {
      omzetData.value = response.data.data
    }
  } catch (err) {
    console.error('Error fetch omzet:', err)
    error.value = 'Gagal memuat data omzet. Pastikan Anda login sebagai Admin.'
  } finally {
    isLoading.value = false
  }
}

// Fungsi Format Rupiah
const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { 
    style: 'currency', 
    currency: 'IDR', 
    minimumFractionDigits: 0 
  }).format(angka || 0)
}

// Panggil fungsi saat halaman dimuat
onMounted(() => {
  fetchOmzet()
})

// Teks statis untuk UI

const placeholderLabels = [
  "Omzet Hari Kemarin",
  "Omzet Bulan Kemarin",
  "Grafik Penjualan Bulanan",
  "Daftar Pesanan Terbaru"
]
</script>

<template>
  <div class="page-container">
    <p class="user-greeting">{{ greetingText }}</p>
    <h2 class="page-title">Ringkasan Omzet</h2>

    <div v-if="isLoading" class="loading-state">Memuat data metrik dari server...</div>
    <div v-else-if="error" class="error-state">{{ error }}</div>

    <div v-else>
      <div class="metrics-grid">
        
        <div class="metric-card">
          <div class="metric-icon"><img :src="iconMoneyBag" alt="Hari Ini" class="icon-img" /></div>
          <div class="metric-info">
            <p>Omzet Hari Ini</p>
            <h3>{{ formatRupiah(omzetData.omzet_hari_ini) }}</h3>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-icon"><img :src="iconBarChart" alt="Bulan Ini" class="icon-img" /></div>
          <div class="metric-info">
            <p>Omzet Bulan Ini</p>
            <h3>{{ formatRupiah(omzetData.omzet_bulan_ini) }}</h3>
          </div>
        </div>

        <div class="metric-card">
          <div class="metric-icon"><img :src="iconOfficeBuilding" alt="Total" class="icon-img" /></div>
          <div class="metric-info">
            <p>Total Keseluruhan</p>
            <h3>{{ formatRupiah(omzetData.omzet_total) }}</h3>
          </div>
        </div>

        <div class="metric-card highlight">
          <div class="metric-icon"><img :src="iconHourglassHighlight" alt="Menunggu" class="hourglass-icon" /></div>
          <div class="metric-info">
            <p>Pesanan Menunggu (PAID)</p>
            <h3>{{ omzetData.pesanan_menunggu }} Pesanan</h3>
          </div>
        </div>

      </div>

      <div class="placeholder-grid">
        <div v-for="(label, index) in placeholderLabels" :key="index" class="placeholder-card">
          <p class="placeholder-label">{{ label }}</p>
        </div>
      </div>
    </div>

  </div>
</template>