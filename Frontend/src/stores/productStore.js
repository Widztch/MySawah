import { defineStore } from 'pinia'
import api from '../utils/axios'

import { useLoadingStore } from './loadingStore'
import { useToastStore } from './toastStore'

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
    isLoading: false,
    isLoadingMore: false, 
    error: null,
    currentPage: 1,
    lastPage: 1,
    productDetail: null,
    isDetailLoading: false,
  }),
  
  actions: {
    // 1. Ambil Data Daftar Produk (DENGAN PARAMETER PENCARIAN)
    async fetchProducts(page = 1, searchKeyword = '') {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()

      if (page === 1) {
        this.isLoading = true
        loadingStore.startLoading()
      } else {
        this.isLoadingMore = true
      }
      this.error = null

      try {
        // SISIPKAN KEYWORD PENCARIAN KE URL API
        let url = `/products?page=${page}`
        if (searchKeyword && searchKeyword.trim() !== '') {
          // encodeURIComponent berguna jika ada spasi, misal mencari "bibit padi"
          url += `&search=${encodeURIComponent(searchKeyword.trim())}`
        }

        const response = await api.get(url)
        
        if (response.data.status === 'success') {
          const paginationData = response.data.data
          
          if (page === 1) {
            // Jika halaman 1 (atau saat pencarian baru), bersihkan data lama
            this.products = paginationData.data
          } else {
            // Jika Load More, gabungkan data baru
            this.products = [...this.products, ...paginationData.data]
          }

          this.currentPage = paginationData.current_page
          this.lastPage = paginationData.last_page
        } else {
          this.error = response.data.message || 'Gagal mengambil produk.'
          toastStore.showToast(`⚠️ ${this.error}`)
        }
      } catch (err) {
        console.error('Error fetching products:', err)
        this.error = 'Gagal terhubung ke server Backend.'
        toastStore.showToast('⚠️ Gagal memuat daftar produk.')
      } finally {
        this.isLoading = false
        this.isLoadingMore = false
        if (page === 1) {
          loadingStore.stopLoading() 
        }
      }
    },

    // 2. Ambil Data Detail Satu Produk
    async fetchProductDetail(id) {
      const loadingStore = useLoadingStore()
      const toastStore = useToastStore()

      this.isDetailLoading = true
      this.productDetail = null
      this.error = null
      
      loadingStore.startLoading() 

      try {
        const response = await api.get(`/products/${id}`)
        
        if (response.data.status === 'success') {
          this.productDetail = response.data.data
        } else {
          this.error = response.data.message || 'Gagal memuat detail produk.'
          toastStore.showToast(`⚠️ ${this.error}`)
        }
      } catch (err) {
        console.error('Error fetching detail:', err)
        this.error = 'Detail produk tidak ditemukan atau server bermasalah.'
        toastStore.showToast('⚠️ Detail produk tidak ditemukan.')
      } finally {
        this.isDetailLoading = false
        loadingStore.stopLoading()
      }
    }

  }
})