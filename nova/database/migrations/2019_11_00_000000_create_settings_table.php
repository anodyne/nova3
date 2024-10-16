<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->json('general')->nullable();
            $table->json('email')->nullable();
            $table->json('appearance')->nullable();
            $table->json('characters')->nullable();
            $table->json('meta_tags')->nullable();
            $table->json('discord')->nullable();
            $table->json('posting_activity')->nullable();
            $table->json('ratings')->nullable();
            $table->json('applications')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
