<script setup>
import { computed, onMounted, ref } from 'vue'
import ProductCard from './ProductCard.vue'
import { useProductStore } from '@/stores/productStore'

import logoImg from '@/assets/images/logo/logo.png'

const productStore = useProductStore()

const sliderTrack = ref(null)
const isSliding = ref(false) // State untuk memicu animasi saat tombol diklik

onMounted(() => {
  if (productStore.products.length === 0) {
    productStore.fetchProducts()
  }
})

const popularProducts = computed(() => {
  return [...productStore.products]
    .sort((a, b) => (b.terjual || 0) - (a.terjual || 0))
    .slice(0, 10) 
})

// Fungsi Animasi Geser Slider
const handleSlide = (direction) => {
  if (!sliderTrack.value) return

  // 1. Aktifkan class animasi
  isSliding.value = true

  // 2. Hitung seberapa jauh harus menggeser (Lebar 1 kartu + Gap 24px)
  // Ini memastikan geseran selalu pas 1 kartu penuh, berapapun ukuran layarnya
  const firstCard = sliderTrack.value.children[0]
  const cardWidth = firstCard ? firstCard.offsetWidth : 230
  const gap = 24 

  // 3. Eksekusi geser
  sliderTrack.value.scrollBy({ left: direction * (cardWidth + gap), behavior: 'smooth' })

  // 4. Matikan efek animasi setelah geseran selesai (sekitar 400 milidetik)
  setTimeout(() => {
    isSliding.value = false
  }, 400)
}
</script>

<template>
  <section class="products-section">
    <div class="products-container">

      <div class="products-header animate-on-scroll">
        <div>
          <div class="section-badge">
            <img :src="logoImg" alt="MySawah Logo" class="badge-logo" />
            MySawah
          </div>
          <h2 class="products-title">Produk Terpopuler</h2>
        </div>

        <div class="slider-buttons">
          <button @click="handleSlide(-1)" class="slider-button" aria-label="Geser Kiri">‹</button>
          <button @click="handleSlide(1)" class="slider-button" aria-label="Geser Kanan">›</button>
        </div>
      </div>

      <div class="products-slider-wrapper animate-on-scroll" style="transition-delay: 200ms;">
        
        <div v-if="productStore.isLoading" style="color: white; text-align: center; padding: 40px 20px; font-weight: 500;">
          Sedang menyiapkan produk unggulan MySawah...
        </div>
        
        <div v-else-if="productStore.error" style="color: #ffcccc; text-align: center; padding: 40px 20px;">
          {{ productStore.error }}
        </div>

        <div v-else-if="popularProducts.length === 0" style="color: white; text-align: center; padding: 40px 20px;">
          Belum ada data produk untuk ditampilkan.
        </div>

        <div v-else class="products-track" :class="{ 'is-sliding': isSliding }" ref="sliderTrack">
          <ProductCard
            v-for="product in popularProducts"
            :key="product.id_produk"
            :product="product" 
          />
        </div>

      </div>

      <div class="view-all-wrapper animate-on-scroll" style="transition-delay: 400ms;">
        <router-link to="/produk" class="btn-view-all">Lihat Semua</router-link>
      </div>

    </div>
  </section>
</template>