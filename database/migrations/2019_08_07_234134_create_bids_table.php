<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->index('IDX_project');
            $table->bigInteger('buyer_id')->index('IDX_buyer');
            $table->smallInteger('type');
            $table->decimal('value');
            $table->decimal('hourly_value')->nullable();
            $table->smallInteger('min_hours')->nullable();
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
        Schema::dropIfExists('bid');
    }
}
