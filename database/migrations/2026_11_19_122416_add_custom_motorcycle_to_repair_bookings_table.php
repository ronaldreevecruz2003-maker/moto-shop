<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('repair_bookings', function (Blueprint $table) {$table->string('custom_motorcycle')->nullable()->after('motorcycle_model_id');
        });
    }

    public function down(): void
    {
        Schema::table('repair_bookings', function (Blueprint $table) {$table->dropColumn('custom_motorcycle');
        });
    }
};
