<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Lab404\Impersonate\Models\Impersonate;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Mchev\Banhammer\Traits\Bannable;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Foundation\Models\StatusHistory;
use Nova\Foundation\Nova;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserModerations;
use Nova\Users\Data\UserPreferences;
use Nova\Users\Events;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\States\Status\UserStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class User extends Authenticatable implements HasMedia, HasName, LaratrustUser, MustVerifyEmail
{
    use Bannable;
    use CausesActivity;
    use Concerns\CanManageResources;
    use Concerns\HasAnnouncements;
    use Concerns\HasCharacters;
    use Concerns\HasFormSubmissions;
    use Concerns\HasLogins;
    use Concerns\HasNotes;
    use Concerns\HasPosts;
    use HasFactory;
    use HasPrefixedId;
    use HasRolesAndPermissions;
    use HasStates;
    use HasTableHelpers;
    use Impersonate;
    use InteractsWithMedia;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }
    use Notifiable;
    use SoftDeletes;

    protected $casts = [
        'password' => 'hashed',
        'force_password_reset' => 'boolean',
        'moderations' => UserModerations::class,
        'preferences' => UserPreferences::class,
        'pronouns' => PronounsData::class,
        'status' => UserStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\UserCreated::class,
        'updated' => Events\UserUpdated::class,
        'deleted' => Events\UserDeleted::class,
    ];

    protected $fillable = [
        'name', 'email', 'password', 'force_password_reset', 'status',
        'pronouns', 'preferences', 'moderations',
    ];

    protected $hidden = [
        'password', 'remember_token', 'force_password_reset',
    ];

    public function discussions(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class)
            ->withTimestamps();
    }

    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }

    public function application(): HasOne
    {
        return $this->hasOne(Application::class);
    }

    public function globalApplicationReviewer(): HasOne
    {
        return $this->hasOne(ApplicationReviewer::class)->global();
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->getFirstMediaUrl('avatar')
        );
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->getFirstMedia('avatar') !== null
        );
    }

    public function initials(): Attribute
    {
        return new Attribute(
            get: function (): ?string {
                $segments = explode(' ', $this->name);

                // Only 1 segment, so try to explode on a dash
                if (count($segments) === 1) {
                    $segments = explode('-', $this->name);

                    // Only 1 segment, so try to explode on an underscore
                    if (count($segments) === 1) {
                        $segments = explode('_', $this->name);

                        // Only 1 segment, so try to explode at capital letters
                        if (count($segments) === 1) {
                            $segments = preg_split('/(?=[A-Z])/', $this->name, -1, PREG_SPLIT_NO_EMPTY);

                            // Only 1 segment, so finally split the string and grab the first 2 letters
                            if (count($segments) === 1) {
                                $string = str_split($segments[0]);

                                $segments = [
                                    $string[0],
                                    $string[1],
                                ];
                            }
                        }
                    }
                }

                // Exactly 2 segments, which makes this one easy
                if (count($segments) === 2) {
                    return strtoupper(trim(
                        collect($segments)
                            ->map(fn ($segment) => mb_substr($segment, 0, 1))
                            ->join('')
                    ));
                }

                // More than 2 segments, so grab the first and last items
                if (count($segments) > 2) {
                    return strtoupper(trim(
                        collect([
                            $segments[array_key_first($segments)],
                            $segments[array_key_last($segments)],
                        ])
                            ->map(fn ($segment) => mb_substr($segment, 0, 1))
                            ->join('')
                    ));
                }
            }
        );
    }

    public function isActive(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Active::class)
        );
    }

    public function isDeleted(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->trashed()
        );
    }

    public function isInactive(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Inactive::class)
        );
    }

    public function isModerated(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->moderations->isModerated(),
        );
    }

    public function isPending(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    public function unreadMessagesCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => once(fn () => DiscussionNotification::user($this->id)->unread()->count()),
        );
    }

    public function hasRead(Notification $notification): bool
    {
        return $this->unreadNotifications()->where('id', $notification->id)->count() > 0;
    }

    public function canImpersonate(): bool
    {
        return $this->isAbleTo('user.impersonate');
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'password',
        ]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(Nova::getAvatarUrl($this->name))
            ->useDisk('media-users')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
