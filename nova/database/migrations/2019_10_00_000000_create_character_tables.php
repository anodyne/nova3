<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;

class CreateCharacterTables extends Migration
{
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->prefixedId();
            $table->string('name');
            $table->string('type')->default(CharacterType::support->value);
            $table->string('status');
            $table->foreignIdFor(RankItem::class, 'rank_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('character_position', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class);
            $table->foreignIdFor(Position::class);
        });

        Schema::create('character_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class);
            $table->foreignIdFor(User::class);
            $table->boolean('primary')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('character_position');
        Schema::dropIfExists('character_user');
        Schema::dropIfExists('characters');
    }
}
