<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('repair_bookings', function (Blueprint $table) {$table->id();
            $table->string('customer_name');$table->string('customer_phone');
            $table->foreignId('motorcycle_model_id')->nullable()->constrained()->nullOnDelete();$table->string('plate_number')->nullable();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();$table->dateTime('scheduled_at');
            $table->string('status')->default('pending'); // pending, in_progress, completed, cancelled$table->text('mechanic_notes')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_bookings');
    }
};
