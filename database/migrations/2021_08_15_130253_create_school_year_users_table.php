<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolYearUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_year_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('school_year_id')->constrained('school_years')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamp('disetujui')->nullable();
            $table->primary(['user_id', 'school_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_year_users');
    }
}
