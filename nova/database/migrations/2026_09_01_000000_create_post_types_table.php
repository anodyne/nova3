<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('key')->unique();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('status')->default('active')->index();
            $table->string('visibility')->default('in-character')->index();
            $table->json('fields')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_types');
    }
};
