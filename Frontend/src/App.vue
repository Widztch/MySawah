<script setup>
import { RouterView } from 'vue-router'
import LoadingScreen from '@/components/ui/LoadingScreen.vue' 
import ToastNotification from '@/components/ui/ToastNotification.vue'
import ConfirmModal from '@/components/ui/ConfirmModal.vue'
</script>

<template>
  <LoadingScreen />
  <ToastNotification /> 
  <ConfirmModal /> 
  <RouterView />
</template>