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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('borrow_to')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->string('author');
            $table->date('published_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
