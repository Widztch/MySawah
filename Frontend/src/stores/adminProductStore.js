import { defineStore } from 'pinia'
import api from '@/utils/axios'

import { useConfirmStore } from './confirmStore'
import { useToastStore } from './toastStore'

export const useAdminProductStore = defineStore('adminProduct', {
  state: () => ({
    products: [],
    isLoading: false,
    pagination: {
      current_page: 1,
      last_page: 1
    }
  }),

  actions: {
    // 1. Ambil Data Produk (Dengan Paginasi)
    async fetchProducts(page = 1) {
      this.isLoading = true
      try {
        const response = await api.get(`/products?page=${page}`)
        
        if (response.data.status === 'success') {
          const paginatedData = response.data.data
          this.products = paginatedData.data || paginatedData // Menyesuaikan struktur data
          
          // Simpan data paginasi jika ada
          if (paginatedData.current_page) {
            this.pagination = {
              current_page: paginatedData.current_page,
              last_page: paginatedData.last_page
            }
          }
        }
      } catch (error) {
        console.error('Error fetching products:', error)
        const toastStore = useToastStore()
        toastStore.showToast('⚠️ Gagal mengambil data produk.')
      } finally {
        this.isLoading = false
      }
    },

    // 2. Simpan atau Update Produk (Menggunakan FormData)
    async saveProduct(formData, isEditing, editId) {
      const toastStore = useToastStore()

      try {
        let response;
        if (isEditing) {
          response = await api.post(`/admin/products/${editId}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
          })
        } else {
          response = await api.post('/admin/products', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
          })
        }

        if (response.data.status === 'success') {
          toastStore.showToast(`✅ ${response.data.message || 'Produk berhasil disimpan!'}`)
          this.fetchProducts(this.pagination.current_page)
          return true // Beri sinyal sukses ke komponen
        }
      } catch (error) {
        console.error('Error submitting form:', error)
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Terjadi kesalahan saat menyimpan data.'}`)
        return false // Beri sinyal gagal ke komponen
      }
    },

    // 3. Hapus Produk 
    async deleteProduct(id) {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()

      // Panggil Modal Konfirmasi Kustom
      const isConfirmed = await confirmStore.ask({
        title: 'Hapus Produk?',
        message: 'Apakah yakin ingin menghapus produk ini secara permanen?'
      })

      // Jika batal, hentikan eksekusi
      if (!isConfirmed) return

      try {
        const response = await api.delete(`/admin/products/${id}`)
        if (response.data.status === 'success') {
          toastStore.showToast(`✅ ${response.data.message || 'Produk berhasil dihapus!'}`)
          
          // Cek apakah halaman ini kosong setelah dihapus, jika ya mundur 1 halaman
          if (this.products.length === 1 && this.pagination.current_page > 1) {
            this.fetchProducts(this.pagination.current_page - 1)
          } else {
            this.fetchProducts(this.pagination.current_page)
          }
        }
      } catch (error) {
        console.error('Error deleting product:', error)
        toastStore.showToast('⚠️ Gagal menghapus produk.')
      }
    },

    // 4. Hapus Banyak Produk Sekaligus
    async bulkDeleteProducts(ids) {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()

      // Panggil Modal Konfirmasi Kustom
      const isConfirmed = await confirmStore.ask({
        title: 'Hapus Masal Produk?',
        message: `Apakah yakin ingin menghapus ${ids.length} produk yang dipilih secara permanen?`
      })

      // Jika batal, hentikan eksekusi
      if (!isConfirmed) return false

      this.isLoading = true
      try {
        // Menggunakan endpoint /bulk di backend dengan mengirimkan payload JSON { ids: [...] }
        const response = await api.delete('/admin/products/bulk', {
          data: { ids: ids } 
        })
        
        if (response.data.status === 'success') {
          toastStore.showToast(`✅ ${response.data.message || ids.length + ' produk berhasil dihapus!'}`)
          
          // Cek jika produk di halaman ini habis terhapus semua, mundur 1 halaman
          if (this.products.length === ids.length && this.pagination.current_page > 1) {
            this.fetchProducts(this.pagination.current_page - 1)
          } else {
            this.fetchProducts(this.pagination.current_page)
          }
          return true
        }
      } catch (error) {
        console.error('Error bulk deleting products:', error)
        toastStore.showToast(`⚠️ ${error.response?.data?.message || 'Terjadi kesalahan saat menghapus banyak produk.'}`)
        this.fetchProducts(this.pagination.current_page)
        return false
      } finally {
        this.isLoading = false
      }
    }
  }
})