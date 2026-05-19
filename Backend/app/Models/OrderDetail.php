<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'id_detail'; 

    protected $fillable = [
        'id_order', 
        'id_produk', 
        'jumlah', 
        'harga_saat_beli'
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
    
    public function order()
    {
    return $this->belongsTo(Order::class, 'id_order', 'id_orders');
    }
}

