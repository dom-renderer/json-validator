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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number')->index();
            $table->dateTime('opening_date')->nullable();
            $table->unsignedBigInteger('policy_holder_id')->nullable();
            $table->boolean('silent_save')->default(1);
            $table->boolean('status')->default(0)->comment('0 = Draft | 1 = Pending | 2 = Follow Up | 3 = Active | 4 = InActive');
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
        Schema::dropIfExists('policies');
    }
};
