<?php

declare(strict_types=1);

namespace Nova\Onboarding\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Nova\Foundation\Models\Model;
use Nova\Onboarding\Enums\OnboardingProcess;
use Nova\Onboarding\Models\Builders\OnboardingBuilder;
use Nova\Users\Models\User;

class Onboarding extends Model
{
    protected $table = 'onboarding';

    protected $fillable = ['name', 'key', 'description'];

    protected $casts = [
        'key' => OnboardingProcess::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(OnboardingUser::class);
    }

    public function newEloquentBuilder($query): OnboardingBuilder
    {
        return new OnboardingBuilder($query);
    }
}
