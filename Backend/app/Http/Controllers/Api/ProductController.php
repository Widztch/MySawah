<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Membuka gerbang query pemanggilan data
        $query = Product::query();
        
        // 2. Cek apakah ada parameter 'search' yang dikirimkan dari Vue Frontend
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // 3. (Opsional) Urutkan dari produk yang paling baru ditambahkan
        $query->latest('id_produk');

        // 4. Eksekusi query dengan pagination (10 data per halaman)
        $products = $query->paginate(12); 

        return response()->json([
            'status' => 'success',
            'message' => 'List Data Produk',
            'data' => $products
        ], 200);
    }

    public function show($id)
    {
        // Mencari detail produk berdasarkan ID
        $product = Product::find($id);

        // Jika ID produk tidak ada di database
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Jika sukses ditemukan
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Produk',
            'data' => $product
        ], 200);
    }
}
