<script setup>
import Navbar from '../components/layout/Navbar.vue'
import Footer from '../components/layout/Footer.vue'

import iconLeaf from '@/assets/images/logo/logo.png'
import iconTarget from '@/assets/images/about/mision.png' 
import iconRocket from '@/assets/images/about/vision.png' 
import iconStar from '@/assets/images/about/icon-thumbs.png' 
import iconAI from '@/assets/images/about/icon-ai.png'
import iconTruck from '@/assets/images/about/icon-delivery.png' 
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <section class="about-hero animate-fade-up">
      <div class="hero-content">
        <div class="section-badge animate-fade-up" style="animation-delay: 0.1s;">
          <img :src="iconLeaf" alt="Daun" class="badge-icon" v-if="iconLeaf" />
          MySawah
        </div>
        <h1 class="hero-title animate-fade-up" style="animation-delay: 0.2s;">Tumbuh Bersama Petani Indonesia</h1>
        <p class="hero-subtitle animate-fade-up" style="animation-delay: 0.3s;">
          MySawah hadir sebagai platform pertanian terintegrasi yang menggabungkan 
          teknologi cerdas dengan produk berkualitas untuk mewujudkan pertanian yang lebih maju, 
          mudah, dan menguntungkan.
        </p>
      </div>
    </section>

    <div class="about-container">
      
      <section class="vision-mission-section">
        <div class="vm-card animate-fade-up" style="animation-delay: 0.4s;">
          <div class="vm-icon-wrapper">
            <img :src="iconTarget" alt="Visi" class="vm-icon-img" v-if="iconTarget" />
          </div>
          <h2>Visi Kami</h2>
          <p>
            Menjadi ekosistem digital pertanian terbesar di Indonesia yang menjembatani 
            petani dengan teknologi, pengetahuan, dan akses pasar yang adil demi 
            tercapainya ketahanan pangan nasional.
          </p>
        </div>
        
        <div class="vm-card animate-fade-up" style="animation-delay: 0.5s;">
          <div class="vm-icon-wrapper">
            <img :src="iconRocket" alt="Misi" class="vm-icon-img" v-if="iconRocket" />
          </div>
          <h2>Misi Kami</h2>
          <ul class="mission-list">
            <li>Menyediakan sarana pertanian berkualitas tinggi dengan harga terjangkau.</li>
            <li>Mengintegrasikan asisten AI cerdas untuk solusi permasalahan tanam.</li>
            <li>Memastikan distribusi dan pengiriman sarana pertanian yang cepat dan aman.</li>
            <li>Mengedukasi petani menuju praktik pertanian yang modern dan berkelanjutan.</li>
          </ul>
        </div>
      </section>

      <section class="values-section">
        <h2 class="section-title-center animate-fade-up" style="animation-delay: 0.6s;">Mengapa Memilih MySawah?</h2>
        
        <div class="values-grid">
          
          <div class="value-item animate-fade-up" style="animation-delay: 0.7s;">
            <div class="value-icon-wrapper">
              <img :src="iconStar" alt="Kualitas" class="value-icon-img" v-if="iconStar" />
            </div>
            <h3>Kualitas Terjamin</h3>
            <p>Setiap bibit, pupuk, dan pestisida yang kami sediakan telah melewati proses kurasi ketat untuk memastikan hasil panen yang optimal.</p>
          </div>
          
          <div class="value-item animate-fade-up" style="animation-delay: 0.8s;">
            <div class="value-icon-wrapper">
              <img :src="iconAI" alt="AI Cerdas" class="value-icon-img" v-if="iconAI" />
            </div>
            <h3>Dukungan AI Cerdas</h3>
            <p>Tidak perlu bingung saat tanaman sakit. AI Assistant kami siap memberikan diagnosa dan rekomendasi penanganan 24/7.</p>
          </div>
          
          <div class="value-item animate-fade-up" style="animation-delay: 0.9s;">
            <div class="value-icon-wrapper">
              <img :src="iconTruck" alt="Pengiriman" class="value-icon-img" v-if="iconTruck" />
            </div>
            <h3>Pengiriman Aman</h3>
            <p>Jaringan logistik yang andal menjamin pesanan kebutuhan pertanian Anda tiba tepat waktu dengan kondisi sempurna.</p>
          </div>
        </div>
      </section>
    </div>
  </div>
<Footer />
</template>