<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
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
use Nova\Users\Events\UserCreated;
use Nova\Users\Events\UserDeleted;
use Nova\Users\Events\UserUpdated;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\Concerns\CanManageResources;
use Nova\Users\Models\Concerns\HasAnnouncements;
use Nova\Users\Models\Concerns\HasCharacters;
use Nova\Users\Models\Concerns\HasFormSubmissions;
use Nova\Users\Models\Concerns\HasLogins;
use Nova\Users\Models\Concerns\HasNotes;
use Nova\Users\Models\Concerns\HasOnboarding;
use Nova\Users\Models\Concerns\HasPosts;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Hidden;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\States\Status\UserStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

#[UseEloquentBuilder(UserBuilder::class)]
class User extends Authenticatable implements HasMedia, LaratrustUser, MustVerifyEmail
{
    use Bannable;
    use CanManageResources;
    use CausesActivity;
    use HasAnnouncements;
    use HasCharacters;
    use HasFactory;
    use HasFormSubmissions;
    use HasLogins;
    use HasNotes;
    use HasOnboarding;
    use HasPosts;
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
        'created' => UserCreated::class,
        'updated' => UserUpdated::class,
        'deleted' => UserDeleted::class,
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

    public function displayName(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->trashed() ? 'Deleted user' : $this->name
        );
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->getFirstMedia('avatar') !== null
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

    public function isHidden(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Hidden::class)
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
