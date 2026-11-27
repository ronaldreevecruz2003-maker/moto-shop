<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('contact_person')->nullable();
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('parts', function (Blueprint $table) {
            if (!Schema::hasColumn('parts', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('parts', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->default(0)->after('description');
            }
            if (!Schema::hasColumn('parts', 'reorder_level')) {
                $table->integer('reorder_level')->default(5)->after('stock_quantity');
            }
            if (!Schema::hasColumn('parts', 'rack_location')) {
                $table->string('rack_location')->nullable()->after('reorder_level');
            }
        });

        if (!Schema::hasTable('stock_ins')) {
            Schema::create('stock_ins', function (Blueprint $table) {
                $table->id();
                $table->string('reference_no')->unique();
                $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->date('received_date');
                $table->decimal('total_cost', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('stock_in_items')) {
            Schema::create('stock_in_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('stock_in_id')->constrained()->cascadeOnDelete();
                $table->foreignId('part_id')->constrained()->cascadeOnDelete();
                $table->integer('quantity');
                $table->decimal('unit_cost', 10, 2);
                $table->decimal('subtotal', 12, 2);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('stock_adjustments')) {
            Schema::create('stock_adjustments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('part_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('reason');
                $table->integer('quantity_deducted');
                $table->integer('previous_stock');
                $table->integer('new_stock');
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('sales', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('sales', 'gcash_reference')) {
                $table->string('gcash_reference')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('sales', 'order_type')) {
                $table->string('order_type')->default('walk_in')->after('gcash_reference');
            }
            if (!Schema::hasColumn('sales', 'status')) {
                $table->string('status')->default('completed')->after('order_type');
            }
            if (!Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('sales', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('subtotal');
            }
            if (!Schema::hasColumn('sales', 'total_profit')) {
                $table->decimal('total_profit', 12, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('sales', 'amount_tendered')) {
                $table->decimal('amount_tendered', 12, 2)->default(0)->after('total_profit');
            }
            if (!Schema::hasColumn('sales', 'change_amount')) {
                $table->decimal('change_amount', 12, 2)->default(0)->after('amount_tendered');
            }
        });

        Schema::table('sale_items', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_items', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->default(0)->after('quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('stock_in_items');
        Schema::dropIfExists('stock_ins');
        Schema::dropIfExists('suppliers');
    }
};