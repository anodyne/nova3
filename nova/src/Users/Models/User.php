<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Lab404\Impersonate\Models\Impersonate;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Characters\Models\Character;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Models\UserNotificationPreference;
use Nova\Foundation\Nova;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Notes\Models\Note;
use Nova\Stories\Models\Post;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserPreferences;
use Nova\Users\Events;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\States\Status\UserStatus;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class User extends Authenticatable implements HasMedia, LaratrustUser, MustVerifyEmail
{
    use CausesActivity;
    use HasFactory;
    use HasPrefixedId;
    use HasRolesAndPermissions;
    use HasStates;
    use Impersonate;
    use InteractsWithMedia;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    protected $casts = [
        'password' => 'hashed',
        'force_password_reset' => 'boolean',
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
        'pronouns', 'appearance', 'preferences',
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
        return $this->characters()->active();
    }

    public function primaryCharacter(): BelongsToMany
    {
        return $this->activeCharacters()->wherePivot('primary', true);
    }

    public function discussions(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class)
            ->withTimestamps();
    }

    public function logins(): HasMany
    {
        return $this->hasMany(Login::class);
    }

    public function latestLogin(): HasOne
    {
        return $this->logins()->one()->ofMany();
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function formSubmissions(): MorphMany
    {
        return $this->morphMany(FormSubmission::class, 'owner');
    }

    public function userFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereHas('form', fn (Builder $query): Builder => $query->key('userBio'));
    }

    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author')
            ->wherePivot('user_id', $this->id);
    }

    public function draftPosts(): BelongsToMany
    {
        return $this->posts()->draft();
    }

    public function latestPost(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_author')
            ->published()
            ->latest('published_at')
            ->limit(1);
    }

    public function postsAsUser(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    public function publishedPosts(): BelongsToMany
    {
        return $this->posts()->published();
    }

    public function application(): HasOne
    {
        return $this->hasOne(Application::class);
    }

    public function globalApplicationReviewer(): HasOne
    {
        return $this->hasOne(ApplicationReviewer::class)->global();
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
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

    public function isPending(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    public function canManage(): Attribute
    {
        return new Attribute(
            get: function (): bool {
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
            get: function (): bool {
                return $this->isAbleTo('user.*')
                    || $this->isAbleTo('role.*');
            }
        );
    }

    public function canManageForms(): Attribute
    {
        return new Attribute(
            get: function (): bool {
                return $this->isAbleTo('form.*')
                    || $this->isAbleTo('form-submission.*');
            }
        );
    }

    public function canManageSystem(): Attribute
    {
        return new Attribute(
            get: function (): bool {
                return $this->isAbleTo('theme.*')
                    || $this->isAbleTo('menu.*')
                    || $this->isAbleTo('system.activity');
            }
        );
    }

    public function canWrite(): Attribute
    {
        return new Attribute(
            get: function (): bool {
                return $this->isAbleTo('post.*')
                    || $this->isAbleTo('story.*')
                    || $this->isAbleTo('post-type.*');
            }
        );
    }

    public function unreadAnnouncementsCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => once(fn () => AnnouncementNotification::user($this->id)->unread()->count()),
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(Nova::getAvatarUrl($this->name))
            ->useDisk('media')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public static function getMediaPath(): string
    {
        return 'users/{model_id}/{media_id}/';
    }
}
