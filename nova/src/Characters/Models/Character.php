<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Database\Factories\CharacterFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Nova\Applications\Models\Application;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events\CharacterCreated;
use Nova\Characters\Events\CharacterDeleted;
use Nova\Characters\Events\CharacterForceDeleted;
use Nova\Characters\Events\CharacterRestored;
use Nova\Characters\Events\CharacterUpdated;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\Concerns\HasUsers;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\CharacterStatus;
use Nova\Characters\Models\States\Status\Hidden;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;
use Nova\Departments\Models\Position;
use Nova\Forms\Models\Builders\FormBuilder;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Foundation\Models\StatusHistory;
use Nova\Foundation\Nova;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Ranks\Models\RankItem;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property CharacterType $type
 * @property CharacterStatus $status
 * @property int|null $rank_id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read CharacterPosition|CharacterUser|PostAuthor|null $pivot
 * @property-read Collection<int, User> $activePrimaryUsers
 * @property-read int|null $active_primary_users_count
 * @property-read Collection<int, User> $activeUsers
 * @property-read int|null $active_users_count
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Application|null $application
 * @property-read string $avatar_url
 * @property-read FormSubmission|null $characterFormSubmission
 * @property-read string $display_name
 * @property-read Collection<int, FormSubmission> $formSubmissions
 * @property-read int|null $form_submissions_count
 * @property-read bool $has_avatar
 * @property-read bool $is_active
 * @property-read bool $is_deleted
 * @property-read bool $is_hidden
 * @property-read bool $is_inactive
 * @property-read bool $is_pending
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Position> $positions
 * @property-read int|null $positions_count
 * @property-read Collection<int, Post> $postAuthors
 * @property-read int|null $post_authors_count
 * @property-read Collection<int, Post> $posts
 * @property-read int|null $posts_count
 * @property-read Collection<int, User> $primaryUsers
 * @property-read int|null $primary_users_count
 * @property-read RankItem|null $rank
 * @property-read Collection<int, StatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static CharacterBuilder<static>|Character active()
 * @method static CharacterBuilder<static>|Character activeBetween(CarbonInterface $start, CarbonInterface $end)
 * @method static CharacterFactory factory($count = null, $state = [])
 * @method static CharacterBuilder<static>|Character hidden()
 * @method static CharacterBuilder<static>|Character inactive()
 * @method static CharacterBuilder<static>|Character isAssignedTo(User $user)
 * @method static CharacterBuilder<static>|Character newModelQuery()
 * @method static CharacterBuilder<static>|Character newQuery()
 * @method static CharacterBuilder<static>|Character notHidden()
 * @method static CharacterBuilder<static>|Character notPending()
 * @method static CharacterBuilder<static>|Character notPrimary()
 * @method static CharacterBuilder<static>|Character notSecondary()
 * @method static CharacterBuilder<static>|Character notSupport()
 * @method static Builder<static>|Character onlyTrashed()
 * @method static CharacterBuilder<static>|Character orWhereNotState(string $column, $states)
 * @method static CharacterBuilder<static>|Character orWhereState(string $column, $states)
 * @method static CharacterBuilder<static>|Character pending()
 * @method static CharacterBuilder<static>|Character primary()
 * @method static CharacterBuilder<static>|Character query()
 * @method static CharacterBuilder<static>|Character searchFor($search)
 * @method static CharacterBuilder<static>|Character searchForBasic($search)
 * @method static CharacterBuilder<static>|Character searchForWithoutUsers($search)
 * @method static CharacterBuilder<static>|Character secondary()
 * @method static CharacterBuilder<static>|Character selectTotalCount()
 * @method static CharacterBuilder<static>|Character selectTypeCounts()
 * @method static CharacterBuilder<static>|Character support()
 * @method static CharacterBuilder<static>|Character whereCreatedAt($value)
 * @method static CharacterBuilder<static>|Character whereDeletedAt($value)
 * @method static CharacterBuilder<static>|Character whereId($value)
 * @method static CharacterBuilder<static>|Character whereIsPrimaryCharacter()
 * @method static CharacterBuilder<static>|Character whereName($value)
 * @method static CharacterBuilder<static>|Character whereNotState(string $column, $states)
 * @method static CharacterBuilder<static>|Character wherePrefixedId($value)
 * @method static CharacterBuilder<static>|Character whereRankId($value)
 * @method static CharacterBuilder<static>|Character whereState(string $column, $states)
 * @method static CharacterBuilder<static>|Character whereStatus($value)
 * @method static CharacterBuilder<static>|Character whereType($value)
 * @method static CharacterBuilder<static>|Character whereUpdatedAt($value)
 * @method static Builder<static>|Character withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Character withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(CharacterBuilder::class)]
class Character extends Model implements HasMedia
{
    use HasFactory;
    use HasPrefixedId;
    use HasStates;
    use HasUsers;
    use InteractsWithMedia;
    use LogsActivity;
    use Searchable;
    use SoftDeletes;

    protected $casts = [
        'status' => CharacterStatus::class,
        'type' => CharacterType::class,
    ];

    protected $dispatchesEvents = [
        'created' => CharacterCreated::class,
        'deleted' => CharacterDeleted::class,
        'updated' => CharacterUpdated::class,
        'forceDeleted' => CharacterForceDeleted::class,
        'restored' => CharacterRestored::class,
    ];

    protected $fillable = [
        'name', 'status', 'rank_id', 'type',
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

    public function canBeDeleted(): bool
    {
        return $this->posts()->count() === 0;
    }

    public function characterFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereHas('form', fn (FormBuilder $query): FormBuilder => $query->key('characterBio'));
    }

    public function displayName(): Attribute
    {
        $this->loadMissing('rank.name');

        return new Attribute(
            get: fn (): string => trim($this->rank?->name?->name.' '.$this->name)
        );
    }

    public function formSubmissions(): MorphMany
    {
        return $this->morphMany(FormSubmission::class, 'owner');
    }

    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->getFirstMedia('avatar') instanceof Media
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

    public function isPending(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)
            ->using(CharacterPosition::class);
    }

    public function postAuthors(): MorphToMany
    {
        return $this->morphToMany(
            Post::class,
            'authorable',
            'post_author',
        )->withPivot(['user_id', 'authorable_type'])
            ->select([
                'posts.id as post_id', // ✅ Explicitly selecting "id" from posts
                'posts.title', // Select only necessary columns
                'post_author.user_id', // ✅ Ensure pivot data is included
                'post_author.authorable_id',
                'post_author.authorable_type',
            ]);
    }

    public function posts(): MorphToMany
    {
        return $this->morphToMany(Post::class, 'authorable', 'post_author');
    }

    public function rank(): HasOne
    {
        return $this->hasOne(RankItem::class, 'id', 'rank_id');
    }

    public function rankId(): Attribute
    {
        return new Attribute(
            set: fn ($value): ?int => $value === 0 ? null : $value
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl(Nova::getAvatarUrl($this->name))
            ->useDisk('media-characters')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile();
    }

    public function shouldBeSearchable(): bool
    {
        return ! $this->is_pending;
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'prefixed_id' => $this->prefixed_id,
            'name' => $this->name,
        ];
    }

    public static function getMediaPath(): string
    {
        return '{model_id}/{media_id}/';
    }
}
