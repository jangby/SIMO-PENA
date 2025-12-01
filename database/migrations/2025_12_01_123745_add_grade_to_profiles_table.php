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
    Schema::table('profiles', function (Blueprint $table) {
        // Grade: calon (default), anggota (lulus makesta), kader (lulus lakmud)
        $table->enum('grade', ['calon', 'anggota', 'kader'])->default('calon')->after('nia_ipnu');
    });
}

public function down(): void
{
    Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn('grade');
    });
}
};
