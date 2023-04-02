<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active as ActiveCharacter;
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
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStates\HasStates;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class User extends Authenticatable implements MustVerifyEmail, HasMedia, LaratrustUser
{
    use CausesActivity;
    use HasEagerLimit;
    use HasFactory;
    use HasRolesAndPermissions;
    use HasStates;
    use InteractsWithMedia;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    public const MEDIA_DIRECTORY = 'users/{model_id}/{media_id}/';

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

    public function characters()
    {
        return $this->belongsToMany(Character::class)
            ->withPivot('primary')
            ->withTimestamps();
    }

    public function activeCharacters()
    {
        return $this->characters()->whereState('status', ActiveCharacter::class);
    }

    public function primaryCharacter()
    {
        return $this->activeCharacters()->wherePivot('primary', true);
    }

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function latestLogin()
    {
        return $this->hasOne(Login::class)->ofMany();
    }

    public function notes()
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
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name was {$eventName}"
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

    /**
     * Can the user do any management in the app?
     *
     * @return bool
     */
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
                return $this->isAbleTo('theme.*');
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     *
     * @return \Nova\Users\Models\UsersCollection
     */
    public function newCollection(array $models = []): UsersCollection
    {
        return new UsersCollection($models);
    }

    /**
     * Use the customized Eloquent builder when working with users.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return UserBuilder
     */
    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    /**
     * Register the media collections for the model.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://avatars.dicebear.com/api/bottts/{$this->email}.svg")
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }
}
