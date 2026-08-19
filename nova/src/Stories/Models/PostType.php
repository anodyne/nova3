<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Anodyne\TablerIcons\Tabler;
use Carbon\CarbonImmutable;
use Database\Factories\PostTypeFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Roles\Models\Role;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Events\PostTypeCreated;
use Nova\Stories\Events\PostTypeDeleted;
use Nova\Stories\Events\PostTypeForceDeleted;
use Nova\Stories\Events\PostTypeRestored;
use Nova\Stories\Events\PostTypeUpdated;
use Nova\Stories\Models\Builders\PostTypeBuilder;
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $key
 * @property string $name
 * @property string|null $description
 * @property string|null $color
 * @property Tabler|null $icon
 * @property int|null $role_id
 * @property BasicStatus $status
 * @property PostTypeVisibility $visibility
 * @property Fields|null $fields
 * @property Options|null $options
 * @property int|null $order_column
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $included_in_post_tracking
 * @property-read bool $notifies_users
 * @property-read Collection<int, Post> $posts
 * @property-read int|null $posts_count
 * @property-read Collection<int, Post> $publishedPosts
 * @property-read int|null $published_posts_count
 * @property-read Role|null $role
 * @property-read string $title
 *
 * @method static PostTypeBuilder<static>|PostType active()
 * @method static PostTypeFactory factory($count = null, $state = [])
 * @method static PostTypeBuilder<static>|PostType inCharacter()
 * @method static PostTypeBuilder<static>|PostType inactive()
 * @method static PostTypeBuilder<static>|PostType newModelQuery()
 * @method static PostTypeBuilder<static>|PostType newQuery()
 * @method static Builder<static>|PostType onlyTrashed()
 * @method static PostTypeBuilder<static>|PostType orWhereNotState(string $column, $states)
 * @method static PostTypeBuilder<static>|PostType orWhereState(string $column, $states)
 * @method static PostTypeBuilder<static>|PostType ordered(string $direction = 'asc')
 * @method static PostTypeBuilder<static>|PostType query()
 * @method static PostTypeBuilder<static>|PostType searchFor($search)
 * @method static PostTypeBuilder<static>|PostType userHasAccess(Authenticatable $user)
 * @method static PostTypeBuilder<static>|PostType whereColor($value)
 * @method static PostTypeBuilder<static>|PostType whereCreatedAt($value)
 * @method static PostTypeBuilder<static>|PostType whereDeletedAt($value)
 * @method static PostTypeBuilder<static>|PostType whereDescription($value)
 * @method static PostTypeBuilder<static>|PostType whereFields($value)
 * @method static PostTypeBuilder<static>|PostType whereIcon($value)
 * @method static PostTypeBuilder<static>|PostType whereId($value)
 * @method static PostTypeBuilder<static>|PostType whereKey($value)
 * @method static PostTypeBuilder<static>|PostType whereName($value)
 * @method static PostTypeBuilder<static>|PostType whereNotState(string $column, $states)
 * @method static PostTypeBuilder<static>|PostType whereOptions($value)
 * @method static PostTypeBuilder<static>|PostType whereOrderColumn($value)
 * @method static PostTypeBuilder<static>|PostType wherePrefixedId($value)
 * @method static PostTypeBuilder<static>|PostType whereRoleId($value)
 * @method static PostTypeBuilder<static>|PostType whereState(string $column, $states)
 * @method static PostTypeBuilder<static>|PostType whereStatus($value)
 * @method static PostTypeBuilder<static>|PostType whereUpdatedAt($value)
 * @method static PostTypeBuilder<static>|PostType whereVisibility($value)
 * @method static Builder<static>|PostType withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|PostType withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(PostTypeBuilder::class)]
class PostType extends Model implements Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasStates;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;

    protected $casts = [
        'fields' => Fields::class,
        'icon' => Tabler::class,
        'options' => Options::class,
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'visibility' => PostTypeVisibility::class,
    ];

    protected $dispatchesEvents = [
        'created' => PostTypeCreated::class,
        'deleted' => PostTypeDeleted::class,
        'updated' => PostTypeUpdated::class,
        'forceDeleted' => PostTypeForceDeleted::class,
        'restored' => PostTypeRestored::class,
    ];

    protected $fillable = [
        'color',
        'description',
        'fields',
        'icon',
        'key',
        'name',
        'options',
        'order_column',
        'role_id',
        'status',
        'visibility',
    ];

    protected $table = 'post_types';

    /**
     * This attribute exists to allow for the table to have a column for this data.
     */
    public function includedInPostTracking(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->includedInPostTracking
        );
    }

    /**
     * This attribute exists to allow for the table to have a column for this data.
     */
    public function notifiesUsers(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->notifiesUsers
        );
    }

    /**
     * @return HasMany<Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return HasMany<Post, $this>
     */
    public function publishedPosts(): HasMany
    {
        return $this->posts()->published();
    }

    /**
     * @return BelongsTo<Role, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->name
        );
    }
}
