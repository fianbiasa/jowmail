<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
        $table->id();
        $table->string('subject');
        $table->text('body');
        $table->foreignId('smtp_account_id')->constrained()->onDelete('cascade');
        $table->foreignId('email_list_id')->constrained('email_lists')->onDelete('cascade');
        $table->enum('status', ['draft', 'sent', 'failed'])->default('draft');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};