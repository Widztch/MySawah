<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10); // Menggunakan pagination untuk menghindari overload data

        return response()->json([
            'status' => 'success',
            'message' => 'List Data Produk',
            'data' => $products
        ], 200);
    }

    public function show($id) // Menambahkan parameter $id untuk mendapatkan detail produk berdasarkan ID
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail Produk',
            'data' => $product
        ], 200);
    }
}