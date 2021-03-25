<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepoStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('repo_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stars');
            $table->integer('commits');
            $table->integer('forks');
            $table->integer('releases');
            $table->integer('contributors');
            $table->integer('languages');
            $table->integer('open_issues');
            $table->integer('open_pull_requests');
            $table->integer('branches');
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
        Schema::dropIfExists('products');
    }
}
