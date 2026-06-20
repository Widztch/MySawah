<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Memperbarui ENUM agar menerima status baru menggunakan perintah SQL murni
        // (Cara ini paling aman dan tidak memerlukan instalasi library tambahan)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_order ENUM('PENDING', 'PAID', 'PROCESSED', 'SHIPPED', 'COMPLETED') NOT NULL DEFAULT 'PENDING'");
    }

    public function down(): void
    {
        // Kembalikan ke asal jika migration di-rollback
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_order ENUM('PENDING', 'PAID') NOT NULL DEFAULT 'PENDING'");
    }
};

