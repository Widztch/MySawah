<template>
  <nav class="bg-white px-6 md:px-12 py-4 flex items-center justify-between sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <span class="w-6 h-6 bg-[#598348] text-white rounded-full flex items-center justify-center text-xs">🍃</span>
      <span class="font-bold text-gray-900 text-lg">MySawah</span>
    </div>

    <ul class="hidden md:flex items-center gap-8 text-sm text-gray-600">
      <li><a href="#" class="text-gray-900 font-medium">Beranda</a></li>
      <li><a href="#" class="hover:text-gray-900">Produk</a></li>
      <li><a href="#" class="hover:text-gray-900">AI Assistant</a></li>
      <li><a href="#" class="hover:text-gray-900">Tentang kami</a></li>
    </ul>

    <div class="flex items-center gap-4">
      <div class="border border-gray-300 rounded-md px-3 py-1.5 flex items-center">
        <input type="text" placeholder="Ketik Pesan..." class="outline-none text-xs w-32" />
        <span class="text-gray-500 text-sm">🔍</span>
      </div>
      <button class="text-gray-700">🛒</button>
      <button class="text-gray-700">👤</button>
    </div>
  </nav>
</template>