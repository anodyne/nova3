<?php

use Nova\Themes\Theme;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->json('layout_auth_settings')->nullable();
            $table->string('layout_public')->default('app-hero');
            $table->json('layout_public_settings')->nullable();
            $table->string('layout_admin')->default('app-sidebar');
            $table->json('layout_admin_settings')->nullable();
            $table->string('icon_set')->default('feather');
            $table->timestamps();
        });

        $this->populateThemesTable();
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

    protected function populateThemesTable()
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
