<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const authStore = useAuthStore()

const fullName = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('') 

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const togglePassword = () => {
  showPassword.value = !showPassword.value
}
const toggleConfirmPassword = () => {
  showConfirmPassword.value = !showConfirmPassword.value
}

const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    alert('Password dan Konfirmasi Password tidak cocok!');
    return;
  }

  // Panggil fungsi register menggunakan Pinia
  const success = await authStore.register(fullName.value, email.value, password.value)
  
  if (success) {
    alert('Registrasi Berhasil!')
    router.push('/') // Redirect ke halaman utama
  } else {
    alert(authStore.error)
  }
}
</script>

<template>
  <div class="register-page">
    <div class="register-card">
      
      <div class="register-left">
        <img src="https://images.unsplash.com/photo-1586771107565-961ce6821873?q=80&w=1000&auto=format&fit=crop" alt="Background">
        <div class="register-overlay">
          <h1>MySawah</h1>
        </div>
      </div>

      <div class="register-right">
        <div class="register-header">
          <h2>Buat Akun Baru</h2>
          <p>Daftar untuk memulai menggunakan MySawah</p>
        </div>

        <form @submit.prevent="handleRegister">
          
          <div class="form-group">
            <label>Nama Lengkap</label>
            <div class="input-wrapper">
              <input type="text" v-model="fullName" placeholder="Masukkan Nama Lengkap" required>
            </div>
          </div>

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
          </div>

          <div class="form-group">
            <label>Konfirmasi Password</label>
            <div class="input-wrapper">
              <input :type="showConfirmPassword ? 'text' : 'password'" v-model="confirmPassword" placeholder="Konfirmasi Password" required>
              <svg @click="toggleConfirmPassword" class="icon-eye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path v-if="!showConfirmPassword" stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
            </div>
          </div>

          <button type="submit" class="btn-register">Daftar</button>
        </form>

        <div class="register-footer">
          Sudah punya akun? <router-link to="/login">Masuk</router-link>
        </div>
      </div>
      
    </div>
  </div>
</template>