<script setup>
defineProps({
  product: {
    type: Object,
    required: true
  }
})

// Fungsi untuk format uang ke Rupiah
const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { 
    style: 'currency', 
    currency: 'IDR', 
    minimumFractionDigits: 0 
  }).format(angka)
}

// Fungsi canggih untuk memformat angka terjual (misal: 1500 jadi 1,5rb)
const formatTerjual = (angka) => {
  if (!angka || angka === 0) return '0';
  if (angka >= 1000) {
    return (angka / 1000).toFixed(1).replace('.0', '') + 'rb+';
  }
  return angka;
}
</script>

<template>
  <router-link :to="`/produk/${product.id_produk}`" class="product-card">
    
    <div class="product-image-wrapper">
      <img :src="product.gambar_produk" :alt="product.nama_produk" class="product-image" />
    </div>

    <div class="product-info">
      <h3 class="product-title">{{ product.nama_produk }}</h3>
      <div class="product-price">{{ formatRupiah(product.harga) }}</div>
      
      <div class="product-category">
        {{ product.kategori || 'MySawah' }}
      </div>
      
      <div class="product-meta">
        <div class="product-stats">
          <span>Stok : {{ product.stok }}</span>
          <span class="dot-separator">•</span>
          
          <span>{{ formatTerjual(product.terjual) }} terjual</span>
          
        </div>
        <div class="more-options">...</div>
      </div>
    </div>

  </router-link>
</template>