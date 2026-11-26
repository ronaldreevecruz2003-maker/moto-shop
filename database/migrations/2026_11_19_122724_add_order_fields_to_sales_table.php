<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {$table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('order_type')->default('walk_in')->after('payment_method'); // walk_in, pickup_only, with_installation$table->string('status')->default('completed')->after('order_type'); // pending, completed, cancelled
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {$table->dropColumn(['customer_phone', 'order_type', 'status']);
        });
    }
};
