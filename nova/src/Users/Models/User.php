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

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property UserStatus $status
 * @property \Bag\Bag $pronouns
 * @property string|null $remember_token
 * @property bool $force_password_reset
 * @property string|null $email_verified_at
 * @property \Bag\Bag|null $preferences
 * @property \Bag\Bag|null $moderations
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $actions
 * @property-read int|null $actions_count
 * @property-read \Nova\Characters\Models\CharacterUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Onboarding\Models\Onboarding> $activeOnboardings
 * @property-read int|null $active_onboardings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Announcements\Models\AnnouncementNotification> $announcementNotifications
 * @property-read int|null $announcement_notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Announcements\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read Application|null $application
 * @property-read string $avatar_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\Ban> $bans
 * @property-read int|null $bans_count
 * @property-read bool $can_manage
 * @property-read bool $can_manage_forms
 * @property-read bool $can_manage_storytelling
 * @property-read bool $can_manage_system
 * @property-read bool $can_manage_users
 * @property-read bool $can_write
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Discussion> $discussions
 * @property-read int|null $discussions_count
 * @property-read string $display_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $draftPosts
 * @property-read int|null $draft_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $draftPostsNeedingAttention
 * @property-read int|null $draft_posts_needing_attention_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmission> $formSubmissions
 * @property-read int|null $form_submissions_count
 * @property-read ApplicationReviewer|null $globalApplicationReviewer
 * @property-read bool $has_avatar
 * @property-read bool $is_active
 * @property-read bool $is_deleted
 * @property-read bool $is_hidden
 * @property-read bool $is_inactive
 * @property-read bool $is_moderated
 * @property-read bool $is_pending
 * @property-read \Nova\Users\Models\Login|null $latestLogin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $latestPost
 * @property-read int|null $latest_post_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\Login> $logins
 * @property-read int|null $logins_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Notes\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\UserNotificationPreference> $notificationPreferences
 * @property-read int|null $notification_preferences_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Onboarding\Models\Onboarding> $onboardings
 * @property-read int|null $onboardings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Team> $permissionsTeams
 * @property-read int|null $permissions_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\PostAuthor> $postAuthors
 * @property-read int|null $post_authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $postsAsUser
 * @property-read int|null $posts_as_user_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $primaryCharacter
 * @property-read int|null $primary_character_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $publishedPosts
 * @property-read int|null $published_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Team> $rolesTeams
 * @property-read int|null $roles_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read int $unread_announcements_count
 * @property-read int $unread_messages_count
 * @property-read \Nova\Forms\Models\FormSubmission|null $userFormSubmission
 * @method static UserBuilder<static>|User active()
 * @method static UserBuilder<static>|User activeBetween(\Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end)
 * @method static UserBuilder<static>|User activeOrInactive()
 * @method static UserBuilder<static>|User banned(bool $banned = true)
 * @method static UserBuilder<static>|User bannedByType(string $className)
 * @method static UserBuilder<static>|User countDistinct()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static UserBuilder<static>|User hidden()
 * @method static UserBuilder<static>|User inactive()
 * @method static UserBuilder<static>|User moderatedOn(string $key)
 * @method static UserBuilder<static>|User newModelQuery()
 * @method static UserBuilder<static>|User newQuery()
 * @method static UserBuilder<static>|User notBanned()
 * @method static UserBuilder<static>|User notHidden()
 * @method static UserBuilder<static>|User notPending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static UserBuilder<static>|User orWhereHasPermission(\BackedEnum|array|string $permission = '', ?mixed $team = null)
 * @method static UserBuilder<static>|User orWhereHasRole(\BackedEnum|array|string $role = '', ?mixed $team = null)
 * @method static UserBuilder<static>|User orWhereNotState(string $column, $states)
 * @method static UserBuilder<static>|User orWhereState(string $column, $states)
 * @method static UserBuilder<static>|User pending()
 * @method static UserBuilder<static>|User query()
 * @method static UserBuilder<static>|User searchFor(string $search)
 * @method static UserBuilder<static>|User searchForBasic($search)
 * @method static UserBuilder<static>|User searchForWithoutCharacters(string $search)
 * @method static UserBuilder<static>|User selectTotalCount()
 * @method static UserBuilder<static>|User whereBansMeta(string $key, $value)
 * @method static UserBuilder<static>|User whereCreatedAt($value)
 * @method static UserBuilder<static>|User whereDeletedAt($value)
 * @method static UserBuilder<static>|User whereDoesntHavePermissions()
 * @method static UserBuilder<static>|User whereDoesntHaveRoles()
 * @method static UserBuilder<static>|User whereEmail($value)
 * @method static UserBuilder<static>|User whereEmailVerifiedAt($value)
 * @method static UserBuilder<static>|User whereForcePasswordReset($value)
 * @method static UserBuilder<static>|User whereHasPermission(\BackedEnum|array|string $permission = '', ?mixed $team = null, string $boolean = 'and')
 * @method static UserBuilder<static>|User whereHasRole(\BackedEnum|array|string $role = '', ?mixed $team = null, string $boolean = 'and')
 * @method static UserBuilder<static>|User whereId($value)
 * @method static UserBuilder<static>|User whereModerationDoesntHaveTrue()
 * @method static UserBuilder<static>|User whereModerationHasTrue()
 * @method static UserBuilder<static>|User whereModerations($value)
 * @method static UserBuilder<static>|User whereName($value)
 * @method static UserBuilder<static>|User whereNotState(string $column, $states)
 * @method static UserBuilder<static>|User wherePassword($value)
 * @method static UserBuilder<static>|User wherePreferences($value)
 * @method static UserBuilder<static>|User wherePrefixedId($value)
 * @method static UserBuilder<static>|User wherePronouns($value)
 * @method static UserBuilder<static>|User whereRememberToken($value)
 * @method static UserBuilder<static>|User whereState(string $column, $states)
 * @method static UserBuilder<static>|User whereStatus($value)
 * @method static UserBuilder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
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
