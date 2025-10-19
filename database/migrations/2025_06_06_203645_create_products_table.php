<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
   Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('title')->nullable();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->unsignedInteger('quantity')->default(0);
    $table->string('image')->nullable();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->json('custom_fields')->nullable(); // for dynamic fields like size, color
    $table->string('size_guide')->nullable();  // optional guide text per product
    $table->boolean('is_active')->default(true); // status toggle
    $table->timestamps();
       });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};


