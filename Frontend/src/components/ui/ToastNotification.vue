<script setup>
import { useToastStore } from '@/stores/toastStore'
const toastStore = useToastStore()
</script>

<template>
  <Transition name="slide-left">
    <div v-if="toastStore.show" class="toast-popup">
      <span class="toast-text">{{ toastStore.message }}</span>
    </div>
  </Transition>
</template>