<?php

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_code");
            $table->string("name");
            $table->string("surname");
            $table->string("email");
            $table->string("address");
            $table->decimal("total_price");
            $table->string("zip_code");
            $table->enum("payment_method", OrderStatus::TYPES)->default(OrderStatus::NOT_PAID);
            $table->enum('status', OrderStatus::TYPES)->default(OrderStatus::ORDER_PLACED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
