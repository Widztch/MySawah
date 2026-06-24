<script setup>
import { computed, onMounted, watch, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Navbar from '../components/layout/Navbar.vue'
import ProductCard from '../components/product/ProductCard.vue'
import Footer from '@/components/layout/Footer.vue'

import { useProductStore } from '@/stores/productStore'
import { useCartStore } from '@/stores/cartStore'
import { useToastStore } from '@/stores/toastStore'
import { useProfileStore } from '@/stores/profileStore'

const route = useRoute()
const router = useRouter()
const productStore = useProductStore()
const cartStore = useCartStore()
const toastStore = useToastStore()
const profileStore = useProfileStore()
const quantity = ref(1)

const increaseQuantity = () => {
  if (quantity.value < productStore.productDetail.stok) {
    quantity.value++
  } else {
    toastStore.showToast('⚠️ Jumlah melebihi stok yang tersedia.')
  }
}

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}


onMounted(() => {
  productStore.fetchProductDetail(route.params.id)
  
  if (productStore.products.length === 0) {
    productStore.fetchProducts(1)
  }
})

watch(() => route.params.id, (newId) => {
  if (newId) {
    productStore.fetchProductDetail(newId)
    quantity.value = 1 
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
})

const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka || 0)
}

const formatTerjual = (angka) => {
  if (!angka || angka === 0) return '0';
  if (angka >= 1000) {
    return (angka / 1000).toFixed(1).replace('.0', '') + 'rb+';
  }
  return angka;
}

const relatedProducts = computed(() => {
  return productStore.products
    .filter(p => p.id_produk !== Number(route.params.id))
    .slice(0, 5)
})

const checkUserCompleteProfile = () => {
  const user = profileStore.user
  if (!user || !user.alamat || !user.no_hp) {
    toastStore.showToast('⚠️ Anda harus melengkapi Alamat dan Nomor HP di Profil sebelum berbelanja.')
    router.push('/profil')
    return false
  }
  return true
}

const handleAddToCart = async () => {
  if (!profileStore.isLoggedIn) {
    toastStore.showToast('⚠️ Anda harus login terlebih dahulu untuk mulai belanja!')
    router.push('/login')
    return
  }

  if (!checkUserCompleteProfile()) return;

  const idProduk = productStore.productDetail.id_produk
  await cartStore.addItem(idProduk, quantity.value) 
  
  toastStore.showToast(`✅ ${quantity.value} ${productStore.productDetail.nama_produk} masuk keranjang!`)
}

const handleBuyNow = async () => {
  if (!profileStore.isLoggedIn) {
    toastStore.showToast('⚠️ Anda harus login terlebih dahulu untuk mulai belanja!')
    router.push('/login')
    return
  }

  if (!checkUserCompleteProfile()) return;

  const idProduk = productStore.productDetail.id_produk
  await cartStore.addItem(idProduk, quantity.value)
  
  router.push('/keranjang')
}
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <div class="detail-container">
      
      <div v-if="productStore.isDetailLoading" class="loading-state">
        Memuat detail produk...
      </div>
      <div v-else-if="productStore.error" class="error-state">
        {{ productStore.error }}
      </div>

      <div v-else-if="productStore.productDetail" class="product-detail-card animate-fade-up">
        
        <div class="detail-image-box">
          <img :src="productStore.productDetail.gambar_produk" :alt="productStore.productDetail.nama_produk" class="detail-image">
        </div>

        <div class="detail-info-box">
          <h1 class="detail-title">{{ productStore.productDetail.nama_produk }}</h1>
          
          <div class="detail-price-box">
            <div class="detail-price">{{ formatRupiah(productStore.productDetail.harga) }}</div>
          </div>
          
          <div class="detail-stats">
            <span class="stat-item">Stok: <strong>{{ productStore.productDetail.stok }}</strong></span>
            <span class="dot-separator">•</span>
            <span class="stat-item">Terjual {{ formatTerjual(productStore.productDetail.terjual) }}</span>
          </div>

          <div class="detail-desc-box">
            <h3>Deskripsi Produk</h3>
            <p class="detail-desc">{{ productStore.productDetail.deskripsi }}</p>
          </div>

          <div class="quantity-section">
            <label>Atur Jumlah:</label>
            <div class="qty-controls">
              <button @click="decreaseQuantity" :disabled="quantity <= 1" class="qty-btn">-</button>
              <span class="qty-number">{{ quantity }}</span>
              <button @click="increaseQuantity" :disabled="quantity >= productStore.productDetail.stok" class="qty-btn">+</button>
            </div>
          </div>

          <div class="detail-actions">
            <button @click="handleAddToCart" class="btn-cart">Masukkan Keranjang</button>
            <button @click="handleBuyNow" class="btn-buy">Beli Sekarang</button>
          </div>
        </div>

      </div>

      <div class="related-section animate-fade-up" style="animation-delay: 0.2s;" v-if="relatedProducts.length > 0">
        <h2 class="related-title">Produk Lainnya</h2>
        <div class="product-grid">
          <ProductCard 
            v-for="product in relatedProducts" 
            :key="product.id_produk" 
            :product="product"
          />
        </div>
      </div>

    </div>
  </div>
  <Footer />
</template>