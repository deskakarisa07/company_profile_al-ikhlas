<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('summary');
            $table->longText('description');
            $table->text('vision');
            $table->longText('mission');
            $table->string('logo')->nullable();
            $table->text('address');
            $table->string('phone', 30);
            $table->string('email');
            $table->text('map_url')->nullable();
            $table->boolean('is_active')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
