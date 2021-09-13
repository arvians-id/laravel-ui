<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tanggal_lahir', 20)->nullable();
            $table->foreignId('faculty_id')->nullable()->constrained('faculties')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('program_study_id')->nullable()->constrained('program_studies')->onDelete('restrict')->onUpdate('cascade');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('photo', 50)->default('default.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_users');
    }
}
