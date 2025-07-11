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
        Schema::create('campaign_clicks', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('campaign_id');
    $table->unsignedBigInteger('subscriber_id');
    $table->text('clicked_url');
    $table->timestamp('clicked_at')->nullable();
    $table->timestamps();

    $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
    $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_clicks');
    }
};