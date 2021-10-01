<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('phone_number')->nullable(); 
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('occupation')->nullable();
            $table->string('address')->nullable(); 
            $table->string('landmark')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('country')->nullable();
            $table->string('profile_pic')->nullable(); 
            $table->enum('kyc_type', ['BVN', 'NIN'])->nullable(); 
            $table->string('kyc_id')->nullable(); 
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
        Schema::dropIfExists('user_details');
    }
}
