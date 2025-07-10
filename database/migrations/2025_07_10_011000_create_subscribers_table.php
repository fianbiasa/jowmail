<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscribers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('email_list_id')->constrained('email_lists')->onDelete('cascade');
        $table->string('name')->nullable();
        $table->string('email')->unique();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};