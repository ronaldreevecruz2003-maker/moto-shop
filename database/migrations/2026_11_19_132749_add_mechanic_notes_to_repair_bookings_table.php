<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('repair_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('repair_bookings', 'mechanic_notes')) {
                $table->text('mechanic_notes')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('repair_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('repair_bookings', 'mechanic_notes')) {
                $table->dropColumn('mechanic_notes');
            }
        });
    }
};
