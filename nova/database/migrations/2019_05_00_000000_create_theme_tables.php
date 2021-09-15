<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeTables extends Migration
{
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->text('credits')->nullable();
            $table->text('preview')->nullable();
            $table->boolean('active')->default(true);
            $table->string('layout_auth')->default('auth-simple');
            $table->string('layout_public')->default('app-hero');
            $table->string('layout_admin')->default('app-admin');
            $table->string('icon_set')->default('feather');
            $table->timestamps();

            $table->index(['location', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
