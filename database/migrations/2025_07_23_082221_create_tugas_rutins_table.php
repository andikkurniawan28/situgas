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
        Schema::create('tugas_rutins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_id')->constrained();
            $table->foreignId('progress_id')->default(1)->constrained();
            $table->string('judul');
            $table->text('keterangan');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_rutins');
    }
};
