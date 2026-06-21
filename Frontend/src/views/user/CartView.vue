<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '@/components/layout/Navbar.vue'
import Footer from '@/components/layout/Footer.vue'
import { useCartStore } from '@/stores/cartStore'

const router = useRouter()
const cartStore = useCartStore()

const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka || 0)
}

const handlePayment = async () => {
  const success = await cartStore.payOrder()
  if (success) {
    router.push('/') 
  }
}

onMounted(() => {
  cartStore.fetchCart()
})
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <div class="cart-container">
      <h2 class="cart-title">Keranjang Belanja</h2>

      <div v-if="cartStore.isCartEmpty" class="empty-cart-state">
        <div class="empty-icon">🛒</div>
        <h3>Keranjang Masih Kosong</h3>
        <p>Ayo cari bibit dan pupuk terbaik untuk sawah Anda!</p>
        <router-link to="/produk" class="btn-shop-now">Mulai Belanja</router-link>
      </div>

      <div v-else class="cart-content">
        
        <div class="cart-items-section">
          <div class="cart-header">
            <span>Daftar Produk</span>
            <button @click="cartStore.clearCart" class="btn-clear-cart">Kosongkan Keranjang</button>
          </div>

          <div class="item-list">
            <div v-for="item in cartStore.cartItems" :key="item.id_detail" class="cart-item-card">
              <img :src="item.produk?.gambar_produk" class="item-img" alt="" />
              
              <div class="item-details">
                <h4>{{ item.produk?.nama_produk || 'Produk Tidak Tersedia' }}</h4>
                <p class="item-price">{{ formatRupiah(item.harga_saat_beli) }}</p>
              </div>

              <div class="qty-controller">
                <button @click="cartStore.reduceItem(item.id_produk)" class="btn-qty">-</button>
                <span class="qty-number">{{ item.jumlah }}</span>
                <button @click="cartStore.addItem(item.id_produk, 1)" class="btn-qty">+</button>
              </div>

              <div class="item-total-price">
                {{ formatRupiah(item.jumlah * item.harga_saat_beli) }}
              </div>
            </div>
          </div>
        </div>

        <div class="cart-summary-section">
          <div class="summary-card">
            <h3>Ringkasan Belanja</h3>
            
            <div class="summary-row">
              <span>Total Harga ({{ cartStore.cartItems.length }} Barang)</span>
              <span>{{ formatRupiah(cartStore.cartTotal) }}</span>
            </div>
            
            <div class="summary-divider"></div>
            
            <div class="summary-row total-row">
              <span>Total Tagihan</span>
              <span>{{ formatRupiah(cartStore.cartTotal) }}</span>
            </div>

            <button @click="handlePayment" class="btn-checkout">Bayar Sekarang</button>
          </div>
        </div>

      </div>
    </div>
  </div>
<Footer />
</template>