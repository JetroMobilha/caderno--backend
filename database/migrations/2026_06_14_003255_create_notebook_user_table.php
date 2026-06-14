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
    Schema::create('notebook_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('notebook_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // A permissão que este utilizador tem no caderno
        $table->enum('role', ['viewer', 'editor'])->default('viewer');
        
        $table->timestamps();
        
        // Garante que o mesmo utilizador não é adicionado duas vezes ao mesmo caderno
        $table->unique(['notebook_id', 'user_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notebook_user');
    }
};
