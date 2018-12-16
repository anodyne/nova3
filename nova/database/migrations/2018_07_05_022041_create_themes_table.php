<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('path');
			$table->string('layout_admin')->default('app-sidebar');
			$table->json('layout_data_admin')->nullable();
			$table->string('layout_auth')->default('auth-simple');
			$table->json('layout_data_auth')->nullable();
			$table->string('layout_landing')->default('app-landing');
			$table->json('layout_data_landing')->nullable();
			$table->string('layout_site')->default('app-topnav');
			$table->json('layout_data_site')->nullable();
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
        Schema::dropIfExists('themes');
    }
}
