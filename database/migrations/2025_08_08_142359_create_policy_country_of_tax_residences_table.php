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
        Schema::create('policy_country_of_tax_residences', function (Blueprint $table) {
            $table->id();
            $table->string('eloquent')->nullable();
            $table->unsignedBigInteger('eloquent_id');
            $table->unsignedBigInteger('country_id');
            $table->boolean('in_draft')->default(0);
            $table->boolean('silent_save')->default(1);
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
        Schema::dropIfExists('policy_country_of_tax_residences');
    }
};
