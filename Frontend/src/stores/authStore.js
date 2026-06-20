import { defineStore } from 'pinia';
import api from '../utils/axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    isAuthenticated: false,
    loading: false,
    error: null,
  }),

  actions: {
    // Fungsi khusus Sanctum untuk mengambil CSRF cookie terlebih dahulu
    async getCsrfCookie() {
      // ini digunakan untuk mengambil cookie CSRF dari backend Laravel Sanctum sebelum melakukan login atau register, karena Laravel Sanctum memerlukan cookie ini untuk otentikasi yang aman.
      await api.get('http://localhost:8000/sanctum/csrf-cookie');
    },

    async login(email, password) {
      this.loading = true;
      this.error = null;
      
      try {
        await this.getCsrfCookie(); // Ambil cookie sebelum login
        
        const response = await api.post('/login', {
          email: email,
          password: password
        });

        if (response.data.status === 'success') {
          this.user = response.data.data;
          this.isAuthenticated = true;
          return true; // Beri sinyal sukses 
        }
      } catch (err) {
        this.error = err.response?.data?.message || 'Terjadi kesalahan saat login';
        return false; // Beri sinyal gagal
      } finally {
        this.loading = false;
      }
    },

    async register(name, email, password) {
      this.loading = true;
      this.error = null;
      
      try {
        await this.getCsrfCookie();
        
        const response = await api.post('/register', {
          name: name,
          email: email,
          password: password,
          password_confirmation: password // Pastikan konfirmasi password sesuai
        });

        if (response.data.status === 'success') {
          this.user = response.data.data;
          this.isAuthenticated = true;
          return true;
        }
      } catch (err) {
        this.error = err.response?.data?.message || 'Terjadi kesalahan saat mendaftar';
        return false;
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      try {
        await api.post('http://localhost:8000/api/v1/logout');
      } catch (error) {
        console.error('Logout error', error);
      } finally {
        this.user = null;
        this.isAuthenticated = false;
      }
    }
  }
});