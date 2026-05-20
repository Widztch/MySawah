<script setup>
defineProps({
  item: Object
})
</script>

<template>

  <div class="product-card">

    <!-- IMAGE -->
    <div class="product-image-wrapper">

      <img
        :src="item.image"
        :alt="item.title"
        class="product-image"
      />

    </div>

    <!-- CONTENT -->
    <div class="product-content">

      <h3 class="product-title">
        {{ item.title }}
      </h3>

      <p class="product-price">
        {{ item.price }}
      </p>

      <div class="product-bottom">

        <div class="product-rating">
          ⭐ {{ item.rating }}
        </div>

        <button class="product-button">
          Lihat Detail
        </button>

      </div>

    </div>

    <!-- CIRCLE -->
    <div class="product-circle">
      ↗
    </div>

  </div>

</template>