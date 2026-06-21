import { defineStore } from 'pinia'
import api from '@/utils/axios'
import { useLoadingStore } from './loadingStore'

import { useConfirmStore } from './confirmStore'
import { useToastStore } from './toastStore'

export const useCartStore = defineStore('cart', {
  state: () => ({
    cartData: null, // Akan menyimpan object
  }),

  getters: {
    cartItems: (state) => state.cartData?.items || [],
    cartTotal: (state) => state.cartData?.total_harga || 0,
    cartId: (state) => state.cartData?.id_orders || null,
    isCartEmpty: (state) => !state.cartData || state.cartData.items.length === 0
  },

  actions: {
    // 1. Ambil Data Keranjang Saat Ini
    async fetchCart() {
      const loadingStore = useLoadingStore()
      loadingStore.startLoading()
      try {
        const response = await api.get('/cart')
        if (response.data.status === 'success') {
          this.cartData = response.data.data // Bisa bernilai null jika kosong
        }
      } catch (error) {
        console.error('Error fetching cart:', error)
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 2. Tambah Barang (Tombol '+' di keranjang)
    async addItem(idProduk, jumlah = 1) {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()
      loadingStore.startLoading()
      try {
        const response = await api.post('/checkout', {
          items: [{ id_produk: idProduk, jumlah: jumlah }]
        })
        if (response.data.status === 'success') {
          await this.fetchCart() // Refresh keranjang setelah sukses
        }
      } catch (error) {
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Gagal menambah barang.'}`)
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 3. Kurangi Barang (Tombol '-' di keranjang)
    async reduceItem(idProduk) {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()
      loadingStore.startLoading()
      try {
        const response = await api.post('/cart/reduce', { id_produk: idProduk })
        if (response.data.status === 'success') {
          await this.fetchCart() // Refresh keranjang setelah sukses
        }
      } catch (error) {
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Gagal mengurangi barang.'}`)
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 4. Kosongkan Keranjang
    async clearCart() {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()

      // Panggil Modal Konfirmasi Kustom
      const isConfirmed = await confirmStore.ask({
        title: 'Kosongkan Keranjang?',
        message: 'Apakah yakin ingin mengeluarkan semua produk dari keranjang belanja?'
      })

      if (!isConfirmed) return

      const loadingStore = useLoadingStore()
      loadingStore.startLoading()
      try {
        const response = await api.delete('/cart/clear')
        if (response.data.status === 'success') {
          this.cartData = null
          toastStore.showToast('✅ Keranjang berhasil dikosongkan.')
        }
      } catch (error) {
        toastStore.showToast('⚠️ Gagal mengosongkan keranjang.')
      } finally {
        loadingStore.stopLoading()
      }
    },

    // 5. Bayar Tagihan
    async payOrder() {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()

      // Panggil Modal Konfirmasi Kustom
      const isConfirmed = await confirmStore.ask({
        title: 'Konfirmasi Pembayaran',
        message: 'Apakah yakin ingin memproses pembayaran pesanan ini sekarang?'
      })

      if (!isConfirmed) return false

      const loadingStore = useLoadingStore()
      loadingStore.startLoading()
      try {
        const response = await api.post('/pay')
        if (response.data.status === 'success') {
          this.cartData = null // Keranjang kosong setelah dibayar
          toastStore.showToast('✅ Pembayaran Berhasil! Pesanan segera diproses.')
          return true
        }
      } catch (error) {
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Pembayaran gagal.'}`)
        return false
      } finally {
        loadingStore.stopLoading()
      }
    }
  }
})