<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_corte', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('estado')->default('solicitado');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_corte');
    }
};
