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
    Schema::table('campaigns', function (Blueprint $table) {
        if (Schema::hasColumn('campaigns', 'list_id')) {
            $table->renameColumn('list_id', 'email_list_id');
        }
    });
}

public function down(): void
{
    Schema::table('campaigns', function (Blueprint $table) {
        if (Schema::hasColumn('campaigns', 'email_list_id')) {
            $table->renameColumn('email_list_id', 'list_id');
        }
    });
}
};