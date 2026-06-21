import { defineStore } from 'pinia'

export const useConfirmStore = defineStore('confirm', {
  state: () => ({
    isOpen: false,
    title: 'Konfirmasi Tindakan',
    message: '',
    resolvePromise: null // Menyimpan fungsi resolusi Promise
  }),

  actions: {
    // Fungsi pemicu untuk membuka modal konfirmasi
    ask({ title = 'Konfirmasi', message }) {
      this.title = title
      this.message = message
      this.isOpen = true

      // Mengembalikan Promise agar bisa ditunggu (awaited) di komponen/store lain
      return new Promise((resolve) => {
        this.resolvePromise = resolve
      })
    },

    // Jika Admin/User klik "Ya, Lanjutkan"
    accept() {
      this.isOpen = false
      if (this.resolvePromise) this.resolvePromise(true)
    },

    // Jika Admin/User klik "Batal"
    cancel() {
      this.isOpen = false
      if (this.resolvePromise) this.resolvePromise(false)
    }
  }
})