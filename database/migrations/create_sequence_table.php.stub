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
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_sequence', function (Blueprint $table) {
            $table->foreignId('contact_id');
            $table->foreignId('sequence_id');
            $table->timestamp('stopped_at')->nullable();
            $table->timestamp('execute_at')->nullable();
            $table->string('step')->nullable();
            $table->timestamps();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('cascade');
            $table->primary(['contact_id', 'sequence_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sequences');
        Schema::dropIfExists('contact_sequence');
    }
};
