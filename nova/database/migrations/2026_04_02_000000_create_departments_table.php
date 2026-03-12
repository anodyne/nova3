<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->string('status')->default('active')->index();
            $table->json('tags')->nullable();
            $table->datetimes();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('department_id')->constrained();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('available')->default(1)->index();
            $table->string('status')->default('active')->index();
            $table->json('tags')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->datetimes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
        Schema::dropIfExists('departments');
    }
};
