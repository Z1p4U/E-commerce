<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("sku");
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->string("size");
            $table->boolean('sale')->nullable()->default(0);
            $table->integer('total_stock')->nullable()->default(0);
            $table->string("price");
            $table->string("discount_price")->nullable();
            $table->longText("description")->nullable();
            $table->string("photo")->nullable();
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
