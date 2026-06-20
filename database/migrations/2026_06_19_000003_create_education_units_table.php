<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published')->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_units');
    }
};
