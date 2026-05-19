<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
    protected $primaryKey = 'id_orders';

    protected $fillable = [
        'id_user', 
        'total_harga', 
        'status_order', 
        'tanggal_transaksi'
    ];

    // Relasi: Satu Order punya banyak Rincian (Details)
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_orders');
    }
}