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
    Schema::table('registrations', function (Blueprint $table) {
        // Menyimpan ID Organisasi yang dipilih saat daftar
        $table->foreignId('organization_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('registrations', function (Blueprint $table) {
        $table->dropForeign(['organization_id']);
        $table->dropColumn('organization_id');
    });
}
};
