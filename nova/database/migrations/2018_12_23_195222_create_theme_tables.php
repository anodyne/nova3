<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Nova\Themes\Theme;

class CreateThemeTables extends Migration
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
            $table->string('location');
            $table->text('credits')->nullable();
            $table->string('layout_auth')->default('auth-simple');
            $table->string('layout_public')->default('auth-simple');
            $table->string('layout_admin')->default('app-sidebar');
            $table->timestamps();
        });

        $this->populateTable();
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

    protected function populateTable()
    {
        $themes = [
            ['name' => 'Pulsar', 'location' => 'pulsar'],
            ['name' => 'Titan', 'location' => 'titan'],
        ];

        collect($themes)->each(function ($theme) {
            Theme::create($theme);
        });
    }
}
