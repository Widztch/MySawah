import axios from 'axios';

// Konfigurasi instance Axios
const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
  withCredentials: true,
  headers: { // ini digunakan untuk mengirimkan header yang diperlukan untuk otentikasi dan jenis konten
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
});

export default api;