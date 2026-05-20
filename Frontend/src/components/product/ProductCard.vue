<script setup>
defineProps({
  item: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="bg-white rounded-2xl p-4 shadow-sm relative group">
    <div class="w-full h-48 rounded-xl overflow-hidden mb-4 bg-gray-100">
      <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform" />
    </div>
    
    <h3 class="text-gray-900 font-bold mb-1">{{ item.title }}</h3>
    <p class="text-gray-900 font-bold mb-4">{{ item.price }}</p>
    
    <div class="flex items-center gap-1 text-sm font-bold text-gray-700 mb-2">
      <span class="text-[#e2ca46]">★</span> {{ item.rating }}
      
      <button class="ml-4 border border-gray-300 px-4 py-1 rounded text-xs text-gray-600 hover:border-gray-500">
        Lihat Detail
      </button>
    </div>

    <button class="absolute bottom-4 right-4 w-8 h-8 bg-[#e2ca46] rounded-full flex items-center justify-center hover:bg-[#cbb43b] transition">
      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
    </button>
  </div>
</template>