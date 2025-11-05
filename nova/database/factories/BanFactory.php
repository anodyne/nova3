<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Nova\Model>
 */
class BanFactory extends Factory
{
    protected $model = Ban::class;

    public function definition(): array
    {
        return [
            'bannable_id' => User::factory(),
            'bannable_type' => fn (array $attributes) => User::find($attributes['bannable_id'])->getMorphClass(),
            'created_by_id' => User::factory(),
            'created_by_type' => fn (array $attributes) => User::find($attributes['created_by_id'])->getMorphClass(),
            'comment' => fake()->paragraph(),
        ];
    }

    public function forIpAddress(): static
    {
        return $this->state([
            'ip' => fake()->ipv4(),
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state([
            'bannable_id' => $user->id,
            'bannable_type' => $user->getMorphClass(),
        ]);
    }

    public function createdBy(User $user): static
    {
        return $this->state([
            'created_by_id' => $user->id,
            'created_by_type' => $user->getMorphClass(),
        ]);
    }

    public function expires(): static
    {
        return $this->state([
            'expired_at' => Date::now()->subMinute(),
        ]);
    }

    public function expiresIn(int $days): static
    {
        return $this->state([
            'expired_at' => Date::now()->addDays($days),
        ]);
    }

    public function permanent(): static
    {
        return $this->state([
            'expired_at' => null,
        ]);
    }
}
