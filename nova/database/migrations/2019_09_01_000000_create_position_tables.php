<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Models\Department;

class CreatePositionTables extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->foreignIdFor(Department::class);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('available')->default(1);
            $table->string('status')->default(PositionStatus::active->value);
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
