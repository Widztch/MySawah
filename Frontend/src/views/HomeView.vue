<template>
  <div class="home-page">

    <Navbar />

    <section 
      class="hero-section animate-on-scroll" 
      :style="{ backgroundImage: `url(${heroBgImage})` }"
    >
      <div class="hero-overlay"></div>

      <div class="hero-container">
        <div class="hero-content">
          <h1 class="hero-title">
            Solusi Digital untuk<br>
            Pertanian Modern
          </h1>
          <p class="hero-description">
            Platform pertanian terintegrasi dengan teknologi AI, 
            marketplace produk berkualitas, dan pengiriman cepat 
            untuk mendukung petani indonesia
          </p>
          <div class="hero-buttons">
            <button class="btn-primary" @click="handleStartNow">Mulai Sekarang</button>
            <button class="btn-secondary" @click="handleExploreProducts">Jelajahi Produk</button>
          </div>
        </div>
      </div>
    </section>

    <section class="features-section">
      <div class="features-grid">

        <div class="feature-item animate-on-scroll" style="transition-delay: 0ms;">
          <div class="feature-icon"><img :src="iconMarket" alt="Marketplace" class="custom-icon" /></div>
          <div>
            <h3 class="feature-title">Marketplace Pertanian</h3>
            <p class="feature-description">Produk berkualitas dari berbagai kategori</p>
          </div>
        </div>

        <div class="feature-item animate-on-scroll" style="transition-delay: 150ms;">
          <div class="feature-icon"><img :src="iconAi" alt="AI Assistant" class="custom-icon" /></div>
          <div>
            <h3 class="feature-title">AI Assistant</h3>
            <p class="feature-description">Instruksi tanaman dan rekomendasi cerdas</p>
          </div>
        </div>

        <div class="feature-item animate-on-scroll" style="transition-delay: 300ms;">
          <div class="feature-icon"><img :src="iconDelivery" alt="Pengiriman" class="custom-icon" /></div>
          <div>
            <h3 class="feature-title">Pengiriman Cepat</h3>
            <p class="feature-description">Pengiriman aman dan tepat waktu</p>
          </div>
        </div>

        <div class="feature-item animate-on-scroll" style="transition-delay: 450ms;">
          <div class="feature-icon"><img :src="iconFarmer" alt="Petani" class="custom-icon" /></div>
          <div>
            <h3 class="feature-title">Untuk Petani Indonesia</h3>
            <p class="feature-description">Dukungan penuh untuk pertanian berkelanjutan</p>
          </div>
        </div>

      </div>
    </section>

<ProductList />

<AIChat />

<AboutStats />

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useProfileStore } from '@/stores/profileStore' // Store untuk cek login

import heroBgImage from '../assets/images/home/bg.png'
import Navbar from '@/components/layout/Navbar.vue'
import ProductList from '@/components/product/ProductList.vue'
import AIChat from '@/components/ai/AIChat.vue'
import AboutStats from '@/components/about/AboutStats.vue'

import iconMarket from '@/assets/images/home/icon-market.png'
import iconAi from '@/assets/images/home/icon-ai.png'
import iconDelivery from '@/assets/images/home/icon-delivery.png'
import iconFarmer from '@/assets/images/home/icon-farmer.png'

const router = useRouter()
const profileStore = useProfileStore()

// --- FUNGSI NAVIGASI TOMBOL ---
const handleStartNow = () => {
  // Jika pengguna sudah login, arahkan ke halaman AI
  if (profileStore.isLoggedIn) {
    router.push('/ai-assistant') 
  } else {
    // Jika belum login, arahkan ke halaman Login
    router.push('/login') 
  }
}

const handleExploreProducts = () => {
  // Langsung arahkan ke halaman Produk
  router.push('/produk')
}

// --- ANIMASI SCROLL ---
onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show')
      } else {
        entry.target.classList.remove('show')
      }
    })
  }, {
    threshold: 0.1 
  })

  const hiddenElements = document.querySelectorAll('.animate-on-scroll')
  hiddenElements.forEach((el) => observer.observe(el))
})
</script>