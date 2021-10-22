<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tickets', 'ticket_img')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('ticket_img');
            });
        }


        if (!Schema::hasColumn('tickets', 'ticket_img')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->json('ticket_img')->nullable()->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['ticket_img']);
        });
    }
}
