<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_produk'; 

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'gambar_produk'
    ];
    
    public function getGambarProdukAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // Jika sudah berupa URL, langsung kirimh
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika hanya nama file
        return asset('storage/products/' . $value);
    }

}