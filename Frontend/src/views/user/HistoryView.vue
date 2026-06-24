<script setup>
import { onMounted } from 'vue'
import Navbar from '@/components/layout/Navbar.vue'
import { useHistoryStore } from '@/stores/historyStore'

const historyStore = useHistoryStore()

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
  historyStore.fetchHistory()
})
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <div class="history-container">
      <h2 class="page-title">Riwayat Pesanan</h2>

      <div v-if="historyStore.isHistoryEmpty" class="empty-state">
        <div class="empty-icon">🧾</div>
        <h3>Belum Ada Riwayat Pesanan</h3>
        <p>Anda belum pernah melakukan transaksi di MySawah.</p>
        <router-link to="/produk" class="btn-primary">Mulai Belanja Sekarang</router-link>
      </div>

      <div v-else class="history-list">
        
        <div v-for="order in historyStore.orders" :key="order.id_orders" class="order-card">
          <div class="order-header">
            <div class="header-left">
              <span class="order-id">#TRX-{{ order.id_orders }}</span>
              <span class="order-date">{{ formatDate(order.tanggal_transaksi) }}</span>
            </div>
            <div class="header-right">
              <span :class="['status-badge', order.status_order.toLowerCase()]">
                {{ order.status_order }}
              </span>
            </div>
          </div>

          <div class="order-body">
            <div v-for="item in order.details" :key="item.id_detail" class="item-row">
              <img :src="item.produk?.gambar_produk" class="item-img" alt="" />
              <div class="item-info">
                <h4>{{ item.produk?.nama_produk || 'Produk Tidak Tersedia' }}</h4>
                <p>{{ item.jumlah }} barang x {{ formatRupiah(item.harga_saat_beli) }}</p>
              </div>
            </div>
          </div>

          <div class="order-footer">
            <span class="total-label">Total Belanja</span>
            <span class="total-price">{{ formatRupiah(order.total_harga) }}</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>