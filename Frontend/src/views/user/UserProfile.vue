<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '@/components/layout/Navbar.vue'
import { useProfileStore } from '@/stores/profileStore'

const router = useRouter()
const profileStore = useProfileStore()

const formData = ref({
  name: '',
  no_hp: '',
  alamat: ''
})

// Sinkronisasi data 
const syncData = () => {
  if (profileStore.user) {
    formData.value = {
      name: profileStore.user.name || '',
      no_hp: profileStore.user.no_hp || '',
      alamat: profileStore.user.alamat || ''
    }
  }
}

watch(() => profileStore.user, syncData)

// Menghasilkan URL Foto yang Dinamis
const profilePhotoUrl = computed(() => {
  if (profileStore.user?.foto_profil) {
    // Karena kredensial aktif, kita bisa langsung tembak API getPhoto. 
    return `http://localhost:8000/api/v1/user/photo?t=${new Date().getTime()}`
  }
  const fallbackName = profileStore.user?.name || 'User'
  return `https://ui-avatars.com/api/?name=${encodeURIComponent(fallbackName)}&background=5c814d&color=fff&size=180`
})

// Eksekusi Form & Tombol
const handlePhotoUpload = async (event) => {
  const file = event.target.files[0]
  if (file) {
    await profileStore.uploadPhoto(file)
  }
}

const saveProfile = async () => {
  await profileStore.updateProfile(formData.value)
}

const handleLogout = async () => {
  const success = await profileStore.logout()
  if (success) {
    router.push('/login')
  }
}

onMounted(async () => {
  if (!profileStore.user) {
    await profileStore.fetchUser()
  }
  syncData()
})
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <div class="profile-container">
      <h2 class="profile-title">Pengaturan Profil</h2>

      <div v-if="profileStore.isLoading && !profileStore.user" class="loading-overlay">
        Memuat data profil...
      </div>

      <div v-else-if="profileStore.user" class="profile-card">
        
        <div class="profile-photo-section">
          <div class="photo-wrapper">
            <img :src="profilePhotoUrl" alt="Foto Profil" class="profile-img" />
          </div>

          <div class="photo-actions">
            <div class="btn-upload-wrapper">
              <button class="btn-upload">Ganti Foto Profil</button>
              <input type="file" @change="handlePhotoUpload" accept="image/jpeg, image/png, image/jpg" />
            </div>
            
            <button 
              v-if="profileStore.user.foto_profil" 
              @click="profileStore.deletePhoto" 
              class="btn-delete-photo"
            >
              Hapus Foto
            </button>
          </div>
        </div>

        <form @submit.prevent="saveProfile" class="profile-form-section">
          
          <div class="form-group">
            <label>Email (Tidak bisa diubah)</label>
            <input type="email" :value="profileStore.user.email" disabled />
          </div>

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" v-model="formData.name" required placeholder="Masukkan nama lengkap Anda" />
          </div>

          <div class="form-group">
            <label>Nomor Handphone (WhatsApp)</label>
            <input type="text" v-model="formData.no_hp" placeholder="Contoh: 08123456789" />
          </div>

          <div class="form-group">
            <label>Alamat Lengkap Pengiriman</label>
            <textarea v-model="formData.alamat" rows="4" placeholder="Tuliskan detail jalan, RT/RW, desa, kecamatan, dan kode pos..."></textarea>
          </div>

          <div class="form-actions">
            <button type="button" @click="handleLogout" class="btn-logout">Keluar Akun</button>
            <button type="submit" class="btn-save" :disabled="profileStore.isLoading">
              {{ profileStore.isLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>