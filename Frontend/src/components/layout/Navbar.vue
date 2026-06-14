<template>
  <nav class="navbar">

    <div class="logo-wrapper">
      <img :src="logo" alt="Logo MySawah" class="logo-img" />
      <span class="logo-text">MySawah</span>
    </div>

    <div class="nav-links">
      <a href="#">Beranda</a>
      <a href="#">Produk</a>
      <a href="#">AI Assistant</a>
      <a href="#">Tentang Kami</a>
    </div>

    <div class="nav-right">

      <div class="search-wrapper">
        <input
          type="text"
          class="search-input"
          placeholder="Cari produk..."
        />
        <img
          :src="searchIcon"
          alt="Search"
          class="search-icon"
        />
      </div>

      <div class="nav-actions">
        <img
          :src="cartIcon"
          alt="Cart"
          class="nav-icon-img"
        />

        <img
          :src="userIcon"
          alt="User"
          class="nav-icon-img"
        />
      </div>

    </div>

  </nav>
</template>

<script setup>
import logo from '@/assets/images/logo.png'
import searchIcon from '@/assets/images/mdi-light--magnify.svg'
import cartIcon from '@/assets/images/mdi-light--cart.svg'
import userIcon from '@/assets/images/mdi-light--account.svg'
</script>