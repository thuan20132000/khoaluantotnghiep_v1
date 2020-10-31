<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_confirms', function (Blueprint $table) {
            $table->id();
            $table->decimal('confirmed_price');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('job_collaborator_id');
            $table->foreign('job_collaborator_id')->references('id')->on('job_collaborators');
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
        Schema::dropIfExists('job_confirms');
    }
}
