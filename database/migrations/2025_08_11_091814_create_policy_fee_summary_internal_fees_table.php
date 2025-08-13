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
        Schema::create('policy_fee_summary_internal_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_fee_summary_internal_id');
            $table->string('type')->nullable();
            $table->enum('frequency', ['monthly', 'bi-monthly', 'quarterly', 'semi-annually', 'anually'])->default('monthly');
            $table->double('amount')->default(0);
            $table->string('commission_split')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('policy_fee_summary_internal_fees');
    }
};
