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
        Schema::create('articles', function (Blueprint $table) {
            
            $table->id();

            $table->foreignId('source_id')->nullable()->constrained('sources')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->foreignId('author_id')->nullable()->constrained('authors')
                ->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->longText('url')->nullable();

            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('image')->nullable();
            $table->timestamp('published_at');
            $table->boolean('is_top')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
