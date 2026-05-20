<script setup>
import ProductCard from './ProductCard.vue'

import { popularProducts } from '@/data/products'
</script>

<template>

  <section class="products-section">

    <div class="products-container">

      <!-- HEADER -->
      <div class="products-header">

        <div>

          <div class="section-badge">
            🍃 MySawah
          </div>

          <h2 class="products-title">
            Produk Populer
          </h2>

        </div>

        <!-- BUTTON -->
        <div class="slider-buttons">

          <button class="slider-button">
            ‹
          </button>

          <button class="slider-button">
            ›
          </button>

        </div>

      </div>

      <!-- GRID -->
      <div class="products-grid">

        <ProductCard
          v-for="product in popularProducts"
          :key="product.id"
          :item="product"
        />

      </div>

    </div>

  </section>

</template>