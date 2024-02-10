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
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('disk');
            $table->string('path');
            $table->string('name');
            $table->string('checksum')->index();
            $table->json('metadata');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['disk', 'path']);
        });

        Schema::create('file_access', function (Blueprint $table){
            $table->id();
            $table->foreignId('file_id')->constrained('file')->onDelete('cascade');
            $table->string('action');
            $table->ipAddress();
            $table->string('referer');
            $table->json('user')->nullable();
            $table->text('observations')->nullable();

            $table->timestamps();
        });

        Schema::create('entity_reference', function (Blueprint $table){
            $table->id();
            $table->uuid()->unique();
            $table->string('service');
            $table->morphs('entity');
        });

        Schema::create('file_attached_to', function (Blueprint $table){
            $table->foreignId('file_id')->constrained('file')->onDelete('cascade');
            $table->foreignId('entity_reference_id')->constrained('entity_reference')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_access');
        Schema::dropIfExists('file');
    }
};
