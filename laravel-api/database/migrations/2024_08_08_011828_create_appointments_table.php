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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do cliente
            $table->dateTime('datetime')->unique(); // Data e hora do agendamento
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Chave estrangeira para a tabela 'services'
            $table->string('phone'); // Telefone para contato
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
