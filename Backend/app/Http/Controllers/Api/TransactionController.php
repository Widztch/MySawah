<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // ==========================================================
    // 1. CHECKOUT (Tambah ke Keranjang)
    // ==========================================================
    public function checkout(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'items'             => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:products,id_produk',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah user punya order yang masih PENDING?
            $order = Order::where('id_user', $user->id)
                          ->where('status_order', 'PENDING')
                          ->first();

            // Jika belum ada order pending, buat baru
            if (!$order) {
                $order = Order::create([
                    'id_user'           => $user->id,
                    'total_harga'       => 0, 
                    'status_order'      => 'PENDING',
                    'tanggal_transaksi' => now()
                ]);
            }

            // Loop item yang mau ditambahkan
            foreach ($request->items as $item) {
                $produk = Product::find($item['id_produk']);

                // Cek Stok
                if ($produk->stok < $item['jumlah']) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Stok ' . $produk->nama_produk . ' habis/kurang'
                    ], 400);
                }

                // Cek apakah produk ini SUDAH ADA di detail order tersebut?
                $existingDetail = OrderDetail::where('id_order', $order->id_orders)
                                             ->where('id_produk', $produk->id_produk)
                                             ->first();

                if ($existingDetail) {
                    // Update jumlah & harga (Logika: Tambah qty)
                    $existingDetail->jumlah += $item['jumlah'];
                    $existingDetail->save();
                    
                    // Kurangi stok
                    $produk->decrement('stok', $item['jumlah']);
                } else {
                    // Buat detail baru
                    OrderDetail::create([
                        'id_order'        => $order->id_orders,
                        'id_produk'       => $produk->id_produk,
                        'jumlah'          => $item['jumlah'],
                        'harga_saat_beli' => $produk->harga
                    ]);
                    
                    // Kurangi stok
                    $produk->decrement('stok', $item['jumlah']);
                }
            }

            // Hitung Ulang Total Harga Order
            $grandTotal = OrderDetail::where('id_order', $order->id_orders)
                ->get()
                ->sum(function ($detail) {
                    return $detail->jumlah * $detail->harga_saat_beli;
                });

            $order->update(['total_harga' => $grandTotal]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil masuk keranjang (Pending)',
                'data'    => $order
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menambahkan ke keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================================================
    // 2. BAYAR (Ubah PENDING jadi PAID)
    // ==========================================================
    public function pay(Request $request)
    {
        $user = $request->user();

        $order = Order::where('id_user', $user->id)
                      ->where('status_order', 'PENDING')
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Tidak ada tagihan pending'], 404);
        }

        $order->update([
            'status_order' => 'PAID',
            'tanggal_transaksi' => now()
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pembayaran Berhasil!',
            'data'    => $order
        ]);
    }

    // ==========================================================
    // 3. RIWAYAT TRANSAKSI (HISTORY)
    // ==========================================================
    public function history(Request $request)
    {
        $user = $request->user();
    
        $orders = Order::with(['details.produk'])
            ->where('id_user', $user->id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();
    
        return response()->json([
            'status'  => 'success',
            'message' => 'Riwayat transaksi',
            'data'    => $orders
        ], 200);
    }    

    // ==========================================================
    // 4. AMBIL KERANJANG (Load Cart saat buka aplikasi)
    // ==========================================================
    public function getCart(Request $request)
    {
        $user = $request->user();

        $order = Order::with(['details.produk'])
            ->where('id_user', $user->id)
            ->where('status_order', 'PENDING')
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'success',
                'data'   => null // Kirim null agar Vue tahu keranjang kosong
            ]);
        }

        // MODIFIKASI: Kirim keseluruhan order agar total_harga bisa ditampilkan di Vue
        return response()->json([
            'status' => 'success',
            'data'   => [
                'id_orders'   => $order->id_orders,
                'total_harga' => $order->total_harga,
                'items'       => $order->details
            ]
        ]);
    }

    // ==========================================================
    // 5. KURANGI ITEM (Tombol Minus)
    // ==========================================================
    public function reduceItem(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk'
        ]);

        DB::beginTransaction();
        try {
            $order = Order::where('id_user', $user->id)
                          ->where('status_order', 'PENDING')
                          ->first();

            if (!$order) {
                return response()->json(['message' => 'Keranjang kosong'], 404);
            }

            $detail = OrderDetail::where('id_order', $order->id_orders)
                                 ->where('id_produk', $request->id_produk)
                                 ->first();

            if ($detail) {
                $produk = Product::find($request->id_produk);

                if ($detail->jumlah > 1) {
                    $detail->decrement('jumlah');
                    $produk->increment('stok');
                } else {
                    $detail->delete();
                    $produk->increment('stok');
                }

                $grandTotal = OrderDetail::where('id_order', $order->id_orders)
                    ->get()
                    ->sum(function ($d) { return $d->jumlah * $d->harga_saat_beli; });

                $order->update(['total_harga' => $grandTotal]);
                
                if ($grandTotal == 0) {
                   $order->delete();
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Item dikurangi']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================================
    // 6. CLEAR CART (Hapus Order Pending & Kembalikan Stok)
    // ==========================================================
    public function clearCart(Request $request)
    {
        $user = $request->user();

        DB::beginTransaction();
        try {
            $order = Order::with('details.produk')
                ->where('id_user', $user->id)
                ->where('status_order', 'PENDING')
                ->first();

            if (!$order) {
                return response()->json(['message' => 'Keranjang sudah kosong'], 404);
            }

            foreach ($order->details as $detail) {
                $detail->produk->increment('stok', $detail->jumlah);
            }

            OrderDetail::where('id_order', $order->id_orders)->delete();
            $order->delete();

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Keranjang berhasil dikosongkan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal hapus keranjang: ' . $e->getMessage()
            ], 500);
        }
    }
}