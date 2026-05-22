<script setup>
import AIMascot from './AIMascot.vue'
</script>

<template>

  <section class="ai-section">

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
          AI Assistant MySawah
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

          Hallo AI, Daun padi saya
          menguning, itu kenapa ya?

        </div>

        <!-- CHAT BOTTOM -->
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

        <!-- ================================= -->
        <!-- SATU CIRCLE SAJA -->
        <!-- ================================= -->

        <div class="floating-circle"></div>

      </div>

    </div>

  </section>

</template>