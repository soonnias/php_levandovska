<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('product_name')->nullable()->after('order_id'); // Додати назву товару
            $table->decimal('product_price', 10, 2)->default(0)->after('product_name'); // Додати ціну товару
            $table->decimal('total_price', 10, 2)->after('quantity'); // Додати загальну ціну за товар

            $table->dropForeign(['product_id']); // Видалити зовнішній ключ
            $table->dropColumn('product_id'); // Видалити колонку product_id
            $table->dropColumn('price'); // Видалити колонку price
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->after('order_id'); // Відновити колонку product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // Відновити зовнішній ключ

            $table->decimal('price', 10, 2)->after('quantity'); // Відновити колонку price

            $table->dropColumn(['product_name', 'product_price', 'total_price']); // Видалити нові колонки
        });
    }
};
