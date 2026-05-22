<script setup>
import AIMascot from './AIMascot.vue'
</script>

<template>

  <section class="ai-section">

    <!-- ================================= -->
    <!-- TOP LINE -->
    <!-- ================================= -->

    <div class="ai-line-top"></div>

    <div class="ai-container">

      <!-- ================================= -->
      <!-- LEFT -->
      <!-- ================================= -->

      <div class="ai-left">

        <!-- BRAND -->
        <div class="ai-mini-brand">

          <div class="mini-brand-circle">
            🍃
          </div>

          <span>
            MySawah
          </span>

        </div>

        <!-- TITLE -->
        <h2 class="ai-title">
          AI Assistant
          MySawah
        </h2>

        <!-- DESC -->
        <p class="ai-description">
          Berikan data dalam pertanian anda,
          AI Assistant kami siap memberikan rekomendasi 
          tanaman utama dan pendamping terbaik untuk lahan Anda.
        </p>

        <!-- BUTTON -->
        <button class="btn-primary">
          Coba Sekarang
        </button>

      </div>

      <!-- ================================= -->
      <!-- RIGHT -->
      <!-- ================================= -->

      <div class="ai-right">

        <!-- CHAT TOP -->
        <div class="chat-green">

          Hallo AI MySawah, Berikut ini adalah data saya:
          5,2. 0.11, 0.14, 20, 0.056, 22, 76

        </div>

        <!-- CHAT WHITE -->
        <div class="chat-white">

          <p>
            Dari beberapa data kandungan, kelembapan, pH dan Curah Hujan yang telah
            Anda masukkan, Tanaman utama yang direkomendasikan 
            berdasarkan data tanah Anda adalah kacang merah
          </p>

          <div class="chat-list">

            <h4>
              Dan dari hasil rekomendasi tanaman utama, 
              beberapa tanaman pendamping yang cocok adalah:
            </h4>

            <ol>
              <li>Jagung</li>
              <li>Padi</li>
              <li>Cabai</li>
            </ol>

          </div>

        </div>

        <!-- ================================= -->
        <!-- AI MASCOT -->
        <!-- ================================= -->

        <div class="ai-mascot-position">

          <AIMascot />

        </div>

      </div>

    </div>

    <!-- ================================= -->
    <!-- BOTTOM LINE -->
    <!-- ================================= -->

    <div class="ai-line-bottom"></div>

  </section>

</template>