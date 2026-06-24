<script setup>
import { useRouter } from 'vue-router'

import logoImg from '@/assets/images/logo/logo.png'
import userIcon from '@/assets/images/ai/user-icon.png' 
import aiIcon from '@/assets/images/ai/ai-icon.png'     

const router = useRouter()

const goToAI = () => {
  router.push('/ai-assistant')
}
</script>

<template>
  <section class="ai-section">

    <div class="ai-line-top animate-on-scroll"></div>

    <div class="ai-container">

      <div class="ai-left animate-on-scroll" style="transition-delay: 100ms;">
        
        <div class="ai-text-content">
          <div class="ai-mini-brand">
            <img :src="logoImg" alt="MySawah" class="mini-brand-logo" />
            <span>MySawah</span>
          </div>

          <h2 class="ai-title">
            AI Assistant<br>MySawah
          </h2>

          <p class="ai-description">
            Tanyakan masalah pertanian anda,<br>
            AI kami siap memberikan rekomendasi terbaik.
          </p>
        </div>

        <div class="ai-btn-wrapper">
          <button @click="goToAI" class="btn-primary ai-btn">
            Coba Sekarang
          </button>
        </div>

      </div>

      <div class="ai-right">

        <div class="chat-user-box animate-on-scroll floating-animation" style="transition-delay: 300ms;">
          
          <div class="chat-avatar-user">
            <img :src="userIcon" alt="User" class="avatar-img" />
          </div>
          
          <p>Hallo AI MySawah, Berikut ini adalah data saya:
            5,2. 0.11, 0.14, 20, 0.056, 22, 76</p>
        </div>

        <div class="chat-ai-box animate-on-scroll floating-animation-delayed" style="transition-delay: 600ms;">
          
          <div class="chat-avatar-ai">
            <img :src="aiIcon" alt="AI" class="avatar-img" />
          </div>

          <p>
            Dari beberapa data kandungan, kelembapan, pH dan Curah Hujan yang telah
            Anda masukkan, Tanaman utama yang direkomendasikan 
            berdasarkan data tanah Anda adalah <strong> kacang merah </strong> 
          </p>

          <div class="chat-list">
            <h4>Berikut adalah beberapa langkah yang bisa Anda terapkan:</h4>
            <ol>
              <li>Berikan pupuk urea pada area sekitar akar</li>
              <li>Pastikan irigasi atau pengairan lahan cukup</li>
              <li>Cek kondisi hama secara berkala</li>
            </ol>
          </div>

        </div>

      </div>

    </div>

    <div class="ai-line-bottom animate-on-scroll" style="transition-delay: 800ms;"></div>

  </section>
</template>