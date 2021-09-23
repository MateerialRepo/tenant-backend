<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalcolumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('tenantid')->nullable()->after('last_name'); 
            $table->string('phone_number')->nullable()->after('email'); 
            $table->enum('gender', ['male', 'female'])->nullable()->after('password');
            $table->date('dob')->nullable()->after('gender');
            $table->string('occupation')->nullable()->after('dob');
            $table->string('address')->nullable(); 
            $table->string('landmark')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('country')->nullable();
            $table->string('profile_pic')->nullable(); 
            $table->enum('KYC_type', ['BVN', 'NIN'])->nullable()->after('KYC_status'); 
            $table->string('KYC_id')->nullable()->after('KYC_type');
            $table->foreignId('role_id')->constrained('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tenantid']);
            $table->dropColumn(['phone_number']);
            $table->dropColumn(['gender']);
            $table->dropColumn(['dob']);
            $table->dropColumn(['occupation']);
            $table->dropColumn(['address']);
            $table->dropColumn(['landMark']);
            $table->dropColumn(['state']);
            $table->dropColumn(['country']);
            $table->dropColumn(['profile_pic']);
            $table->dropColumn(['kyc_type']);
            $table->dropColumn(['kyc_id']);
            $table->dropColumn(['role']);

        });
    }
}
