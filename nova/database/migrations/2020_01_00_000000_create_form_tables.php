<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Models\Block;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormBlock;

class CreateFormTables extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->text('description')->nullable();
            $table->boolean('locked')->default(false);
            $table->json('settings')->nullable();
            $table->string('status')->default(FormStatus::active->value);
            $table->timestamps();

            $table->index(['name', 'key']);
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->string('category');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('form_block', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class);
            $table->foreignIdFor(Block::class);
            $table->integer('order_column')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Form::class);
            $table->foreignIdFor(Block::class);
            // $table->foreignIdFor(FormBlock::class);
            $table->morphs('answerable');
            // $table->foreignIdFor()->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_data');
        Schema::dropIfExists('form_block');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('forms');
    }
}
