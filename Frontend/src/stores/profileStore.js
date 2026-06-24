import { defineStore } from 'pinia'
import api from '@/utils/axios'

import { useLoadingStore } from './loadingStore'
import { useToastStore } from './toastStore'
import { useConfirmStore } from './confirmStore'

export const useProfileStore = defineStore('profile', {
  state: () => ({
    user: null,
    isLoading: false, 
  }),
  getters: {
    // 1. Cek apakah user sudah login
    isLoggedIn: (state) => !!state.user,

    // 2. Cek apakah user adalah admin
    isAdmin: (state) => state.user?.role === 'admin',

    // 3. Mengambil nama depan saja untuk ditampilkan di Navbar
    firstName: (state) => {
      return state.user?.name ? state.user.name.split(' ').slice(0, 2).join(' ') : 'User'
    },

    // 4. Menyusun URL Foto Profil secara dinamis
    profilePhotoUrl: (state) => {
      if (state.user?.foto_profil) {
        return `http://localhost:8000/api/v1/user/photo?t=${new Date().getTime()}`
      }
      const fallbackName = state.user?.name || 'User'
      return `https://ui-avatars.com/api/?name=${encodeURIComponent(fallbackName)}&background=5c814d&color=fff`
    }
  },

  actions: {
    // 1. Ambil Data User 
    async fetchUser() {
      this.isLoading = true
      try {
        const response = await api.get('/user/me')
        if (response.data.status === 'success') {
          this.user = response.data.data
        }
      } catch (error) {
        console.error('Error fetching user:', error)
      } finally {
        this.isLoading = false
      }
    },

    // 2. Update Data Profil 
    async updateProfile(formData) {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()

      loadingStore.startLoading()
      try {
        const response = await api.put('/user/profile', formData)
        if (response.data.status === 'success') {
          this.user = response.data.data
          toastStore.showToast(`✅ ${response.data.message || 'Profil berhasil diperbarui!'}`)
          return true
        }
      } catch (error) {
        console.error('Error updating profile:', error)
        toastStore.showToast('⚠️ Gagal memperbarui profil.')
        return false
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 3. Upload Foto Profil
    async uploadPhoto(file) {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()

      loadingStore.startLoading()
      try {
        const formData = new FormData()
        formData.append('foto_profil', file)

        const response = await api.post('/user/photo', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        if (response.data.status === 'success') {
          this.user = response.data.data
          toastStore.showToast(`✅ ${response.data.message || 'Foto profil berhasil diunggah!'}`)
        }
      } catch (error) {
        console.error('Error uploading photo:', error)
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Gagal mengunggah foto.'}`)
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 4. Hapus Foto Profil
    async deletePhoto() {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()
      const loadingStore = useLoadingStore()

      // Tampilkan Pop-Up Konfirmasi
      const isConfirmed = await confirmStore.ask({
        title: 'Hapus Foto Profil?',
        message: 'Apakah yakin ingin menghapus foto profil saat ini dan kembali menggunakan avatar inisial?'
      })

      if (!isConfirmed) return

      loadingStore.startLoading()
      try {
        const response = await api.delete('/user/photo')
        if (response.data.status === 'success') {
          this.user.foto_profil = null
          toastStore.showToast(`✅ ${response.data.message || 'Foto profil berhasil dihapus!'}`)
        }
      } catch (error) {
        console.error('Error deleting photo:', error)
        toastStore.showToast('⚠️ Gagal menghapus foto profil.')
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 5. Logout User 
    async logout() {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()
      const loadingStore = useLoadingStore()

      // Tampilkan Pop-Up Konfirmasi Keluar
      const isConfirmed = await confirmStore.ask({
        title: 'Konfirmasi Keluar',
        message: 'Apakah yakin ingin keluar dari akun MySawah saat ini?'
      })

      if (!isConfirmed) return false

      loadingStore.startLoading()
      try {
        await api.post('/logout')
        this.user = null
        localStorage.removeItem('user_role')
        
        toastStore.showToast('✅ Berhasil keluar. Sampai jumpa lagi!')
        return true
      } catch (error) {
        console.error('Logout error:', error)
        toastStore.showToast('⚠️ Terjadi kesalahan saat mencoba keluar.')
        return false
      } finally {
        loadingStore.stopLoading()
      }
    }
  }
})