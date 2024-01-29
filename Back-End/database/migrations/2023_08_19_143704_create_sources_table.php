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
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('url')->nullable();
            
            $table->foreignId('category_id')->nullable()->constrained('categories')
                ->onDelete('SET NULL')->onUpdate('CASCADE');
            
            $table->foreignId('language_id')->nullable()->constrained('languages')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->foreignId('country_id')->nullable()->constrained('countries')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
