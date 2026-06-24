import { defineStore } from 'pinia'
import api from '@/utils/axios'

import { useConfirmStore } from './confirmStore'
import { useToastStore } from './toastStore'

export const useAdminOrderStore = defineStore('adminOrder', {
  state: () => ({
    orders: [],
    pagination: {
      current_page: 1,
      last_page: 1
    },
    isLoading: false,
    activeStatus: '',
    statusOptions: ['PENDING', 'PAID', 'PROCESSED', 'SHIPPED', 'COMPLETED']
  }),

  actions: {
    // 1. Fungsi Mengambil Data Pesanan
    async fetchOrders(page = 1) {
      this.isLoading = true
      try {
        let url = `/admin/orders?page=${page}`
        if (this.activeStatus) {
          url += `&status=${this.activeStatus}`
        }

        const response = await api.get(url)
        
        if (response.data.status === 'success') {
          const paginatedData = response.data.data
          this.orders = paginatedData.data
          this.pagination = {
            current_page: paginatedData.current_page,
            last_page: paginatedData.last_page
          }
        }
      } catch (error) {
        console.error('Error fetching orders:', error)
        const toastStore = useToastStore()
        toastStore.showToast('⚠️ Gagal memuat daftar pesanan.')
      } finally {
        this.isLoading = false
      }
    },

    // 2. Fungsi Mengubah Status Pesanan
    async updateOrderStatus(orderId, newStatus) {
      const confirmStore = useConfirmStore()
      const toastStore = useToastStore()

      // Pemicu Modal Konfirmasi Kustom
      const isConfirmed = await confirmStore.ask({
        title: 'Ubah Status Pesanan?',
        message: `Apakah yakin ingin memperbarui status transaksi #TRX-${orderId} menjadi ${newStatus}?`
      })

      // Jika admin menekan tombol "Batal", hentikan proses eksekusi ke API
      if (!isConfirmed) {
        this.fetchOrders(this.pagination.current_page) // Muat ulang agar dropdown kembali ke status awal di UI
        return
      }

      try {
        const response = await api.put(`/admin/orders/${orderId}/status`, {
          status_order: newStatus
        })

        if (response.data.status === 'success') {
          toastStore.showToast(response.data.message || `Status #TRX-${orderId} berhasil diperbarui!`)
          this.fetchOrders(this.pagination.current_page) // Refresh halaman saat ini
        }
      } catch (error) {
        console.error('Error updating status:', error)
        toastStore.showToast(error.response?.data?.message || '⚠️ Gagal memperbarui status pesanan.')
        this.fetchOrders(this.pagination.current_page)
      }
    },

    // 3. Fungsi untuk mengganti filter status
    setActiveStatus(status) {
      this.activeStatus = status
      this.fetchOrders(1) // Kembalikan ke halaman 1 setiap kali filter berubah
    }
  }
})