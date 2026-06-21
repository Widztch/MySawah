<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '../components/layout/Navbar.vue'
import Footer from '@/components/layout/Footer.vue'
import ProductCard from '../components/product/ProductCard.vue'
import { useProductStore } from '@/stores/productStore'

const route = useRoute()
const productStore = useProductStore()

const categories = ['Semua', 'Bibit tanaman', 'Pupuk', 'Pestisida', 'Vitamin']
const activeCategory = ref('Semua')

// LOGIKA INFINITE SCROLL
const handleScroll = () => {
  const bottomOfWindow = document.documentElement.scrollTop + window.innerHeight >= document.documentElement.offsetHeight - 150

  if (bottomOfWindow && !productStore.isLoading && !productStore.isLoadingMore) {
    if (productStore.currentPage < productStore.lastPage) {
      const keyword = route.query.search || ''
      productStore.fetchProducts(productStore.currentPage + 1, keyword)
    }
  }
}

onMounted(() => {
  const keyword = route.query.search || ''
  productStore.fetchProducts(1, keyword)
  
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

// PANTAU PERUBAHAN PENCARIAN
watch(() => route.query.search, (newKeyword) => {
  productStore.fetchProducts(1, newKeyword || '')
  activeCategory.value = 'Semua'
})

// FILTER KATEGORI
const filteredProducts = computed(() => {
  if (activeCategory.value === 'Semua') {
    return productStore.products
  }
  return productStore.products.filter(product => product.kategori === activeCategory.value)
})
</script>

<template>
  <div class="page-wrapper">
    <Navbar />

    <div class="product-container">
      
      <div class="category-scroll animate-fade-up">
        <button 
          v-for="cat in categories" 
          :key="cat"
          :class="['category-btn', { active: activeCategory === cat }]"
          @click="activeCategory = cat"
        >
          {{ cat }}
        </button>
      </div>

      <div v-if="productStore.isLoading" class="loading-state animate-fade-up" style="animation-delay: 0.1s;">
        <p>Menyiapkan produk terbaik dari MySawah...</p>
      </div>
      
      <div v-else-if="productStore.error" class="error-state animate-fade-up">
        <p>{{ productStore.error }}</p>
      </div>
      
      <div v-else-if="filteredProducts.length === 0" class="empty-state animate-fade-up">
        <p>Belum ada produk untuk pencarian atau kategori ini.</p>
      </div>

      <div v-else>
        <div class="product-grid" :key="activeCategory">
          <ProductCard 
            v-for="product in filteredProducts" 
            :key="product.id_produk" 
            :product="product"
            class="animate-fade-up" 
          />
        </div>

        <div v-if="productStore.isLoadingMore" class="loading-more">
          Mengambil produk lainnya...
        </div>
        
        <div v-if="productStore.currentPage === productStore.lastPage && !productStore.isLoading" class="end-of-data">
          Semua produk telah ditampilkan.
        </div>
      </div>
    </div>
    
  </div>
</template>