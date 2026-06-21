import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import AboutView from '@/views/AboutView.vue'
import ProductView from '@/views/ProductView.vue'
import CartView from '@/views/user/CartView.vue'
import HistoryView from '../views/user/HistoryView.vue'

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
    },
  ]
})

export default router