<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            // Menambahkan kolom role dengan pilihan: admin, staff, atau customer
            // Default-nya kita set sebagai 'customer'
            $blueprint->string('role')->default('customer')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn('role');
        });
    }
};