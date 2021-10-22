<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained();
            $table->string('verification_type');
            $table->json('property_document');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('property_verifications');
    }
}
