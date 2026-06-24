<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ==========================================================
    // 1. TAMBAH PRODUK BARU
    // ==========================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'deskripsi'     => 'required|string',
            'gambar_produk' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        // Proses Upload Gambar
        $path = $request->file('gambar_produk')->store('products', 'public');
        $namaFile = basename($path);

        $product = Product::create([
            'nama_produk'   => $request->nama_produk,
            'harga'         => $request->harga,
            'stok'          => $request->stok,
            'deskripsi'     => $request->deskripsi,
            'gambar_produk' => $namaFile,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil ditambahkan!',
            'data'    => $product
        ], 201);
    }

    // ==========================================================
    // 2. EDIT PRODUK
    // ==========================================================
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_produk'   => 'sometimes|required|string|max:255',
            'harga'         => 'sometimes|required|numeric|min:0',
            'stok'          => 'sometimes|required|integer|min:0',
            'deskripsi'     => 'sometimes|required|string',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika Admin mengupload gambar baru
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama dari storage (jika ada)
            $gambarLama = basename($product->gambar_produk);
            if ($gambarLama && Storage::disk('public')->exists('products/' . $gambarLama)) {
                Storage::disk('public')->delete('products/' . $gambarLama);
            }

            // Upload gambar baru
            $path = $request->file('gambar_produk')->store('products', 'public');
            $product->gambar_produk = basename($path);
        }

        // Update data lainnya
        $product->nama_produk = $request->nama_produk ?? $product->nama_produk;
        $product->harga       = $request->harga ?? $product->harga;
        $product->stok        = $request->stok ?? $product->stok;
        $product->deskripsi   = $request->deskripsi ?? $product->deskripsi;
        
        $product->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil diperbarui!',
            'data'    => $product
        ]);
    }

    // ==========================================================
    // 3. HAPUS PRODUK
    // ==========================================================
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus gambar fisik dari folder storage
        $gambarLama = basename($product->gambar_produk);
        if ($gambarLama && Storage::disk('public')->exists('products/' . $gambarLama)) {
            Storage::disk('public')->delete('products/' . $gambarLama);
        }

        // Hapus data dari database
        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil dihapus!'
        ]);
    }
    // ==========================================================
    // 4. HAPUS BANYAK PRODUK SEKALIGUS (BULK DELETE)
    // ==========================================================
    public function destroyBulk(Request $request)
    {
        // Validasi bahwa request harus berupa array 'ids' dan minimal 1 data
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:products,id_produk' // Pastikan semua ID benar-benar ada di database
        ]);

        // Cari semua produk berdasarkan array ID yang dikirim
        $products = Product::whereIn('id_produk', $request->ids)->get();

        foreach ($products as $product) {
            // Hapus gambar fisik dari folder storage
            $gambarLama = basename($product->gambar_produk);
            if ($gambarLama && \Illuminate\Support\Facades\Storage::disk('public')->exists('products/' . $gambarLama)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('products/' . $gambarLama);
            }
            
            // Hapus data dari database
            $product->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => count($request->ids) . ' produk berhasil dihapus secara permanen!'
        ]);
    }
}