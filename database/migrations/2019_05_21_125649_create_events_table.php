<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('events', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('status', 25)->nullable()->default('CREATED');
            $table->integer('assigned_by')->unsigned()->nullable();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('completed_by')->unsigned()->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('state')->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();


        });

    }

    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::drop("events");

    }

}