<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useProfileStore } from '@/stores/profileStore'

import iconUser from '@/assets/images/navbar/icon-user.png'
import iconOrder from '@/assets/images/navbar/icon-order.png'
import iconAdmin from '@/assets/images/navbar/icon-admin.png'
import iconLogout from '@/assets/images/navbar/icon-logout.png'

const router = useRouter()
const profileStore = useProfileStore()
const isDropdownOpen = ref(false)
const searchQuery = ref('')

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

const handleLogout = async () => {
  isDropdownOpen.value = false
  const success = await profileStore.logout()
  if (success) {
    router.push('/login')
  }
}

const handleSearch = () => {
  if (searchQuery.value.trim() !== '') {
    router.push({ path: '/produk', query: { search: searchQuery.value } })
    searchQuery.value = '' 
  }
}

onMounted(async () => {
  if (!profileStore.user) {
    await profileStore.fetchUser()
  }
})
</script>

<template>
  <header class="navbar">
    <div class="navbar-container">

      <div class="logo-wrapper">
        <img src="../../assets/images/logo/logo.png" alt="MySawah Logo" class="logo-img" />
        <span class="logo-text">MySawah</span>
      </div>

      <nav class="nav-menu">
        <router-link to="/">Beranda</router-link>
        <router-link to="/produk">Produk</router-link>
        <router-link to="/ai-assistant">AI Assistant</router-link>
        <router-link to="/tentang-kami">Tentang Kami</router-link>
      </nav>

      <div class="navbar-right">
        <div class="search-wrapper">
          <input 
            type="text" 
            v-model="searchQuery"
            @keyup.enter="handleSearch"
            placeholder="Cari produk lalu Enter..." 
            class="search-input" 
          />
          <img src="../../assets/images/navbar/magnifying-glass.png" alt="Search" class="search-icon" @click="handleSearch" style="cursor:pointer;" />
        </div>

        <router-link to="/keranjang" class="cart-link">
          <img src="../../assets/images/navbar/trolley-cart.png" alt="Cart" class="nav-icon-img" />
        </router-link>
        
        <div class="profile-menu-container">
          
          <router-link v-if="!profileStore.isLoggedIn" to="/login" class="login-link-box">
            <img src="../../assets/images/navbar/circle.png" alt="Login" class="nav-icon-img" />
          </router-link>

          <div v-else class="profile-dropdown-wrapper">
            <button @click="toggleDropdown" class="btn-profile-trigger">
              <img :src="profileStore.profilePhotoUrl" alt="User Profile" class="nav-profile-avatar" />
              <span class="nav-username">{{ profileStore.firstName }}</span>
            </button>

            <transition name="dropdown-fade">
              <div v-if="isDropdownOpen" class="nav-dropdown-menu">
                <router-link to="/profil" class="dropdown-nav-item" @click="isDropdownOpen = false">
                  <img :src="iconUser" alt="Profil" class="dropdown-icon" /> Dashboard Profil
                </router-link>
                
                <router-link to="/riwayat-pesanan" class="dropdown-nav-item" @click="isDropdownOpen = false">
                  <img :src="iconOrder" alt="Pesanan" class="dropdown-icon" /> Riwayat Pesanan
                </router-link>
                
                <router-link v-if="profileStore.isAdmin" to="/admin/dashboard" class="dropdown-nav-item" @click="isDropdownOpen = false">
                  <img :src="iconAdmin" alt="Admin" class="dropdown-icon" /> Panel Admin
                </router-link>
                
                <button @click="handleLogout" class="dropdown-nav-item logout-action-btn">
                  <img :src="iconLogout" alt="Keluar" class="dropdown-icon" /> Keluar
                </button>
              </div>
            </transition>
          </div>

        </div>
      </div>
    </div>
  </header>
</template>