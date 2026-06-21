import { defineStore } from 'pinia'
import api from '@/utils/axios'
import { useLoadingStore } from './loadingStore'
import { useToastStore } from './toastStore'

export const useHistoryStore = defineStore('history', {
  state: () => ({
    orders: []
  }),

  getters: {
    isHistoryEmpty: (state) => state.orders.length === 0
  },

  actions: {
    async fetchHistory() {
      const loadingStore = useLoadingStore()
      loadingStore.startLoading()
      try {
        const response = await api.get('/history')
        if (response.data.status === 'success') {
          this.orders = response.data.data
        }
      } catch (error) {
        console.error('Error fetching history:', error)
        
        const toastStore = useToastStore()
        toastStore.showToast('⚠️ Gagal memuat riwayat pesanan.')
      } finally {
        loadingStore.stopLoading()
      }
    }
  }
})