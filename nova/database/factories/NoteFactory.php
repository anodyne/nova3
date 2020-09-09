<?php

namespace Database\Factories;

use Nova\Notes\Models\Note;
use Nova\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'user_id' => fn () => User::factory(),
            'title' => $this->faker->words(mt_rand(3, 10), true),
            'content' => $this->faker->paragraphs(mt_rand(1, 5), true),
            'summary' => $this->faker->sentences(mt_rand(1, 5), true),
        ];
    }
}
