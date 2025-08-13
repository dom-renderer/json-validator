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
        Schema::create('policy_introducers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_id');
            $table->enum('type', ['individual', 'entity'])->default('individual');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('silent_save')->default(1);
            $table->boolean('in_draft')->default(0);
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_introducers');
    }
};
