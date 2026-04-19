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
        Schema::create('afiliados', function (Blueprint $table) {
            $table->id();
            $table->string('legajo', 50)->unique();
            $table->string('apellido', 100);
            $table->string('nombre', 100);
            $table->string('cuil', 11)->unique();
            $table->foreignId('zona_id')->constrained('zonas');
            $table->foreignId('condicion_id')->constrained('condiciones');
            $table->string('cbu', 30)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afiliados');
    }
};
