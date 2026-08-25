<?php

declare(strict_types=1);

namespace Nova\Characters\Models;

use Database\Factories\CharacterFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperCharacter
 */
#[UseEloquentBuilder(CharacterBuilder::class)]
class Character extends Model implements HasMedia
{
    /** @use HasFactory<CharacterFactory> */
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

    /**
     * @return HasOne<Application, $this>
     */
    public function application(): HasOne
    {
        return $this->hasOne(Application::class);
    }

    /**
     * @return MorphOne<FormSubmission, $this>
     */
    public function characterFormSubmission(): MorphOne
    {
        return $this->morphOne(FormSubmission::class, 'owner')
            ->whereHas('form', function (Builder $query): void {
                /** @var FormBuilder $formQuery */
                $formQuery = $query;

                $formQuery->key('characterBio');
            });
    }

    /**
     * @return MorphMany<FormSubmission, $this>
     */
    public function formSubmissions(): MorphMany
    {
        return $this->morphMany(FormSubmission::class, 'owner');
    }

    /**
     * @return BelongsToMany<Position, $this, CharacterPosition, 'pivot'>
     */
    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)
            ->using(CharacterPosition::class);
    }

    /**
     * @return MorphToMany<Post, $this, PostAuthor, 'pivot'>
     */
    public function postAuthors(): MorphToMany
    {
        return $this->morphToMany(
            Post::class,
            'authorable',
            'post_author',
        )
            ->using(PostAuthor::class)
            ->withPivot(['user_id', 'authorable_type'])
            ->select([
                'posts.id as post_id', // ✅ Explicitly selecting "id" from posts
                'posts.title', // Select only necessary columns
                'post_author.user_id', // ✅ Ensure pivot data is included
                'post_author.authorable_id',
                'post_author.authorable_type',
            ]);
    }

    /**
     * @return MorphToMany<Post, $this, PostAuthor, 'pivot'>
     */
    public function posts(): MorphToMany
    {
        return $this->morphToMany(
            Post::class,
            'authorable',
            'post_author'
        )->using(PostAuthor::class);
    }

    /**
     * @return HasOne<RankItem, $this>
     */
    public function rank(): HasOne
    {
        return $this->hasOne(RankItem::class, 'id', 'rank_id');
    }

    /**
     * @return MorphMany<StatusHistory, $this>
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    /**
     * @return Attribute<string, never>
     */
    public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->getFirstMediaUrl('avatar')
        );
    }

    /**
     * @return Attribute<string, never>
     */
    public function displayName(): Attribute
    {
        $this->loadMissing('rank.name');

        return new Attribute(
            get: fn (): string => trim($this->rank?->name?->name.' '.$this->name)
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function hasAvatar(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->getFirstMedia('avatar') instanceof Media
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isActive(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Active::class)
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isDeleted(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->trashed()
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isHidden(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Hidden::class)
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isInactive(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Inactive::class)
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isPending(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->status->equals(Pending::class)
        );
    }

    /**
     * @return Attribute<?int, never>
     */
    public function rankId(): Attribute
    {
        return new Attribute(
            set: fn ($value): ?int => $value === 0 ? null : $value
        );
    }

    public function canBeDeleted(): bool
    {
        return $this->posts()->count() === 0;
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

    /**
     * @return array{
     *     id: int,
     *     prefixed_id: string|null,
     *     name: string
     * }
     */
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
