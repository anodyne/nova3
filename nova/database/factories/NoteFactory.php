<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;

/** @extends Factory<Note> */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory(),
            'title' => ucwords(rtrim($this->faker->sentence(mt_rand(3, 10), variableNbWords: false), '.')),
            'content' => $this->faker->paragraphs(mt_rand(1, 5), asText: true),
        ];
    }
}
