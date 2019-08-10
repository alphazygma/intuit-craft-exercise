<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description', 2000);
            $table->bigInteger('seller_id')->index('IDX_seller');
            $table->smallInteger('status')->default(0)->index('IDX_project_status');
            $table->dateTime('deadline_at');
            $table->bigInteger('lowest_bid_id')->nullable()->index('IDX_bid');
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
        Schema::dropIfExists('project');
    }
}
