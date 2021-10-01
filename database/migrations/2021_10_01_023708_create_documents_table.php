<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_unique_id');
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('document_category');
            $table->string('document_url');
            $table->string('document_format');
            $table->string('description');
            $table->foreignId('assigned_id')
                    ->constrained('users');
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
        Schema::dropIfExists('documents');
    }
}
