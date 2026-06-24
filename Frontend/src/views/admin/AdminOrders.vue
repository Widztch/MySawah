<script setup>
import { ref, onMounted } from 'vue'
import { useAdminOrderStore } from '@/stores/adminOrderStore'

import iconEye from '@/assets/images/navbar/magnifying-glass.png' 

const orderStore = useAdminOrderStore()

const showDetailModal = ref(false)
const selectedOrderDetails = ref([])

const openDetailModal = (details) => {
  selectedOrderDetails.value = details
  showDetailModal.value = true
}

const closeDetailModal = () => {
  showDetailModal.value = false
  selectedOrderDetails.value = []
}

const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka || 0)
}

const formatDate = (dateString) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID', {
    day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
  })
}

onMounted(() => {
  orderStore.fetchOrders(1)
})
</script>

<template>
  <div class="admin-orders">
    <h2 class="page-title animate-fade-up">Kelola Pesanan</h2>

    <div class="status-tabs animate-fade-up" style="animation-delay: 0.1s;">
      <button 
        :class="['tab-btn', { active: orderStore.activeStatus === '' }]"
        @click="orderStore.setActiveStatus('')"
      >
        Semua Pesanan
      </button>
      <button 
        v-for="status in orderStore.statusOptions" 
        :key="status"
        :class="['tab-btn', `tab-${status.toLowerCase()}`, { active: orderStore.activeStatus === status }]"
        @click="orderStore.setActiveStatus(status)"
      >
        {{ status }}
      </button>
    </div>

    <div class="table-container animate-fade-up" style="animation-delay: 0.2s;">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>Total Bayar</th>
            <th>Status</th>
            <th>Item</th>
            <th>Aksi Pengiriman</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orderStore.orders" :key="order.id_orders">
            <td><strong>#TRX-{{ order.id_orders }}</strong></td>
            <td>{{ formatDate(order.tanggal_transaksi || order.created_at) }}</td>
            <td class="text-price">{{ formatRupiah(order.total_harga) }}</td>
            <td>
              <span :class="['status-badge', order.status_order.toLowerCase()]">
                {{ order.status_order }}
              </span>
            </td>
            <td>
              <button @click="openDetailModal(order.details)" class="btn-view-items">
                <img :src="iconEye" alt="Lihat" class="eye-icon" /> 
                Lihat ({{ order.details?.length || 0 }} Item)
              </button>
            </td>
            <td>
              <select 
                :value="order.status_order"
                @change="orderStore.updateOrderStatus(order.id_orders, $event.target.value)"
                class="status-select"
              >
                <option v-for="status in orderStore.statusOptions" :key="status" :value="status">
                  Set ke {{ status }}
                </option>
              </select>
            </td>
          </tr>
          <tr v-if="orderStore.orders.length === 0">
            <td colspan="6" class="text-center">Tidak ada pesanan dengan status "{{ orderStore.activeStatus || 'Semua' }}".</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="pagination-wrapper animate-fade-up" style="animation-delay: 0.3s;" v-if="orderStore.pagination.last_page > 1">
      <button 
        :disabled="orderStore.pagination.current_page === 1" 
        @click="orderStore.fetchOrders(orderStore.pagination.current_page - 1)"
        class="btn-page"
      >
        ‹ Sebelum
      </button>
      <span class="page-info">Halaman {{ orderStore.pagination.current_page }} dari {{ orderStore.pagination.last_page }}</span>
      <button 
        :disabled="orderStore.pagination.current_page === orderStore.pagination.last_page" 
        @click="orderStore.fetchOrders(orderStore.pagination.current_page + 1)"
        class="btn-page"
      >
        Selanjutnya ›
      </button>
    </div>

    <div v-if="showDetailModal" class="modal-overlay">
      <div class="modal-card animate-fade-up">
        <div class="modal-header">
          <h3>Detail Item Pesanan</h3>
          <button @click="closeDetailModal" class="btn-close">×</button>
        </div>
        
        <div class="modal-body">
          <div class="item-list">
            <div v-for="item in selectedOrderDetails" :key="item.id_detail" class="item-row">
              <img :src="item.produk?.gambar_produk" class="item-img" alt="" />
              
              <div class="item-info">
                <h4>{{ item.produk?.nama_produk || 'Produk Terhapus' }}</h4>
                <p>{{ item.jumlah }} barang x {{ formatRupiah(item.harga_saat_beli || item.produk?.harga) }}</p>
              </div>
              
              <div class="item-total">
                {{ formatRupiah((item.jumlah) * (item.harga_saat_beli || item.produk?.harga || 0)) }}
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button @click="closeDetailModal" class="btn-primary">Tutup</button>
        </div>
      </div>
    </div>

  </div>
</template>