<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_address')->after('status'); // Додати адресу доставки
            $table->string('customer_name')->after('delivery_address'); // Додати ім'я клієнта
            $table->string('customer_surname')->after('customer_name'); // Додати прізвище клієнта
            $table->string('customer_phone')->after('customer_surname'); // Додати телефон клієнта
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_address', 'customer_name', 'customer_surname', 'customer_phone']);
        });
    }
};
