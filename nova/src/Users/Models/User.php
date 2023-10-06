<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Lab404\Impersonate\Models\Impersonate;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active as ActiveCharacter;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Notes\Models\Note;
use Nova\Posts\Models\Post;
use Nova\Users\Data\PronounsData;
use Nova\Users\Events;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\Collections\UsersCollection;
use Nova\Users\Models\States\UserStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable implements HasMedia, LaratrustUser, MustVerifyEmail
{
    use CausesActivity;
    use HasEagerLimit;
    use HasFactory;
    use HasRolesAndPermissions;
    use HasStates;
    use Impersonate;
    use InteractsWithMedia;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    protected $casts = [
        'force_password_reset' => 'boolean',
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
        'pronouns', 'appearance',
    ];

    protected $hidden = [
        'password', 'remember_token', 'force_password_reset',
    ];

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)
            ->withPivot('primary')
            ->withTimestamps();
    }

    public function activeCharacters(): BelongsToMany
    {
        return $this->characters()->whereState('status', ActiveCharacter::class);
    }

    public function primaryCharacter(): BelongsToMany
    {
        return $this->activeCharacters()->wherePivot('primary', true);
    }

    public function logins(): HasMany
    {
        return $this->hasMany(Login::class);
    }

    public function latestLogin(): HasOne
    {
        return $this->logins()->one()->ofMany();
    }

    public function latestPost(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author')
            ->published()
            ->latest('published_at')
            ->limit(1);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function posts(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    public function draftPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author')
            ->wherePivot('user_id', $this->id)
            ->whereDraft();
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name was {$eventName}"
            );
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn ($value): string => $this->getFirstMediaUrl('avatar')
        );
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn ($value): bool => $this->getFirstMedia('avatar') !== null
        );
    }

    public function canManage(): Attribute
    {
        return new Attribute(
            get: function ($value): bool {
                return $this->isAbleTo('department.*')
                    || $this->isAbleTo('rank.*')
                    || $this->isAbleTo('role.*')
                    || $this->isAbleTo('theme.*')
                    || $this->isAbleTo('user.*');
            }
        );
    }

    public function canManageUsers(): Attribute
    {
        return new Attribute(
            get: function ($value): bool {
                return $this->isAbleTo('user.*')
                    || $this->isAbleTo('role.*');
            }
        );
    }

    public function canManageSystem(): Attribute
    {
        return new Attribute(
            get: function ($value): bool {
                return $this->isAbleTo('theme.*')
                    || $this->isAbleTo('system.activity')
                    || $this->isAbleTo('forms.*')
                    || $this->isAbleTo('pages.*');
            }
        );
    }

    public function canWrite(): Attribute
    {
        return new Attribute(
            get: function ($value): bool {
                return $this->isAbleTo('post.*')
                    || $this->isAbleTo('story.*')
                    || $this->isAbleTo('post-type.*');
            }
        );
    }

    public function hasRead(Notification $notification): bool
    {
        return $this->unreadNotifications()->where('id', $notification->id)->count() > 0;
    }

    public function canImpersonate()
    {
        return $this->isAbleTo('user.impersonate');
    }

    public function newCollection(array $models = []): UsersCollection
    {
        return new UsersCollection($models);
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://api.dicebear.com/7.x/bottts/svg?seed={$this->email}")
            ->useDisk('media')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public static function getMediaPath(): string
    {
        return 'users/{model_id}/{media_id}/';
    }
}
