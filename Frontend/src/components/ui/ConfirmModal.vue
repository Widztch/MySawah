<script setup>
import { useConfirmStore } from '@/stores/confirmStore'

const confirmStore = useConfirmStore()
</script>

<template>
  <div v-if="confirmStore.isOpen" class="confirm-overlay">
    <div class="confirm-card">
      <div class="confirm-header">
        <h3>{{ confirmStore.title }}</h3>
      </div>
      
      <div class="confirm-body">
        <p>{{ confirmStore.message }}</p>
      </div>
      
      <div class="confirm-footer">
        <button @click="confirmStore.cancel" class="btn-confirm-cancel">Batal</button>
        <button @click="confirmStore.accept" class="btn-confirm-accept">Ya, Lanjutkan</button>
      </div>
    </div>
  </div>
</template>