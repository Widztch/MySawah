<template>
  <footer class="bg-white border-t border-gray-100 mt-10">
    <div class="bg-[#92c37e] px-6 md:px-12 py-3 flex justify-between items-center text-xs font-bold text-[#3d5a31] uppercase">
      <div class="flex gap-4">
        <a href="#">FARMERS</a> • <a href="#">ORGANIC</a> • <a href="#">FOODS</a> • <a href="#">PRODUCT</a>
      </div>
      <div class="flex gap-2">
        <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-green-700">📞</button>
        <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-green-700">✉️</button>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-5 gap-8">
      <div class="md:col-span-2">
        <div class="flex items-center gap-2 mb-4">
          <span class="w-6 h-6 bg-[#598348] text-white rounded-full flex items-center justify-center text-xs">🍃</span>
          <span class="font-bold text-gray-900">MySawah</span>
        </div>
        <p class="text-gray-500 text-xs leading-relaxed max-w-xs">
          Platform Pertanian cerdas yang menghubungkan petani dengan produk terbaik dan teknologi AI
        </p>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 mb-4">Navigasi</h4>
        <ul class="text-xs text-gray-500 space-y-2">
          <li><a href="#">Beranda</a></li>
          <li><a href="#">Produk</a></li>
          <li><a href="#">AI Assistant</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 mb-4">Bantuan</h4>
        <ul class="text-xs text-gray-500 space-y-2">
          <li><a href="#">Cara Belanja</a></li>
          <li><a href="#">Pengiriman</a></li>
          <li><a href="#">Pembayaran</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-sm text-gray-900 mb-4">Kontak</h4>
        <ul class="text-xs text-gray-500 space-y-2">
          <li><a href="#">Email</a></li>
          <li><a href="#">WhatsApp</a></li>
          <li><a href="#">Alamat</a></li>
        </ul>
      </div>
    </div>

    <div class="text-center py-4 border-t border-gray-100 text-[10px] text-gray-400">
      Copyright © 2024 MySawah, All Rights Reserved.
    </div>
  </footer>
</template>