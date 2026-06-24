import { createRouter, createWebHistory } from 'vue-router'
import { useProfileStore } from '@/stores/profileStore'
import { useLoadingStore } from '@/stores/loadingStore'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import AboutView from '@/views/AboutView.vue'
import ProductView from '@/views/ProductView.vue'
import CartView from '@/views/user/CartView.vue'
import HistoryView from '../views/user/HistoryView.vue'
import UserProfile from '../views/user/UserProfile.vue'
import AdminLayout from '../components/layout/AdminLayout.vue'
import AdminDashboard from '../views/admin/AdminDashboard.vue'
import AdminProducts from '../views/admin/AdminProducts.vue'
import AdminOrders from '../views/admin/AdminOrders.vue'
import AILayout from '../components/layout/AILayout.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/tentang-kami',
      name: 'about',
      component: AboutView
    },
    {
      path: '/produk',
      name: 'produk',
      component: ProductView
    },
    {
      path: '/keranjang',
      name: 'cart',
      component: CartView,
      meta: { requiresAuth: true }
    },
    {
      path: '/riwayat-pesanan',
      name: 'order-history',
      component: HistoryView,
      meta: { requiresAuth: true }
    },
    {
      path: '/profil',
      name: 'user-profile',
      component: UserProfile,
      meta: { requiresAuth: true }
    },
    {
      path: '/admin',
      component: AdminLayout,
      meta: { requiresAdmin: true },
      children: [
        {
          path: 'dashboard',
          name: 'admin-dashboard',
          component: AdminDashboard
        },
        {
          path: 'products',
          name: 'admin-products',
          component: AdminProducts
        },
        {
          path: 'orders',
          name: 'admin-orders',
          component: AdminOrders
        },
      ]
    },
    {
      path: '/ai-assistant',
      component: AILayout,
      children: [
      ]
    },
  ]
})


// ==========================================
// NAVIGATION GUARD - SEBELUM MASUK HALAMAN
// ==========================================
router.beforeEach(async (to, from, next) => {
  // 1. HIDUPKAN LOADING SCREEN SAAT PINDAH HALAMAN
  const loadingStore = useLoadingStore()
  loadingStore.startLoading()  
  next()
})

// ==========================================
// SETELAH HALAMAN BERHASIL DIMUAT
// ==========================================
router.afterEach(() => {
  const loadingStore = useLoadingStore()
  
  // Matikan loading screen. 
  // Kita beri jeda sedikit (300ms) agar transisinya terasa lebih mulus dan tidak sekadar berkedip.
  setTimeout(() => {
    loadingStore.stopLoading()
  }, 300)
})


// ==========================================
// NAVIGATION GUARD 
// ==========================================
router.beforeEach(async (to, from, next) => {
  // Hanya jalankan pemeriksaan jika rute tersebut dilindungi
  if (to.meta.requiresAuth || to.meta.requiresAdmin) {
    const profileStore = useProfileStore()
    // 1. Jika data user belum termuat di memori (misal karena me-refresh halaman), 
    // kita paksa fetch data dari backend terlebih dahulu sebelum halaman dibuka.
    if (!profileStore.user) {
      await profileStore.fetchUser()
    }

    // 2. CEK PENYUSUP ADMIN PANEL
    if (to.meta.requiresAdmin && !profileStore.isAdmin) {
      // Jika bukan admin, Kirim ke halaman 404 NotFound seolah-olah agar halamannya tidak ada
      return next({ 
        name: 'login', 
        params: { pathMatch: to.path.substring(1).split('/') } 
      })
    }

    // 3. CEK PENGGUNA BELUM LOGIN
    if (to.meta.requiresAuth && !profileStore.isLoggedIn) {
      // Tampilkan peringatan lalu arahkan ke halaman login
      return next('/login') 
    }
  }
  // Jika semua pengecekan aman, izinkan lewat
  next()
})


export default router