<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Nova\Foundation\Models{
/**
 * @property int $id
 * @property string $version
 * @property string $series
 * @property \Nova\Foundation\Enums\ReleaseSeverity $severity
 * @property string $description
 * @property string|null $notes
 * @property array<array-key, mixed>|null $tags
 * @property \Carbon\CarbonImmutable $release_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalChangelog whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperExternalChangelog {}
}

namespace Nova\Foundation\Models{
/**
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\ExternalContent whereValue($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperExternalContent {}
}

namespace Nova\Foundation\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string|null $description
 * @property string|null $notes
 * @property \Nova\Foundation\Enums\NotificationAudience $audience
 * @property bool $database
 * @property bool $database_default
 * @property bool $mail
 * @property bool $mail_default
 * @property bool $discord
 * @property \Nova\Settings\Data\Discord|null $discord_settings
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read string|null $discord_color
 * @property-read string|null $discord_webhook
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\UserNotificationPreference> $userNotificationPreferences
 * @property-read int|null $user_notification_preferences_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereAudience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDatabaseDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDiscord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereDiscordSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereMailDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\NotificationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNotificationType {}
}

namespace Nova\Foundation\Models{
/**
 * @property int $id
 * @property string $statusable_type
 * @property int $statusable_id
 * @property string $status
 * @property \Carbon\CarbonImmutable $started_at
 * @property \Carbon\CarbonImmutable|null $ended_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $statusable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatusableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereStatusableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\StatusHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperStatusHistory {}
}

namespace Nova\Foundation\Models{
/**
 * @property int $id
 * @property string $version
 * @property string|null $anodyne_game_id
 * @property \Carbon\CarbonImmutable|null $install_date
 * @property \Carbon\CarbonImmutable|null $last_update
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereAnodyneGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereInstallDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Foundation\Models\SystemInfo whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSystemInfo {}
}

namespace Nova\Addons\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property \Nova\Addons\Enums\AddonType $type
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Nova\Addons\Data\AddonSettings|null $settings
 * @property \Nova\Addons\Data\AddonRepository|null $repository
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_addon_class
 * @property-read bool $has_update
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon active()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon extension()
 * @method static \Database\Factories\AddonFactory factory($count = null, $state = [])
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon genre()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon inactive()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon location(string $location)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon newModelQuery()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon newQuery()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon query()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon rankSet()
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon searchFor($column, $search)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereCreatedAt($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereCredits($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereId($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereLocation($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereName($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon wherePrefixedId($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon wherePreview($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereRepository($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereSettings($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereStatus($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereType($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereUpdatedAt($value)
 * @method static \Nova\Addons\Models\Builders\AddonBuilder<static>|\Nova\Addons\Models\Addon whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAddon {}
}

namespace Nova\Announcements\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $category
 * @property string $content
 * @property \Nova\Foundation\Enums\PublishStatus $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Announcements\Models\AnnouncementNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement draft()
 * @method static \Database\Factories\AnnouncementFactory factory($count = null, $state = [])
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement newModelQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement newQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement pending()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement published()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement query()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement searchFor($search)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement uniqueCategories()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereCategory($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereContent($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereCreatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement wherePrefixedId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement wherePublishedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereStatus($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereTitle($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereUpdatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement whereUserId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement withReadNotificationsForUser(\Nova\Users\Models\User $user)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementBuilder<static>|\Nova\Announcements\Models\Announcement withUnreadNotificationsForUser(\Nova\Users\Models\User $user)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnnouncement {}
}

namespace Nova\Announcements\Models{
/**
 * @property int $id
 * @property int $announcement_id
 * @property int $user_id
 * @property bool $is_seen
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Nova\Announcements\Models\Announcement $announcement
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification announcement(int $announcementId)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification newModelQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification newQuery()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification query()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification read()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification unread()
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification user(int $userId)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereAnnouncementId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereCreatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereId($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereIsSeen($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereUpdatedAt($value)
 * @method static \Nova\Announcements\Models\Builders\AnnouncementNotificationBuilder<static>|\Nova\Announcements\Models\AnnouncementNotification whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnnouncementNotification {}
}

namespace Nova\Applications\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $user_id
 * @property int|null $character_id
 * @property string|null $ip_address
 * @property \Nova\Applications\Enums\ApplicationResult $result
 * @property string|null $decision_message
 * @property \Carbon\CarbonImmutable|null $decision_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Nova\Applications\Models\ApplicationReview|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $acceptedReviews
 * @property-read int|null $accepted_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\FormSubmission|null $applicationFormSubmission
 * @property-read \Nova\Characters\Models\Character|null $character
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $deniedReviews
 * @property-read int|null $denied_reviews_count
 * @property-read \Nova\Discussions\Models\Discussion|null $discussion
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $noResultReviews
 * @property-read int|null $no_result_reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Database\Factories\ApplicationFactory factory($count = null, $state = [])
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application newModelQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application newQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application pending()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application query()
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application reviewedBy(\Nova\Users\Models\User $user)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application searchFor($search)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereCharacterId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereCreatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereDecisionDate($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereDecisionMessage($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereIpAddress($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application wherePrefixedId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereResult($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereUpdatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationBuilder<static>|\Nova\Applications\Models\Application whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperApplication {}
}

namespace Nova\Applications\Models{
/**
 * @property int $id
 * @property int $application_id
 * @property int $user_id
 * @property \Nova\Applications\Enums\ApplicationResult|null $result
 * @property string|null $comments
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Applications\Models\Application $application
 * @property-read bool $is_accepted
 * @property-read bool $is_denied
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Applications\Models\ApplicationReview whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperApplicationReview {}
}

namespace Nova\Applications\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Nova\Applications\Enums\ReviewerType $type
 * @property array<array-key, mixed>|null $conditions
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer conditional()
 * @method static \Database\Factories\ApplicationReviewerFactory factory($count = null, $state = [])
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer global()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer globalReviewersWithApprovalPermission()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer newModelQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer newQuery()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer query()
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereConditions($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereCreatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereId($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereType($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereUpdatedAt($value)
 * @method static \Nova\Applications\Models\Builders\ApplicationReviewerBuilder<static>|\Nova\Applications\Models\ApplicationReviewer whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperApplicationReviewer {}
}

namespace Nova\Characters\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property \Nova\Characters\Enums\CharacterType $type
 * @property \Nova\Characters\Models\States\Status\CharacterStatus $status
 * @property int|null $rank_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Nova\Characters\Models\CharacterPosition|\Nova\Characters\Models\CharacterUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $activePrimaryUsers
 * @property-read int|null $active_primary_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $activeUsers
 * @property-read int|null $active_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Applications\Models\Application|null $application
 * @property-read string $avatar_url
 * @property-read \Nova\Forms\Models\FormSubmission|null $characterFormSubmission
 * @property-read string $display_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmission> $formSubmissions
 * @property-read int|null $form_submissions_count
 * @property-read bool $has_avatar
 * @property-read bool $is_active
 * @property-read bool $is_deleted
 * @property-read bool $is_hidden
 * @property-read bool $is_inactive
 * @property-read bool $is_pending
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Departments\Models\Position> $positions
 * @property-read int|null $positions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $postAuthors
 * @property-read int|null $post_authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $primaryUsers
 * @property-read int|null $primary_users_count
 * @property-read \Nova\Ranks\Models\RankItem|null $rank
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Foundation\Models\StatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character active()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character activeBetween(\Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end)
 * @method static \Database\Factories\CharacterFactory factory($count = null, $state = [])
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character hidden()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character inactive()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character isAssignedTo(\Nova\Users\Models\User $user)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character newModelQuery()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character newQuery()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character notHidden()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character notPending()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character notPrimary()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character notSecondary()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character notSupport()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\Character onlyTrashed()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character orWhereNotState(string $column, $states)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character orWhereState(string $column, $states)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character pending()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character primary()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character query()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character searchFor($search)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character searchForBasic($search)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character searchForWithoutUsers($search)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character secondary()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character selectTotalCount()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character selectTypeCounts()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character support()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereCreatedAt($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereDeletedAt($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereId($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereIsPrimaryCharacter()
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereName($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereNotState(string $column, $states)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character wherePrefixedId($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereRankId($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereState(string $column, $states)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereStatus($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereType($value)
 * @method static \Nova\Characters\Models\Builders\CharacterBuilder<static>|\Nova\Characters\Models\Character whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\Character withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\Character withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCharacter {}
}

namespace Nova\Characters\Models{
/**
 * @property int $id
 * @property int $character_id
 * @property int $position_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterPosition wherePositionId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCharacterPosition {}
}

namespace Nova\Characters\Models{
/**
 * @property int $id
 * @property int $character_id
 * @property int $user_id
 * @property bool $primary
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Characters\Models\CharacterUser whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCharacterUser {}
}

namespace Nova\Departments\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string|null $description
 * @property int|null $order_column
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property array<array-key, mixed>|null $tags
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Departments\Models\Position> $positions
 * @property-read int|null $positions_count
 * @property-read string $tags_as_string
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $activeUsers
 * @property-read int|null $active_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department active()
 * @method static \Database\Factories\DepartmentFactory factory($count = null, $state = [])
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department hasTags(array $tags)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department inactive()
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department newModelQuery()
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department newQuery()
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department ordered(string $direction = 'asc')
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department query()
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department searchFor($search)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department uniqueTags()
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereCreatedAt($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereDescription($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereId($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereName($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereOrderColumn($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department wherePrefixedId($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereStatus($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereTags($value)
 * @method static \Nova\Departments\Models\Builders\DepartmentBuilder<static>|\Nova\Departments\Models\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDepartment {}
}

namespace Nova\Departments\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $department_id
 * @property string $name
 * @property string|null $description
 * @property int $available
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property array<array-key, mixed>|null $tags
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Nova\Characters\Models\CharacterPosition|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $activeCharacters
 * @property-read int|null $active_characters_count
 * @property-read int|null $active_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Nova\Departments\Models\Department $department
 * @property-read string $tags_as_string
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $activeUsers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position active()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position available()
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position forDepartment($id)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position hasTags(array $tags)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position inactive()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position newModelQuery()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position newQuery()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position ordered(string $direction = 'asc')
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position query()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position searchFor($search)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position uniqueTags()
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereAvailable($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereCreatedAt($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereDepartmentId($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereDescription($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereId($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereName($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereOrderColumn($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position wherePrefixedId($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereStatus($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereTags($value)
 * @method static \Nova\Departments\Models\Builders\PositionBuilder<static>|\Nova\Departments\Models\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPosition {}
}

namespace Nova\Discussions\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string|null $discussable_type
 * @property int|null $discussable_id
 * @property string|null $subject
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Discussions\Models\DiscussionParticipant|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $allParticipants
 * @property-read int|null $all_participants_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $discussable
 * @property-read bool $has_unread_messages
 * @property-read bool $is_direct_message
 * @property-read bool $is_group_message
 * @property-read \Nova\Discussions\Models\DiscussionMessage|null $lastMessage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Discussions\Models\DiscussionMessage> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Discussions\Models\DiscussionNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $participants
 * @property-read int|null $participants_count
 * @property-read string $participants_string
 * @property-read string $truncated_participants_string
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion conversation()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion directMessage()
 * @method static \Database\Factories\DiscussionFactory factory($count = null, $state = [])
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion forCurrentUser()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion groupMessage()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion newModelQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion newQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion query()
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion searchFor(string $search)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereCreatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereDiscussableId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereDiscussableType($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion wherePrefixedId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereSubject($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion whereUpdatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionBuilder<static>|\Nova\Discussions\Models\Discussion withoutCurrentUser()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDiscussion {}
}

namespace Nova\Discussions\Models{
/**
 * @property int $id
 * @property int $discussion_id
 * @property int|null $user_id
 * @property string $content
 * @property \Nova\Discussions\Enums\MessageType $type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Discussions\Models\Discussion $discussion
 * @property-read bool $has_unread_messages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Discussions\Models\DiscussionNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Database\Factories\DiscussionMessageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereDiscussionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDiscussionMessage {}
}

namespace Nova\Discussions\Models{
/**
 * @property int $id
 * @property int $discussion_id
 * @property int $discussion_message_id
 * @property int $user_id
 * @property int $is_seen
 * @property int $is_sender
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification discussion(int $discussionId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification newModelQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification newQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification query()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification unread()
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification user(int $userId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereCreatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDeletedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDiscussionId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereDiscussionMessageId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereIsSeen($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereIsSender($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereUpdatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionNotificationBuilder<static>|\Nova\Discussions\Models\DiscussionNotification whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDiscussionNotification {}
}

namespace Nova\Discussions\Models{
/**
 * @property int $id
 * @property int $discussion_id
 * @property int $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Nova\Discussions\Models\Discussion|null $discussion
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant discussion(int $discussionId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant newModelQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant newQuery()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant query()
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant user(int $userId)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereCreatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereDeletedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereDiscussionId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereId($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereUpdatedAt($value)
 * @method static \Nova\Discussions\Models\Builders\DiscussionParticipantBuilder<static>|\Nova\Discussions\Models\DiscussionParticipant whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDiscussionParticipant {}
}

namespace Nova\Forms\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $key
 * @property \Nova\Forms\Enums\FormType $type
 * @property string|null $description
 * @property bool $is_locked
 * @property \Nova\Forms\Data\FormOptions|null $options
 * @property array<array-key, mixed>|null $fields
 * @property array<array-key, mixed>|null $published_fields
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormField> $formFields
 * @property-read int|null $form_fields_count
 * @property-read bool $has_published_fields
 * @property-read string|null $rendered_block_content
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @property-read array $validation_messages
 * @property-read array $validation_rules
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form active()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form basic()
 * @method static \Database\Factories\FormFactory factory($count = null, $state = [])
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form inactive()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form key(string $key)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form newModelQuery()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form newQuery()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form query()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form searchFor($search)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form submissible()
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereCreatedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereDescription($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereFields($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereId($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereIsLocked($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereKey($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereName($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereOptions($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form wherePrefixedId($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form wherePublishedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form wherePublishedFields($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereStatus($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereType($value)
 * @method static \Nova\Forms\Models\Builders\FormBuilder<static>|\Nova\Forms\Models\Form whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperForm {}
}

namespace Nova\Forms\Models{
/**
 * @property int $id
 * @property int $form_id
 * @property string $name
 * @property string $uid
 * @property string $label
 * @property string $type
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\Form $form
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmissionResponse> $responses
 * @property-read int|null $responses_count
 * @method static \Database\Factories\FormFieldFactory factory($count = null, $state = [])
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField form(\Nova\Forms\Models\Form|int $form)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField newModelQuery()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField newQuery()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField ordered(string $direction = 'asc')
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField query()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField uid(string $uid)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereCreatedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereFormId($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereId($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereLabel($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereName($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereOrderColumn($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereType($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereUid($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFormField {}
}

namespace Nova\Forms\Models{
/**
 * @property int $id
 * @property int $form_id
 * @property string|null $owner_type
 * @property int|null $owner_id
 * @property array<array-key, mixed>|null $meta
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\Form $form
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmissionResponse> $responses
 * @property-read int|null $responses_count
 * @property-read string|null $title_field
 * @method static \Database\Factories\FormSubmissionFactory factory($count = null, $state = [])
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission forForm(\Nova\Forms\Models\Form|int $form)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission newModelQuery()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission newQuery()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission onlySubmissionsForCurrentUser()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission ownerIsUser(\Nova\Users\Models\User $user)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission query()
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereCreatedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereFormId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereMeta($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereOwnerId($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereOwnerType($value)
 * @method static \Nova\Forms\Models\Builders\FormSubmissionBuilder<static>|\Nova\Forms\Models\FormSubmission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFormSubmission {}
}

namespace Nova\Forms\Models{
/**
 * @property int $id
 * @property int $submission_id
 * @property string $field_type
 * @property string $field_uid
 * @property mixed|null $value
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Forms\Models\FormField|null $field
 * @property-read \Nova\Forms\Models\FormSubmission $submission
 * @method static \Database\Factories\FormSubmissionResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereFieldUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Forms\Models\FormSubmissionResponse whereValue($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFormSubmissionResponse {}
}

namespace Nova\Menus\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Menus\Models\MenuItem> $items
 * @property-read int|null $items_count
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu active()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu inactive()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu newModelQuery()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu newQuery()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu public()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu query()
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereCreatedAt($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereId($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereKey($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereName($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereStatus($value)
 * @method static \Nova\Menus\Models\Builders\MenuBuilder<static>|\Nova\Menus\Models\Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMenu {}
}

namespace Nova\Menus\Models{
/**
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string $label
 * @property \Anodyne\TablerIcons\Tabler|null $icon
 * @property \Nova\Menus\Enums\LinkType $link_type
 * @property int|null $page_id
 * @property string|null $url
 * @property \Nova\Menus\Enums\LinkTarget $target
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Menus\Models\MenuItem> $items
 * @property-read int|null $items_count
 * @property-read mixed $link
 * @property-read \Nova\Menus\Models\Menu $menu
 * @property-read \Nova\Pages\Models\Page|null $page
 * @property-read \Nova\Menus\Models\MenuItem|null $parent
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem active()
 * @method static \Database\Factories\MenuItemFactory factory($count = null, $state = [])
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem inactive()
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem newModelQuery()
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem newQuery()
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem ordered(string $direction = 'asc')
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem public()
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem query()
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem searchFor($search)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereCreatedAt($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereIcon($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereId($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereLabel($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereLinkType($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereMenuId($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereOrderColumn($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem wherePageId($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereParentId($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereStatus($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereTarget($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereUpdatedAt($value)
 * @method static \Nova\Menus\Models\Builders\MenuItemBuilder<static>|\Nova\Menus\Models\MenuItem whereUrl($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMenuItem {}
}

namespace Nova\Notes\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $user_id
 * @property string $title
 * @property string|null $content
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Users\Models\User|null $author
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note author(\Nova\Users\Models\User $user)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note currentUser()
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note newModelQuery()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note newQuery()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note query()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note searchFor($search)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereContent($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereCreatedAt($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereId($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note wherePrefixedId($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereTitle($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereUpdatedAt($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNote {}
}

namespace Nova\Onboarding\Models{
/**
 * @property int $id
 * @property \Nova\Onboarding\Enums\OnboardingProcess $process
 * @property int $user_id
 * @property string|null $completed_at
 * @property array<array-key, mixed>|null $steps
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding incomplete()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding newModelQuery()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding newQuery()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding process(\Nova\Onboarding\Enums\OnboardingProcess $process)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding query()
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding user(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereCompletedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereCreatedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereId($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereProcess($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereSteps($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereUpdatedAt($value)
 * @method static \Nova\Onboarding\Models\Builders\OnboardingBuilder<static>|\Nova\Onboarding\Models\Onboarding whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOnboarding {}
}

namespace Nova\Pages\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $uri
 * @property string|null $key
 * @property \Nova\Pages\Enums\PageVerb $verb
 * @property string|null $resource
 * @property string $layout
 * @property array<array-key, mixed>|null $middleware
 * @property array<array-key, mixed>|null $blocks
 * @property array<array-key, mixed>|null $published_blocks
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property bool $content_can_be_edited
 * @property string|null $heading
 * @property string|null $subheading
 * @property string|null $intro
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $is_advanced
 * @property-read bool $is_basic
 * @property-read bool $is_previewable
 * @property-read bool $is_published
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Menus\Models\MenuItem> $menuItems
 * @property-read int|null $menu_items_count
 * @property-read string|null $rendered_block_content
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page active()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page advanced()
 * @method static \Nova\Pages\Models\Collections\PagesCollection<int, static> all($columns = ['*'])
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page basic()
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static \Nova\Pages\Models\Collections\PagesCollection<int, static> get($columns = ['*'])
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page inactive()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page key(string $key)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page newModelQuery()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page newQuery()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page public()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page query()
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page searchFor(string $search)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page verb(\Nova\Pages\Enums\PageVerb $verb)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereBlocks($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereContentCanBeEdited($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereCreatedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereHeading($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereId($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereIntro($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereKey($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereLayout($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereMiddleware($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereName($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePrefixedId($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePublishedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page wherePublishedBlocks($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereResource($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoDescription($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoKeywords($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSeoTitle($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereStatus($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereSubheading($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereUri($value)
 * @method static \Nova\Pages\Models\Builders\PageBuilder<static>|\Nova\Pages\Models\Page whereVerb($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPage {}
}

namespace Nova\Ranks\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Ranks\Models\RankItem> $ranks
 * @property-read int|null $ranks_count
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup active()
 * @method static \Database\Factories\RankGroupFactory factory($count = null, $state = [])
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup inactive()
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup newModelQuery()
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup newQuery()
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup ordered(string $direction = 'asc')
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup query()
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup searchFor($search)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereCreatedAt($value)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereId($value)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereName($value)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereOrderColumn($value)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereStatus($value)
 * @method static \Nova\Ranks\Models\Builders\RankGroupBuilder<static>|\Nova\Ranks\Models\RankGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRankGroup {}
}

namespace Nova\Ranks\Models{
/**
 * @property int $id
 * @property int $group_id
 * @property int $name_id
 * @property string $base_image
 * @property string|null $overlay_image
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Nova\Ranks\Models\RankGroup $group
 * @property-read \Nova\Ranks\Models\RankName $name
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem active()
 * @method static \Database\Factories\RankItemFactory factory($count = null, $state = [])
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem group($group)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem inactive()
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem name($name)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem newModelQuery()
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem newQuery()
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem ordered(string $direction = 'asc')
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem query()
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem searchFor($search)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereBaseImage($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereCreatedAt($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereGroupId($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereId($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereNameId($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereOrderColumn($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereOverlayImage($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereStatus($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem whereUpdatedAt($value)
 * @method static \Nova\Ranks\Models\Builders\RankItemBuilder<static>|\Nova\Ranks\Models\RankItem withRankName()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRankItem {}
}

namespace Nova\Ranks\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Ranks\Models\RankItem> $ranks
 * @property-read int|null $ranks_count
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName active()
 * @method static \Database\Factories\RankNameFactory factory($count = null, $state = [])
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName inactive()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName newModelQuery()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName newQuery()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName ordered(string $direction = 'asc')
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName query()
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName searchFor($search)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereCreatedAt($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereId($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereName($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereOrderColumn($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereStatus($value)
 * @method static \Nova\Ranks\Models\Builders\RankNameBuilder<static>|\Nova\Ranks\Models\RankName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRankName {}
}

namespace Nova\Roles\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission newModelQuery()
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission newQuery()
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission query()
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission searchFor($search)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereCreatedAt($value)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereDescription($value)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereDisplayName($value)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereId($value)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereName($value)
 * @method static \Nova\Roles\Models\Builders\PermissionBuilder<static>|\Nova\Roles\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPermission {}
}

namespace Nova\Roles\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property bool $is_default
 * @property bool $is_locked
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role atOrAboveOrderColumn($maxSortValue)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role atOrBelowOrderColumn($maxSortValue)
 * @method static \Database\Factories\RoleFactory factory($count = null, $state = [])
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role isDefault()
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role newModelQuery()
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role newQuery()
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role ordered(string $direction = 'asc')
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role query()
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role searchFor($search)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereCreatedAt($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereDescription($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereDisplayName($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereId($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereIsDefault($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereIsLocked($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereName($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereOrderColumn($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role wherePrefixedId($value)
 * @method static \Nova\Roles\Models\Builders\RoleBuilder<static>|\Nova\Roles\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRole {}
}

namespace Nova\Roles\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Roles\Models\Team whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTeam {}
}

namespace Nova\Settings\Models{
/**
 * @property int $id
 * @property string $key
 * @property \Nova\Settings\Data\General|null $general
 * @property \Nova\Settings\Data\Email|null $email
 * @property \Nova\Settings\Data\Appearance|null $appearance
 * @property \Nova\Settings\Data\Characters|null $characters
 * @property \Nova\Settings\Data\Discord|null $discord
 * @property \Nova\Settings\Data\PostingActivity|null $posting_activity
 * @property \Nova\Settings\Data\ContentRatings|null $ratings
 * @property \Nova\Settings\Data\Applications|null $applications
 * @property \Nova\Settings\Data\Dashboard|null $dashboard
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings custom()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings default()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings newModelQuery()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings newQuery()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings query()
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereAppearance($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereApplications($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereCharacters($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereCreatedAt($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereDashboard($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereDiscord($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereEmail($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereGeneral($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereId($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereKey($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings wherePostingActivity($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereRatings($value)
 * @method static \Nova\Settings\Models\Builders\SettingsBuilder<static>|\Nova\Settings\Models\Settings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSettings {}
}

namespace Nova\Stories\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $story_id
 * @property int|null $post_type_id
 * @property int|null $order_column
 * @property \Nova\Stories\Models\States\PostStatus\PostStatus $status
 * @property string|null $title
 * @property string|null $content
 * @property string|null $day
 * @property string|null $time
 * @property string|null $location
 * @property int $word_count
 * @property \Nova\Stories\Enums\ContentRatingValue|null $rating_language
 * @property \Nova\Stories\Enums\ContentRatingValue|null $rating_sex
 * @property \Nova\Stories\Enums\ContentRatingValue|null $rating_violence
 * @property string|null $summary
 * @property array<array-key, mixed>|null $participants
 * @property int|null $neighbor
 * @property string|null $direction
 * @property \Carbon\CarbonImmutable|null $published_at
 * @property \Carbon\CarbonImmutable|null $locked_at
 * @property int|null $locked_by
 * @property int|null $last_update_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read array $authors_avatars
 * @property-read string $authors_string
 * @property-read \Nova\Stories\Models\PostAuthor|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Characters\Models\Character> $characterAuthors
 * @property-read int|null $character_authors_count
 * @property-read bool $has_location_and_time
 * @property-read bool $is_draft
 * @property-read bool $is_pending
 * @property-read bool $is_published
 * @property-read bool $is_setup
 * @property-read bool $is_started
 * @property-read string $location_day_time
 * @property-read \Nova\Users\Models\User|null $lockOwner
 * @property-read bool $needs_attention
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $participatingUsers
 * @property-read int|null $participating_users_count
 * @property-read \Nova\Stories\Models\PostType|null $postType
 * @property-read string $reading_time
 * @property-read bool $show_content_warning_for_admin_site
 * @property-read bool $show_content_warning_for_public_site
 * @property-read \Nova\Stories\Models\Story|null $story
 * @property-read string $timeline
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Users\Models\User> $userAuthors
 * @property-read int|null $user_authors_count
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post abandoned()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post currentMonth()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post currentYear()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post draft()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post forStory(\Nova\Stories\Models\Story|int $story)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post hasExpiredPostLock()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post locked()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post newModelQuery()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\Post onlyTrashed()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post orWhereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post orWhereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post ordered(string $direction = 'asc')
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post pending()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post previousMonth()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post previousYear()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post published()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post query()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post searchFor($search)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post unlocked()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereContent($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereCreatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereDay($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereDeletedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereDirection($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereHasUser(\Nova\Users\Models\User $user)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereId($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereLastUpdateBy($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereLocation($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereLockedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereLockedBy($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereNeighbor($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereNotPost(\Nova\Stories\Models\Post $post)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereNotRootPost()
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereOrderColumn($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereParticipants($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post wherePostType($postTypeId)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post wherePostTypeId($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post wherePrefixedId($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post wherePublishedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereRatingLanguage($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereRatingSex($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereRatingViolence($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereStatus($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereStoryId($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereSummary($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereTime($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereTitle($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereUpdatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostBuilder<static>|\Nova\Stories\Models\Post whereWordCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\Post withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\Post withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPost {}
}

namespace Nova\Stories\Models{
/**
 * @property int $id
 * @property int $post_id
 * @property string $authorable_type
 * @property int $authorable_id
 * @property int|null $user_id
 * @property string|null $as
 * @property int $word_count
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $authorable
 * @property-read \Nova\Characters\Models\Character|null $character
 * @property-read \Nova\Stories\Models\Post|null $post
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor draft()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor includedInPostTracking()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor newModelQuery()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor newQuery()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor published()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor query()
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor timeframe(?\Carbon\CarbonInterface $start = null, ?\Carbon\CarbonInterface $end = null)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor updatedBetween(?\Carbon\CarbonInterface $start = null, ?\Carbon\CarbonInterface $end = null)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAs($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAuthorableId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereAuthorableType($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereCreatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor wherePost(\Nova\Stories\Models\Post|int|null $post)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor wherePostId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUpdatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUser(\Nova\Users\Models\User|int $user)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereUserId($value)
 * @method static \Nova\Stories\Models\Builders\PostAuthorBuilder<static>|\Nova\Stories\Models\PostAuthor whereWordCount($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPostAuthor {}
}

namespace Nova\Stories\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $key
 * @property string $name
 * @property string|null $description
 * @property string|null $color
 * @property \Anodyne\TablerIcons\Tabler|null $icon
 * @property int|null $role_id
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Nova\Stories\Enums\PostTypeVisibility $visibility
 * @property \Nova\Stories\Data\Fields|null $fields
 * @property \Nova\Stories\Data\Options|null $options
 * @property int|null $order_column
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $included_in_post_tracking
 * @property-read bool $notifies_users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $publishedPosts
 * @property-read int|null $published_posts_count
 * @property-read \Nova\Roles\Models\Role|null $role
 * @property-read string $title
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType active()
 * @method static \Database\Factories\PostTypeFactory factory($count = null, $state = [])
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType inCharacter()
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType inactive()
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType newModelQuery()
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\PostType onlyTrashed()
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType orWhereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType orWhereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType ordered(string $direction = 'asc')
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType query()
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType searchFor($search)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType userHasAccess(\Illuminate\Contracts\Auth\Authenticatable $user)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereColor($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereCreatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereDeletedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereDescription($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereFields($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereIcon($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereId($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereKey($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereName($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereNotState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereOptions($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereOrderColumn($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType wherePrefixedId($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereRoleId($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereState(string $column, $states)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereStatus($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereUpdatedAt($value)
 * @method static \Nova\Stories\Models\Builders\PostTypeBuilder<static>|\Nova\Stories\Models\PostType whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\PostType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Stories\Models\PostType withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPostType {}
}

namespace Nova\Stories\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int|null $parent_id
 * @property int|null $order_column
 * @property \Nova\Stories\Models\States\StoryStatus\StoryStatus $status
 * @property string $title
 * @property string|null $description
 * @property string|null $summary
 * @property mixed|null $started_at
 * @property mixed|null $ended_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $allPosts
 * @property-read int|null $all_posts_count
 * @property-read bool $can_post
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $children
 * @property-read int|null $children_count
 * @property-read bool $has_summary
 * @property-read bool $is_completed
 * @property-read bool $is_current
 * @property-read bool $is_ongoing
 * @property-read bool $is_upcoming
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Nova\Stories\Models\Story|null $parent
 * @property-read \Nova\Stories\Models\Story|null $parentStory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $recursiveStories
 * @property-read int|null $recursive_stories_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $stories
 * @property-read int|null $stories_count
 * @property-read int $depth
 * @property-read string $path
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \Nova\Stories\Models\Story|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Nova\Stories\Models\Story> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story doesntHaveChildren()
 * @method static \Database\Factories\StoryFactory factory($count = null, $state = [])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story orWhereNotState(string $column, $states)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story orWhereState(string $column, $states)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story ordered(string $direction = 'asc')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereDescription($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereEndedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereNotState(string $column, $states)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereOrderColumn($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story wherePrefixedId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereStartedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereState(string $column, $states)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereStatus($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereSummary($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|\Nova\Stories\Models\Story withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperStory {}
}

namespace Nova\Themes\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Nova\Themes\Data\ThemeSettings $settings
 * @property \Nova\Addons\Data\AddonRepository|null $repository
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_update
 * @property-read bool $is_current_public_theme
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Themes\Models\PendingTheme whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPendingTheme {}
}

namespace Nova\Themes\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $version
 * @property string|null $credits
 * @property string|null $preview
 * @property \Nova\Foundation\Enums\BasicStatus $status
 * @property \Nova\Themes\Data\ThemeSettings $settings
 * @property \Nova\Addons\Data\AddonRepository|null $repository
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read bool $has_update
 * @property-read bool $is_current_public_theme
 * @property-read string|null $latest_version
 * @property-read string|null $update_url
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme active()
 * @method static \Database\Factories\ThemeFactory factory($count = null, $state = [])
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme inactive()
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme location($location)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme newModelQuery()
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme newQuery()
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme query()
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereCreatedAt($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereCredits($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereId($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereLocation($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereName($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme wherePreview($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereRepository($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereSettings($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereStatus($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereUpdatedAt($value)
 * @method static \Nova\Themes\Models\Builders\ThemeBuilder<static>|\Nova\Themes\Models\Theme whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTheme {}
}

namespace Nova\Users\Models{
/**
 * @property int $id
 * @property string|null $bannable_type
 * @property int|null $bannable_id
 * @property string|null $created_by_type
 * @property int|null $created_by_id
 * @property string|null $comment
 * @property string|null $ip
 * @property \Carbon\Carbon|string|null|null $expired_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property array<array-key, mixed>|null $metas
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $bannable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban expired()
 * @method static \Database\Factories\BanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban notExpired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban notPermanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban permanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereBannableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereBannableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedByType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereMeta(string $name, $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBan {}
}

namespace Nova\Users\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLogin {}
}

namespace Nova\Users\Models{
/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property \Nova\Users\Models\States\Status\UserStatus $status
 * @property \Nova\Users\Data\PronounsData $pronouns
 * @property string|null $remember_token
 * @property bool $force_password_reset
 * @property string|null $email_verified_at
 * @property \Nova\Users\Data\UserPreferences|null $preferences
 * @property \Nova\Users\Data\UserModerations|null $moderations
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
 * @property-read \Nova\Applications\Models\Application|null $application
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Discussions\Models\Discussion> $discussions
 * @property-read int|null $discussions_count
 * @property-read string $display_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $draftPosts
 * @property-read int|null $draft_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Stories\Models\Post> $draftPostsNeedingAttention
 * @property-read int|null $draft_posts_needing_attention_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Forms\Models\FormSubmission> $formSubmissions
 * @property-read int|null $form_submissions_count
 * @property-read \Nova\Applications\Models\ApplicationReviewer|null $globalApplicationReviewer
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Foundation\Models\StatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read int $unread_announcements_count
 * @property-read int $unread_messages_count
 * @property-read \Nova\Forms\Models\FormSubmission|null $userFormSubmission
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
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace Nova\Users\Models{
/**
 * @property int $id
 * @property int $notification_type_id
 * @property int $user_id
 * @property int $database
 * @property int $mail
 * @property int $discord
 * @property string|null $discord_settings
 * @property-read \Nova\Foundation\Models\NotificationType $notificationType
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDiscord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereDiscordSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereNotificationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\UserNotificationPreference whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUserNotificationPreference {}
}

