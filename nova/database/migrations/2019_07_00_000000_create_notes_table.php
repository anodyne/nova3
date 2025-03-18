<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('user_id')->constrained();
            $table->string('title')->index();
            $table->longText('content')->nullable();
            $table->datetimes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
