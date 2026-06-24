<script setup>
import Navbar from '@/components/layout/Navbar.vue'
import Footer from '@/components/layout/Footer.vue'
import aiIcon from '@/assets/images/ai/ai-icon.png'
import cornIcon from '@/assets/images/ai/corn.png'
import plantIcon from '@/assets/images/ai/plant.png'
import mapIcon from '@/assets/images/ai/ground.png'
</script>

<template>
  <div class="ai-layout-wrapper">
    <Navbar />
    
    <div class="ai-layout-container">
      
      <aside class="ai-sidebar">
        <h2 class="ai-sidebar-title">
          <img :src="aiIcon" class="sidebar-ai-icon">
          AI Assistant
        </h2>
        <nav class="ai-nav">
          
          <router-link to="/ai-assistant/prediksi-jagung" class="ai-nav-item">
            <img :src="cornIcon" class="ai-icon">
            <div class="ai-nav-text">
              <span class="ai-nav-title">Prediksi Penyakit</span>
              <span class="ai-nav-desc">Daun Jagung (CNN)</span>
            </div>
          </router-link>

          <router-link to="/ai-assistant/tanaman-pendamping" class="ai-nav-item">
            <img :src="plantIcon" class="ai-icon">
            <div class="ai-nav-text">
              <span class="ai-nav-title">Tanaman Pendamping</span>
              <span class="ai-nav-desc">Catboost Model</span>
            </div>
          </router-link>

          <router-link to="/ai-assistant/rekomendasi-lahan" class="ai-nav-item">
            <img :src="mapIcon" class="ai-icon">
            <div class="ai-nav-text">
              <span class="ai-nav-title">Rekomendasi Lahan</span>
              <span class="ai-nav-desc">Random Forest Model</span>
            </div>
          </router-link>

        </nav>
      </aside>

      <main class="ai-main-content">
        <router-view v-slot="{ Component }">
          <transition name="fade-slide" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>

    </div>

    <Footer />
  </div>
</template>