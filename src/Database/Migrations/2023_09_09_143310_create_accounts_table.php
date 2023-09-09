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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->unique();

            $table->string('name');
            $table->string('number')->nullable();
            $table->string('color', 6)->nullable();
            $table->string('type')->default('cash');

            $table->unsignedDecimal('limit')->default(0);
            $table->unsignedTinyInteger('deadline')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
