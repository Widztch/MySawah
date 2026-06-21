<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    // ==========================================================
    // 1. LIHAT SEMUA PESANAN (Katalog Order)
    // ==========================================================
    public function index(Request $request)
    {
        // Opsional: Bisa difilter berdasarkan status dari Vue.js
        // Contoh: /api/v1/admin/orders?status=PAID
        $status = $request->query('status');

        $query = Order::with('details.produk')->orderBy('tanggal_transaksi', 'desc');

        if ($status) {
            $query->where('status_order', $status);
        }

        // Gunakan pagination agar admin tidak berat saat memuat ribuan transaksi
        $orders = $query->paginate(15);

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar semua transaksi',
            'data'    => $orders
        ]);
    }

    // ==========================================================
    // 2. UBAH STATUS PESANAN (Pengiriman)
    // ==========================================================
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $request->validate([
            // Membatasi pilihan status agar seragam
            'status_order' => 'required|in:PENDING,PAID,PROCESSED,SHIPPED,COMPLETED'
        ]);

        $order->update([
            'status_order' => $request->status_order
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Status pesanan berhasil diperbarui menjadi ' . $request->status_order,
            'data'    => $order
        ]);
    }

    // ==========================================================
    // 3. LAPORAN OMZET (Untuk Dashboard Admin)
    // ==========================================================
    public function omzetReport()
    {
        // Kita hitung omzet HANYA dari pesanan yang tidak PENDING
        // (Artinya yang sudah dibayar: PAID, PROCESSED, SHIPPED, COMPLETED)
        
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // 1. Omzet Hari Ini
        $omzetHariIni = Order::whereDate('tanggal_transaksi', $today)
            ->where('status_order', '!=', 'PENDING')
            ->sum('total_harga');

        // 2. Omzet Bulan Ini
        $omzetBulanIni = Order::whereMonth('tanggal_transaksi', $thisMonth)
            ->whereYear('tanggal_transaksi', $thisYear)
            ->where('status_order', '!=', 'PENDING')
            ->sum('total_harga');

        // 3. Total Omzet Keseluruhan Waktu
        $omzetTotal = Order::where('status_order', '!=', 'PENDING')
            ->sum('total_harga');

        // 4. Hitung jumlah pesanan baru yang butuh diproses (Status PAID)
        $pesananMenunggu = Order::where('status_order', 'PAID')->count();

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan Omzet dan Ringkasan Dashboard',
            'data'    => [
                'omzet_hari_ini'   => $omzetHariIni,
                'omzet_bulan_ini'  => $omzetBulanIni,
                'omzet_total'      => $omzetTotal,
                'pesanan_menunggu' => $pesananMenunggu
            ]
        ]);
    }
    
    // ==========================================================
    // 4. LIHAT DETAIL SATU PESANAN (BERDASARKAN ID)
    // ==========================================================
    public function show($id)
    {
        // Cari order berdasarkan ID, dan langsung muat (load) detail barang beserta info produknya
        $order = Order::with('details.produk')->find($id);

        // Jika ID order tidak ada di database
        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail pesanan',
            'data'    => $order
        ], 200);
    }
}