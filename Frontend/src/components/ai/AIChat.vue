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
          Tanyakan masalah pertanian anda,
          AI kami siap memberikan rekomendasi terbaik
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

          Hallo AI, Berikut ini adalah data  ?

        </div>

        <!-- CHAT WHITE -->
        <div class="chat-white">

          <p>
            Kemungkinan kekurangan unsur hara,
            [Nitrogen]. Coba kamu berikan pupuk
            urea dengan elemen yang tepat dan
            pastikan pengairan cukup.
          </p>

          <div class="chat-list">

            <h4>
              Tindakan selanjutnya:
            </h4>

            <ol>
              <li>Berikan pupuk urea</li>
              <li>Pastikan irigasi cukup</li>
              <li>Cek kondisi hama</li>
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