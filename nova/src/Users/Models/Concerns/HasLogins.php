<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Date;
use Nova\Users\Models\Login;

trait HasLogins
{
    /**
     * @return HasOne<Login, $this>
     */
    public function latestLogin(): HasOne
    {
        return $this->logins()->one()->ofMany();
    }

    /**
     * @return HasMany<Login, $this>
     */
    public function logins(): HasMany
    {
        return $this->hasMany(Login::class);
    }

    public function recordLogin(?string $ip): void
    {
        $this->logins()->create([
            'ip_address' => $ip,
            'created_at' => Date::now(),
        ]);
    }
}
