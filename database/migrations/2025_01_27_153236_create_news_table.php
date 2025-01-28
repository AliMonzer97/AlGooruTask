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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('service');
            $table->string('section', 100)->nullable();
            $table->text('title');
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('author', 255)->nullable();
            $table->text('url')->unique();
            $table->text('image_url')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('external_id', 255)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            //
        });
    }
};
