<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('details');
            $table->string('url');
            $table->string('method');
            $table->string('ip');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->timestamps();

        });

        Schema::table('log_activities', function($table) {
            $table->foreign('user_id')->references('id')
            ->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_activities');
    }
}
