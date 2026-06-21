<script setup="setup">
    import Footer from '@/components/layout/Footer.vue'
    import logoImg from '@/assets/images/logo/logo.png'
    import iconFarmer from '@/assets/images/about-hero/icon/icon-farmer2.png'
    import iconCheck from '@/assets/images/about-hero/icon/icon-check.png'
    import iconThumbs from '@/assets/images/about-hero/icon/icon-thumbs.png'
    import iconGlobe from '@/assets/images/about-hero/icon/icon-globe.png'
    import gallery1 from '@/assets/images/about-hero/gallery/gallery-1.png'
    import gallery2 from '@/assets/images/about-hero/gallery/gallery-2.png'
    import gallery3 from '@/assets/images/about-hero/gallery/gallery-3.png'
    import gallery4 from '@/assets/images/about-hero/gallery/gallery-4.png'
</script>

<template>
    <section class="about-section">

        <!-- ================================= -->
        <!-- TITLE -->
        <!-- ================================= -->
        <div class="about-header animate-on-scroll">
            <h2 class="about-title">Tentang MySawah</h2>
            <p class="about-description">
                MySawah hadir untuk membantu petani Indonesia mendapatkan produk terbaik,
                rekomendasi cerdas, dan solusi berbasis teknologi untuk pertanian yang lebih
                maju.
            </p>
        </div>

        <!-- ================================= -->
        <!-- CONTENT -->
        <!-- ================================= -->
        <div class="about-content">

            <!-- LEFT SIDE -->
            <div class="about-side">
                <!-- ITEM 1 -->
                <div class="about-item animate-on-scroll" style="transition-delay: 100ms;">
                    <div class="about-icon green">
                        <img :src="iconFarmer" alt="Petani" class="stat-icon-img"/>
                    </div>
                    <div>
                        <h3 class="about-number">10.000 +</h3>
                        <p class="about-text">Petani Terdaftar</p>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="about-item animate-on-scroll" style="transition-delay: 300ms;">
                    <div class="about-icon light">
                        <img :src="iconCheck" alt="Produk" class="stat-icon-img"/>
                    </div>
                    <div>
                        <h3 class="about-number">500 +</h3>
                        <p class="about-text">Produk Berkualitas</p>
                    </div>
                </div>
            </div>

            <!-- ================================= -->
            <!-- CENTER LOGO -->
            <!-- ================================= -->
            <div class="about-center animate-on-scroll" style="transition-delay: 500ms;">
                <div class="about-logo-circle">
                    <img :src="logoImg" alt="MySawah Logo" class="about-logo"/>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="about-side">
                <!-- ITEM 3 -->
                <div class="about-item animate-on-scroll" style="transition-delay: 200ms;">
                    <div class="about-icon light">
                        <img :src="iconThumbs" alt="Kepuasan" class="stat-icon-img"/>
                    </div>
                    <div>
                        <h3 class="about-number">99 %</h3>
                        <p class="about-text">Kepuasan Petani</p>
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="about-item animate-on-scroll" style="transition-delay: 400ms;">
                    <div class="about-icon light">
                        <img :src="iconGlobe" alt="Indonesia" class="stat-icon-img"/>
                    </div>
                    <div>
                        <h3 class="about-number">Seluruh</h3>
                        <p class="about-text">Indonesia</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================================= -->
        <!-- GALLERY -->
        <!-- ================================= -->
        <div class="gallery-grid">

            <div class="gallery-wrapper animate-on-scroll" style="transition-delay: 100ms;">
                <img :src="gallery1" alt="Galeri 1" class="gallery-image"/>
            </div>

            <div class="gallery-wrapper animate-on-scroll" style="transition-delay: 300ms;">
                <img :src="gallery2" alt="Galeri 2" class="gallery-image"/>
            </div>

            <div class="gallery-wrapper animate-on-scroll" style="transition-delay: 500ms;">
                <img :src="gallery3" alt="Galeri 3" class="gallery-image"/>
            </div>

            <div class="gallery-wrapper animate-on-scroll" style="transition-delay: 700ms;">
                <img :src="gallery4" alt="Galeri 4" class="gallery-image"/>
            </div>

        </div>
    </section>
    <Footer/>
</template>