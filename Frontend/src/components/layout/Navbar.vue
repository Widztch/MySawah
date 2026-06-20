<template>
  <header class="navbar">
    <div class="navbar-container">

      <!-- LOGO -->
      <div class="logo-wrapper">
        <img src="../../assets/images/logo.png" alt="MySawah Logo" class="logo-img" />
        <span class="logo-text">MySawah</span>
      </div>

      <!-- MENU -->
      <nav class="nav-menu">
        <a href="#">Beranda</a>
        <a href="#">Produk</a>
        <a href="#">AI Assistant</a>
        <a href="#">Tentang Kami</a>
      </nav>

      <!-- RIGHT -->
      <div class="navbar-right">
        <!-- BUNGKUSAN BARU UNTUK SEARCH -->
        <div class="search-wrapper">
          <input
            type="text"
            placeholder="Ketik Cari..."
            class="search-input"
          />
          <img src="../../assets/images/mdi-light--magnify.svg" alt="Search" class="search-icon" />
        </div>

        <!-- IKON SVG LAINNYA -->
        <img src="../../assets/images/mdi-light--cart.svg" alt="Cart" class="nav-icon-img" />
        <img src="../../assets/images/mdi-light--account.svg" alt="User Profile" class="nav-icon-img" />
      </div>

    </div>
  </header>
</template>