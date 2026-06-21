import { defineStore } from 'pinia'

export const useToastStore = defineStore('toast', {
  state: () => ({
    show: false,
    message: '',
  }),
  actions: {
    showToast(msg) {
      this.message = msg
      this.show = true
      
      // Notifikasi akan otomatis hilang setelah 3 detik
      setTimeout(() => {
        this.show = false
      }, 3000)
    }
  }
})