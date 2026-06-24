<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useProfileStore } from '@/stores/profileStore'

import iconDashboard from '@/assets/images/admin/graph.png'
import iconOrder from '@/assets/images/admin/box.png'
import iconProduct from '@/assets/images/admin/wheat-plant.png'
import iconHome from '@/assets/images/admin/home.png'

const router = useRouter()
const profileStore = useProfileStore()

const isSidebarMinimized = ref(false)

onMounted(() => {
  if (!profileStore.user) {
    profileStore.fetchUser()
  }
})

const goToDashboard = () => {
  router.push('/')
}

const toggleSidebar = () => {
  isSidebarMinimized.value = !isSidebarMinimized.value
}
</script>

<template>
  <div :class="['admin-layout', { 'sidebar-minimized': isSidebarMinimized }]">
    
    <aside class="admin-sidebar">
      <div class="sidebar-brand">
        <button @click="toggleSidebar" class="btn-hamburger" title="Minimize Sidebar">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
        <h2 class="brand-text">Admin MySawah</h2>
      </div>

      <nav class="sidebar-nav">
        <router-link to="/admin/dashboard" class="nav-item" title="Dashboard Omzet">
          <img :src="iconDashboard" class="sidebar-icon" alt="Dashboard" />
          <span class="nav-text">Dashboard Omzet</span>
        </router-link>
        
        <router-link to="/admin/orders" class="nav-item" title="Kelola Pesanan">
          <img :src="iconOrder" class="sidebar-icon" alt="Pesanan" />
          <span class="nav-text">Kelola Pesanan</span>
        </router-link>
        
        <router-link to="/admin/products" class="nav-item" title="Kelola Produk">
          <img :src="iconProduct" class="sidebar-icon" alt="Produk" />
          <span class="nav-text">Kelola Produk</span>
        </router-link>
      </nav>

      <div class="sidebar-footer">
        <button @click="goToDashboard" class="btn-back" title="Dashboard Utama">
          <img :src="iconHome" class="sidebar-icon" alt="Home" />
          <span class="nav-text">Dashboard Utama</span>
        </button>
      </div>
    </aside>

    <main class="admin-main">
      <header class="admin-header">
        <h3>Selamat datang kembali, {{ profileStore.firstName || 'Admin' }}</h3>
      </header>
      
      <div class="admin-content">
        <router-view v-slot="{ Component }">
          <transition name="fade-slide" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view> 
      </div>
    </main>
    
  </div>
</template>