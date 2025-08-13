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
        Schema::create('policy_premiums', function (Blueprint $table) {
            $table->id();
            $table->string('policy_type');
            $table->unsignedBigInteger('policy_id');
            $table->double('proposed_premium_amount')->default(0);
            $table->text('proposed_premium_note')->nullable();
            $table->double('final_premium_amount')->default(0);
            $table->text('final_premium_note')->nullable();
            $table->enum('premium_frequency', ['annual', 'semi-annual', 'quarterly', 'monthly'])->default('monthly');
            $table->double('premium_years')->default(0);
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
        Schema::dropIfExists('policy_premiums');
    }
};
