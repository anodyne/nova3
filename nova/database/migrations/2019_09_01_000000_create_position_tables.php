<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Departments\Enums\PositionStatus;

class CreatePositionTables extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignId('department_id')->constrained();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('available')->default(1)->index();
            $table->string('status')->default(PositionStatus::Active)->index();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
