<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('students', 'avatar')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('avatar',)->nullable()->after('status');
            });
        }
    }


    public function down()
    {
        if (Schema::hasColumn('students', 'avatar')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('avatar',);
            });
        }
    }
};