<template>

  <div class="home-page">

    <!-- ================================= -->
    <!-- NAVBAR -->
    <!-- ================================= -->

    <Navbar />

    <!-- ================================= -->
    <!-- HERO SECTION -->
    <!-- ================================= -->
    <section 
      class="hero-section" 
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
            <button class="btn-primary">
              Mulai Sekarang
            </button>
            <button class="btn-secondary">
              Jelajahi Produk
            </button>
          </div>

        </div>
      </div>

    </section>

    <!-- ================================= -->
    <!-- FEATURES -->
    <!-- ================================= -->

    <section class="features-section">

      <div class="features-grid">

        <!-- ITEM -->
        <div class="feature-item">

          <div class="feature-icon">
            🌾
          </div>

          <div>

            <h3 class="feature-title">
              Marketplace Pertanian
            </h3>

            <p class="feature-description">
              Produk berkualitas dari berbagai kategori
            </p>

          </div>

        </div>

        <!-- ITEM -->
        <div class="feature-item">

          <div class="feature-icon">
            🌱
          </div>

          <div>

            <h3 class="feature-title">
              AI Assistant
            </h3>

            <p class="feature-description">
              Kontruksi tanaman dan rekomendasi cerdas
            </p>

          </div>

        </div>

        <!-- ITEM -->
        <div class="feature-item">

          <div class="feature-icon">
            🚚
          </div>

          <div>

            <h3 class="feature-title">
              Pengiriman Cepat
            </h3>

            <p class="feature-description">
              Pengiriman aman dan tepat waktu
            </p>

          </div>

        </div>

        <!-- ITEM -->
        <div class="feature-item">

          <div class="feature-icon">
            👨‍🌾
          </div>

          <div>

            <h3 class="feature-title">
              Untuk Petani Indonesia
            </h3>

            <p class="feature-description">
              Dukungan penuh untuk pertanian berkelanjutan
            </p>

          </div>

        </div>

      </div>

    </section>

<!-- ================================= -->
<!-- PRODUCTS -->
<!-- ================================= -->

<ProductList />

<!-- ================================= -->
<!-- AI ASSISTANT -->
<!-- ================================= -->

<AIChat />

<!-- ================================= -->
<!-- ABOUT -->
<!-- ================================= -->

<AboutStats />

  </div>

</template>

<script setup>
import heroBgImage from '../assets/images/bg.png'
import Navbar from '@/components/layout/Navbar.vue'
import ProductList from '@/components/product/ProductList.vue'
import AIChat from '@/components/ai/AIChat.vue'
import AboutStats from '@/components/about/AboutStats.vue'
</script>