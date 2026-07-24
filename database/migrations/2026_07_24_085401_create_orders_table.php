<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 20)->unique();
            $table->string('customer_name', 100);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->string('address', 255);
            $table->text('note')->nullable();
            $table->decimal('total_amount', 12, 0);
            $table->tinyInteger('status')->default(1); // 1: Chờ xử lý, 2: Đang giao, 3: Hoàn thành, 4: Đã hủy
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};