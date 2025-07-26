<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku_besars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('pelunasan_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('jurnal_umum_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('akun_id')->constrained();
            $table->text('keterangan');
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_besars');
    }
};
