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
    Schema::table('events', function (Blueprint $table) {
        // Menyimpan path file atau link external (GDrive)
        $table->string('certificate_link')->nullable()->after('bank_accounts');
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('certificate_link');
    });
}
};
