<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Lab404\Impersonate\Models\Impersonate;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Mchev\Banhammer\Traits\Bannable;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\AnnouncementNotification;
use Nova\Applications\Models\Application;
use Nova\Applications\Models\ApplicationReviewer;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterUser;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Foundation\Models\StatusHistory;
use Nova\Foundation\Nova;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Notes\Models\Note;
use Nova\Onboarding\Models\Onboarding;
use Nova\Roles\Models\Permission;
use Nova\Roles\Models\Role;
use Nova\Roles\Models\Team;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property UserStatus $status
 * @property PronounsData $pronouns
 * @property string|null $remember_token
 * @property bool $force_password_reset
 * @property string|null $email_verified_at
 * @property UserPreferences|null $preferences
 * @property UserModerations|null $moderations
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read Collection<int, Activity> $actions
 * @property-read int|null $actions_count
 * @property-read CharacterUser|null $pivot
 * @property-read Collection<int, Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read Collection<int, Onboarding> $activeOnboardings
 * @property-read int|null $active_onboardings_count
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, AnnouncementNotification> $announcementNotifications
 * @property-read int|null $announcement_notifications_count
 * @property-read Collection<int, Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read Application|null $application
 * @property-read string $avatar_url
 * @property-read Collection<int, Ban> $bans
 * @property-read int|null $bans_count
 * @property-read bool $can_manage
 * @property-read bool $can_manage_forms
 * @property-read bool $can_manage_storytelling
 * @property-read bool $can_manage_system
 * @property-read bool $can_manage_users
 * @property-read bool $can_write
 * @property-read Collection<int, Character> $characters
 * @property-read int|null $characters_count
 * @property-read Collection<int, Discussion> $discussions
 * @property-read int|null $discussions_count
 * @property-read string $display_name
 * @property-read Collection<int, Post> $draftPosts
 * @property-read int|null $draft_posts_count
 * @property-read Collection<int, Post> $draftPostsNeedingAttention
 * @property-read int|null $draft_posts_needing_attention_count
 * @property-read Collection<int, FormSubmission> $formSubmissions
 * @property-read int|null $form_submissions_count
 * @property-read ApplicationReviewer|null $globalApplicationReviewer
 * @property-read bool $has_avatar
 * @property-read bool $is_active
 * @property-read bool $is_deleted
 * @property-read bool $is_hidden
 * @property-read bool $is_inactive
 * @property-read bool $is_moderated
 * @property-read bool $is_pending
 * @property-read Login|null $latestLogin
 * @property-read Collection<int, Post> $latestPost
 * @property-read int|null $latest_post_count
 * @property-read Collection<int, Login> $logins
 * @property-read int|null $logins_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read Collection<int, UserNotificationPreference> $notificationPreferences
 * @property-read int|null $notification_preferences_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Onboarding> $onboardings
 * @property-read int|null $onboardings_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Team> $permissionsTeams
 * @property-read int|null $permissions_teams_count
 * @property-read Collection<int, PostAuthor> $postAuthors
 * @property-read int|null $post_authors_count
 * @property-read Collection<int, Post> $posts
 * @property-read int|null $posts_count
 * @property-read Collection<int, Post> $postsAsUser
 * @property-read int|null $posts_as_user_count
 * @property-read Collection<int, Character> $primaryCharacter
 * @property-read int|null $primary_character_count
 * @property-read Collection<int, Post> $publishedPosts
 * @property-read int|null $published_posts_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, Team> $rolesTeams
 * @property-read int|null $roles_teams_count
 * @property-read Collection<int, StatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read int $unread_announcements_count
 * @property-read int $unread_messages_count
 * @property-read FormSubmission|null $userFormSubmission
 *
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User active()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User activeBetween(\Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User activeOrInactive()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User banned(bool $banned = true)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User bannedByType(string $className)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User countDistinct()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User hidden()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User inactive()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User moderatedOn(string $key)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User newModelQuery()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User newQuery()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User notBanned()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User notHidden()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User notPending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\User onlyTrashed()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User orWhereHasPermission(\BackedEnum|array|string $permission = '', ?mixed $team = null)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User orWhereHasRole(\BackedEnum|array|string $role = '', ?mixed $team = null)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User orWhereNotState(string $column, $states)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User orWhereState(string $column, $states)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User pending()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User query()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User searchFor(string $search)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User searchForBasic($search)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User searchForWithoutCharacters(string $search)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User selectTotalCount()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereBansMeta(string $key, $value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereCreatedAt($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereDeletedAt($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereDoesntHavePermissions()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereDoesntHaveRoles()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereEmail($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereEmailVerifiedAt($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereForcePasswordReset($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereHasPermission(\BackedEnum|array|string $permission = '', ?mixed $team = null, string $boolean = 'and')
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereHasRole(\BackedEnum|array|string $role = '', ?mixed $team = null, string $boolean = 'and')
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereId($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereModerationDoesntHaveTrue()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereModerationHasTrue()
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereModerations($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereName($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereNotState(string $column, $states)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User wherePassword($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User wherePreferences($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User wherePrefixedId($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User wherePronouns($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereRememberToken($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereState(string $column, $states)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereStatus($value)
 * @method static \Nova\Users\Models\Builders\UserBuilder<static>|\Nova\Users\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\User withoutTrashed()
 *
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

    public function application(): HasOne
    {
        return $this->hasOne(Application::class);
    }

    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->getFirstMediaUrl('avatar')
        );
    }

    public function canImpersonate(): bool
    {
        return $this->isAbleTo('user.impersonate');
    }

    public function discussions(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class)
            ->withTimestamps();
    }

    public function displayName(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->trashed() ? 'Deleted user' : $this->name
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept([
            'password',
        ]);
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function globalApplicationReviewer(): HasOne
    {
        return $this->hasOne(ApplicationReviewer::class)->global();
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->getFirstMedia('avatar') !== null
        );
    }

    public function hasRead(Notification $notification): bool
    {
        return $this->unreadNotifications()->where('id', $notification->id)->count() > 0;
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

    public function isHidden(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Hidden::class)
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
            get: fn (): bool => $this->moderations?->isModerated(),
        );
    }

    public function isPending(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(UserNotificationPreference::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(Nova::getAvatarUrl($this->name))
            ->useDisk('media-users')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    public function unreadMessagesCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => once(fn () => DiscussionNotification::user($this->id)->unread()->count()),
        );
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
