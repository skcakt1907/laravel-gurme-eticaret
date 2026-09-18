<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Çift dil: ikincil dil (EN) çevirileri JSON olarak. Ana kolonlar = TR (varsayılan).
    private array $tables = ['categories', 'products', 'services', 'posts', 'testimonials'];

    public function up(): void
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->json('ceviri')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $t) {
            Schema::table($t, fn (Blueprint $table) => $table->dropColumn('ceviri'));
        }
    }
};
