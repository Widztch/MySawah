<script setup>
import { useLoadingStore } from '@/stores/loadingStore'

const loadingStore = useLoadingStore()
</script>

<template>
  <div v-if="loadingStore.isLoading" class="global-loading-overlay">
    <div class="spinner-container">
      <div class="spinner"></div>
      <p class="loading-text">Memuat MySawah...</p>
    </div>
  </div>
</template>