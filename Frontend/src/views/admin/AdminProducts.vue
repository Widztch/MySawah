<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAdminProductStore } from '@/stores/adminProductStore'

import iconTrash from '@/assets/images/admin/trash.png'

const productStore = useAdminProductStore()

const showModal = ref(false)
const isEditing = ref(false)
const editId = ref(null)
const selectedFile = ref(null)

const formData = ref({
  nama_produk: '', harga: '', stok: '', deskripsi: '', kategori: 'Bibit tanaman'
})

const selectedProducts = ref([])

const isAllSelected = computed(() => {
  return productStore.products.length > 0 && selectedProducts.value.length === productStore.products.length
})

const toggleSelectAll = () => {
  if (isAllSelected.value) {
    selectedProducts.value = []
  } else {
    selectedProducts.value = productStore.products.map(p => p.id_produk)
  }
}

const handleBulkDelete = async () => {
  const success = await productStore.bulkDeleteProducts(selectedProducts.value)
  if (success) {
    selectedProducts.value = [] 
  }
}

const openAddModal = () => {
  isEditing.value = false
  editId.value = null
  formData.value = { nama_produk: '', harga: '', stok: '', deskripsi: '', kategori: 'Bibit tanaman' }
  selectedFile.value = null
  showModal.value = true
}

const openEditModal = (product) => {
  isEditing.value = true
  editId.value = product.id_produk
  formData.value = { 
    nama_produk: product.nama_produk, harga: product.harga, stok: product.stok, 
    deskripsi: product.deskripsi, kategori: product.kategori || 'Bibit tanaman'
  }
  selectedFile.value = null
  showModal.value = true
}

const closeModal = () => showModal.value = false
const handleFileUpload = (event) => selectedFile.value = event.target.files[0]

const submitForm = async () => {
  const data = new FormData()
  data.append('nama_produk', formData.value.nama_produk)
  data.append('harga', formData.value.harga)
  data.append('stok', formData.value.stok)
  data.append('deskripsi', formData.value.deskripsi)
  data.append('kategori', formData.value.kategori)
  if (selectedFile.value) data.append('gambar_produk', selectedFile.value)

  const isSuccess = await productStore.saveProduct(data, isEditing.value, editId.value)
  if (isSuccess) closeModal()
}

const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka || 0)
}

const changePage = (page) => {
  selectedProducts.value = []
  productStore.fetchProducts(page)
}

onMounted(() => {
  productStore.fetchProducts(1)
})
</script>

<template>
  <div class="admin-products">
    
    <div class="page-header animate-fade-up">
      <h2 class="page-title">Kelola Produk</h2>
      
      <div class="header-actions">
        <transition name="fade">
          <button 
            v-if="selectedProducts.length > 0" 
            @click="handleBulkDelete" 
            class="btn-bulk-delete"
          >
            <img :src="iconTrash" alt="Hapus" class="trash-icon" />
            Hapus Terpilih ({{ selectedProducts.length }})
          </button>
        </transition>
        
        <button @click="openAddModal" class="btn-primary">+ Tambah Produk Baru</button>
      </div>
    </div>

    <div class="table-container animate-fade-up" style="animation-delay: 0.1s;">
      <div v-if="productStore.isLoading" class="loading-state" style="padding: 30px; text-align: center;">Memuat data produk...</div>
      
      <table v-else class="data-table">
        <thead>
          <tr>
            <th style="width: 40px; text-align: center;">
              <input type="checkbox" class="select-checkbox" :checked="isAllSelected" @change="toggleSelectAll">
            </th>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in productStore.products" :key="product.id_produk" :class="{'row-selected': selectedProducts.includes(product.id_produk)}">
            <td style="text-align: center;">
              <input type="checkbox" class="select-checkbox" :value="product.id_produk" v-model="selectedProducts">
            </td>
            <td>
              <img :src="product.gambar_produk" :alt="product.nama_produk" class="table-img">
            </td>
            <td><strong>{{ product.nama_produk }}</strong></td>
            <td>{{ product.kategori || '-' }}</td>
            <td>{{ formatRupiah(product.harga) }}</td>
            <td>
              <span :class="['stok-badge', product.stok < 10 ? 'stok-low' : 'stok-ok']">
                {{ product.stok }}
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <button @click="openEditModal(product)" class="btn-edit">Edit</button>
                <button @click="productStore.deleteProduct(product.id_produk)" class="btn-delete">Hapus</button>
              </div>
            </td>
          </tr>
          <tr v-if="productStore.products.length === 0">
            <td colspan="7" class="text-center">Belum ada produk.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="pagination-wrapper animate-fade-up" style="animation-delay: 0.2s;" v-if="productStore.pagination.last_page > 1">
      <button 
        :disabled="productStore.pagination.current_page === 1" 
        @click="changePage(productStore.pagination.current_page - 1)"
        class="btn-page"
      >
        ‹ Sebelum
      </button>
      <span class="page-info">Halaman {{ productStore.pagination.current_page }} dari {{ productStore.pagination.last_page }}</span>
      <button 
        :disabled="productStore.pagination.current_page === productStore.pagination.last_page" 
        @click="changePage(productStore.pagination.current_page + 1)"
        class="btn-page"
      >
        Selanjutnya ›
      </button>
    </div>

    <div v-if="showModal" class="modal-overlay">
      <div class="modal-card animate-fade-up">
        <div class="modal-header">
          <h3>{{ isEditing ? 'Edit Produk' : 'Tambah Produk Baru' }}</h3>
          <button @click="closeModal" class="btn-close">×</button>
        </div>

        <form @submit.prevent="submitForm" class="modal-body">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" v-model="formData.nama_produk" required placeholder="Contoh: Pupuk NPK">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Kategori</label>
              <select v-model="formData.kategori" required>
                <option value="Bibit tanaman">Bibit tanaman</option>
                <option value="Pupuk">Pupuk</option>
                <option value="Pestisida">Pestisida</option>
                <option value="Vitamin">Vitamin</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Harga (Rp)</label>
              <input type="number" v-model="formData.harga" required min="0">
            </div>

            <div class="form-group">
              <label>Stok</label>
              <input type="number" v-model="formData.stok" required min="0">
            </div>
          </div>

          <div class="form-group">
            <label>Deskripsi Produk</label>
            <textarea v-model="formData.deskripsi" rows="4" required></textarea>
          </div>

          <div class="form-group">
            <label>Gambar Produk {{ isEditing ? '(Biarkan kosong jika tidak diganti)' : '' }}</label>
            <input type="file" @change="handleFileUpload" accept="image/jpeg, image/png, image/jpg" :required="!isEditing">
          </div>

          <div class="modal-footer">
            <button type="button" @click="closeModal" class="btn-cancel">Batal</button>
            <button type="submit" class="btn-save">{{ isEditing ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>