<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore' 
// KUNCI: Impor Toast Store
import { useToastStore } from '@/stores/toastStore'

const router = useRouter()
const authStore = useAuthStore()
const toastStore = useToastStore()

const email = ref('')
const password = ref('')
const showPassword = ref(false)

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const handleLogin = async () => {
  const success = await authStore.login(email.value, password.value)
  
  if (success) {
    // KUNCI: Panggil Toast untuk Sukses
    toastStore.showToast('✅ Login Berhasil! Selamat datang.')
    router.push('/') 
  } else {
    // KUNCI: Panggil Toast untuk Error
    toastStore.showToast('❌ ' + (authStore.error || 'Login gagal.')) 
  }
}
</script>

<template>
  <div class="login-page">
    <div class="login-card">
      
      <div class="login-left">
        <img src="../assets/images/loreg/Loreg.png" alt="Background">
        <div class="login-overlay">
          
          <div class="brand-wrapper">
            <img src="../assets/images/logo/logo.png" alt="Logo" class="overlay-logo" />
            <h1 class="brand-text">MySawah</h1>
          </div>

        </div>
      </div>

      <div class="login-right">
        
        <router-link to="/" class="btn-back-home" title="Kembali ke Beranda">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="back-icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          Kembali
        </router-link>

        <div class="login-header">
          <h2>Selamat Datang Kembali</h2>
          <p>Masuk untuk melanjutkan</p>
        </div>

        <form @submit.prevent="handleLogin">
          
          <div class="form-group">
            <label>Email</label>
            <div class="input-wrapper">
              <input type="email" v-model="email" placeholder="Masukkan Email" required>
            </div>
          </div>

          <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
              <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Masukkan Password" required>
              
              <svg @click="togglePassword" class="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path v-if="!showPassword" stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
            <a href="#" class="forgot-password">Lupa Password?</a>
          </div>

          <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="login-footer">
          Belum punya akun? <router-link to="/register">Daftar sekarang</router-link>
        </div>
      </div>
      
    </div>
  </div>
</template>