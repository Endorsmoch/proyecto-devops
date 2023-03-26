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
        Schema::create('users', function (Blueprint $table) {
            $table->string('userName');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('lastLoginDate')->nullable();
            $table->timestamp('createdDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('idAddress')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
