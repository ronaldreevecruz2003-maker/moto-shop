<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motorcycle_model_part', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained()->cascadeOnDelete();
            $table->foreignId('motorcycle_model_id')->constrained()->cascadeOnDelete();
        });
    }
    public function down(): void { Schema::dropIfExists('motorcycle_model_part'); }
};
