<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandlordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('landlordid'); 
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number'); 
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('address')->nullable(); 
            $table->string('landmark')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('country')->nullable();
            $table->string('profile_pic')->nullable(); 
            $table->enum('KYC_status', ['completed', 'uncompleted'])->default('uncompleted');
            $table->string('KYC_type')->nullable(); 
            $table->string('KYC_id')->nullable();
            $table->foreignId('role_id')->constrained('roles');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landlords');
    }
}
