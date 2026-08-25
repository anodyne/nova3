<?php

declare(strict_types=1);

use Carbon\CarbonInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Nova\Pages\Models\Page;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $now = now();

            $adminRows = $this->prepareRows(
                rows: $this->adminPages(),
                now: $now,
                setPublished: false
            );

            $publicRows = $this->prepareRows(
                rows: $this->publicPages(),
                now: $now,
                setPublished: true
            );

            $rows = $this->conformRows(array_merge($adminRows, $publicRows), $this->pageTemplate($now));

            DB::table('pages')->upsert(
                $rows,
                ['key'],
                [
                    'name', 'uri', 'resource', 'layout', 'heading', 'subheading', 'seo_title',
                    'middleware', 'content_can_be_edited', 'verb', 'blocks', 'published_at', 'updated_at',
                ]
            );
        });
    }

    public function down(): void
    {
        DB::table('pages')->truncate();
    }

    /** @param array<string, mixed> $data */
    protected function createPage(array $data): void
    {
        $additionalData = [];

        if (in_array(data_get($data, 'verb'), ['delete', 'post', 'put'])) {
            $additionalData['content_can_be_edited'] = false;
        }

        Page::create(array_merge($additionalData, $data));
    }

    /** @return list<array<string, mixed>> */
    protected function adminPages(): array
    {
        return [
            ['name' => 'Dashboard', 'uri' => 'admin/dashboard', 'key' => 'admin.dashboard', 'resource' => 'Nova\\Dashboards\\Controllers\\DashboardController', 'layout' => 'admin'],
            ['name' => 'System overview dashboard', 'uri' => 'admin/system-overview', 'key' => 'admin.system-overview', 'resource' => 'Nova\\Dashboards\\Controllers\\SystemOverviewController', 'layout' => 'admin', 'heading' => 'System overview'],
            ['name' => 'Writing dashboard', 'uri' => 'admin/writing-overview', 'key' => 'admin.writing-overview', 'resource' => 'Nova\\Stories\\Controllers\\WritingOverviewController', 'layout' => 'admin', 'heading' => 'My writing dashboard'],
            ['name' => 'Error logs', 'uri' => 'admin/error-logs', 'key' => 'admin.error-logs.index', 'resource' => 'Nova\\Dashboards\\Controllers\\ErrorLogController', 'layout' => 'admin', 'heading' => 'Error logs'],
            ['name' => 'Pending approval dashboard', 'uri' => 'admin/pending-approval', 'key' => 'admin.pending-approval', 'resource' => 'Nova\\Dashboards\\Controllers\\PendingApprovalController', 'layout' => 'admin', 'heading' => 'Pending approval'],
            ['name' => 'Onboarding overview', 'uri' => 'admin/onboarding', 'key' => 'admin.onboarding', 'resource' => 'Nova\\Onboarding\\Controllers\\OnboardingController', 'layout' => 'admin', 'heading' => 'Onboarding'],

            ['name' => 'List themes', 'uri' => 'admin/themes', 'key' => 'admin.themes.index', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@index', 'layout' => 'admin', 'heading' => 'Themes', 'subheading' => 'Personalize your public-facing site with a custom theme'],
            ['name' => 'View theme', 'uri' => 'admin/themes/{theme}/show', 'key' => 'admin.themes.show', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@show', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create theme', 'uri' => 'admin/themes/create', 'key' => 'admin.themes.create', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@create', 'layout' => 'admin', 'heading' => 'Add a new theme'],
            ['name' => 'Store theme', 'uri' => 'admin/themes', 'key' => 'admin.themes.store', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['name' => 'Edit theme', 'uri' => 'admin/themes/{theme}/edit', 'key' => 'admin.themes.edit', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@edit', 'layout' => 'admin', 'heading' => 'Edit theme'],
            ['name' => 'Update theme', 'uri' => 'admin/themes/{theme}', 'key' => 'admin.themes.update', 'verb' => 'put', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@update', 'layout' => 'admin'],

            ['name' => 'List roles', 'uri' => 'admin/roles', 'key' => 'admin.roles.index', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@index', 'layout' => 'admin', 'heading' => 'Roles', 'subheading' => 'Control what users can do throughout Nova'],
            ['name' => 'View role', 'uri' => 'admin/roles/{role}/show', 'key' => 'admin.roles.show', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@show', 'layout' => 'admin', 'heading' => 'View role'],
            ['name' => 'Create role', 'uri' => 'admin/roles/create', 'key' => 'admin.roles.create', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@create', 'layout' => 'admin', 'heading' => 'Add a new role'],
            ['name' => 'Store role', 'uri' => 'admin/roles', 'key' => 'admin.roles.store', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['name' => 'Edit role', 'uri' => 'admin/roles/{role}/edit', 'key' => 'admin.roles.edit', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@edit', 'layout' => 'admin', 'heading' => 'Edit role'],
            ['name' => 'Update role', 'uri' => 'admin/roles/{role}', 'key' => 'admin.roles.update', 'verb' => 'put', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@update', 'layout' => 'admin'],

            ['name' => 'List permissions', 'uri' => 'admin/permissions', 'key' => 'admin.permissions.index', 'resource' => 'Nova\\Roles\\Controllers\\PermissionController@index', 'layout' => 'admin', 'heading' => 'Permissions', 'subheading' => 'View all of the available permissions in Nova'],

            ['name' => 'List users', 'uri' => 'admin/users', 'key' => 'admin.users.index', 'resource' => 'Nova\\Users\\Controllers\\UserController@index', 'layout' => 'admin', 'heading' => 'Users', 'subheading' => 'Manage all of the game’s users'],
            ['name' => 'View user', 'uri' => 'admin/users/{user}/show', 'key' => 'admin.users.show', 'resource' => 'Nova\\Users\\Controllers\\UserController@show', 'layout' => 'admin', 'heading' => 'View user'],
            ['name' => 'Create user', 'uri' => 'admin/users/create', 'key' => 'admin.users.create', 'resource' => 'Nova\\Users\\Controllers\\UserController@create', 'layout' => 'admin', 'heading' => 'Add a new user'],
            ['name' => 'Store user', 'uri' => 'admin/users', 'key' => 'admin.users.store', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\UserController@store', 'layout' => 'admin'],
            ['name' => 'Edit user', 'uri' => 'admin/users/{user}/edit', 'key' => 'admin.users.edit', 'resource' => 'Nova\\Users\\Controllers\\UserController@edit', 'layout' => 'admin', 'heading' => 'Edit user'],
            ['name' => 'Update user', 'uri' => 'admin/users/{user}', 'key' => 'admin.users.update', 'verb' => 'put', 'resource' => 'Nova\\Users\\Controllers\\UserController@update', 'layout' => 'admin'],
            ['name' => 'User moderation list', 'uri' => 'admin/user-moderation', 'key' => 'admin.user-moderation', 'resource' => 'Nova\\Users\\Controllers\\UserModerationController', 'layout' => 'admin', 'heading' => 'User moderation', 'subheading' => 'Manage all of the game’s user moderations'],

            ['name' => 'My account', 'uri' => 'admin/account', 'key' => 'admin.account.edit', 'resource' => 'Nova\\Users\\Controllers\\EditAccountController', 'layout' => 'admin', 'heading' => 'Account settings'],
            ['name' => 'Notification preferences', 'uri' => 'admin/account/notifications', 'key' => 'admin.account.notifications', 'resource' => 'Nova\\Users\\Controllers\\NotificationPreferencesController', 'layout' => 'admin', 'heading' => 'My notification preferences'],
            ['name' => 'Delete my account', 'uri' => 'admin/account/delete', 'key' => 'admin.account.delete', 'resource' => 'Nova\\Users\\Controllers\\DeleteAccountController', 'layout' => 'admin', 'heading' => 'Delete my account'],

            ['name' => 'List all my notes', 'uri' => 'admin/notes', 'key' => 'admin.notes.index', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@index', 'layout' => 'admin', 'heading' => 'My notes'],
            ['name' => 'View my note', 'uri' => 'admin/notes/{note}/show', 'key' => 'admin.notes.show', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@show', 'layout' => 'admin', 'heading' => 'View note'],
            ['name' => 'Create note', 'uri' => 'admin/notes/create', 'key' => 'admin.notes.create', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@create', 'layout' => 'admin', 'heading' => 'Add a new note'],
            ['name' => 'Store note', 'uri' => 'admin/notes', 'key' => 'admin.notes.store', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@store', 'layout' => 'admin'],
            ['name' => 'Edit note', 'uri' => 'admin/notes/{note}/edit', 'key' => 'admin.notes.edit', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@edit', 'layout' => 'admin', 'heading' => 'Edit note'],
            ['name' => 'Update note', 'uri' => 'admin/notes/{note}', 'key' => 'admin.notes.update', 'verb' => 'put', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@update', 'layout' => 'admin'],

            ['name' => 'Appearance settings', 'uri' => 'admin/settings/appearance', 'key' => 'admin.settings.appearance.edit', 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@edit', 'layout' => 'admin', 'heading' => 'Appearance settings'],
            ['name' => 'Update appearance settings', 'uri' => 'admin/settings/appearance', 'key' => 'admin.settings.appearance.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Character settings', 'uri' => 'admin/settings/characters', 'key' => 'admin.settings.characters.edit', 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@edit', 'layout' => 'admin', 'heading' => 'Character settings'],
            ['name' => 'Update character settings', 'uri' => 'admin/settings/characters', 'key' => 'admin.settings.characters.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Content ratings settings', 'uri' => 'admin/settings/content-ratings', 'key' => 'admin.settings.content-ratings.edit', 'resource' => 'Nova\\Settings\\Controllers\\ContentRatingSettingsController@edit', 'layout' => 'admin', 'heading' => 'Content ratings settings'],
            ['name' => 'Email settings', 'uri' => 'admin/settings/email', 'key' => 'admin.settings.email.edit', 'resource' => 'Nova\\Settings\\Controllers\\EmailSettingsController@edit', 'layout' => 'admin', 'heading' => 'Email settings'],
            ['name' => 'General settings', 'uri' => 'admin/settings/general', 'key' => 'admin.settings.general.edit', 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@edit', 'layout' => 'admin', 'heading' => 'General settings'],
            ['name' => 'Update general settings', 'uri' => 'admin/settings/general', 'key' => 'admin.settings.general.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Posting activity settings', 'uri' => 'admin/settings/posting-activity', 'key' => 'admin.settings.posting-activity.edit', 'resource' => 'Nova\\Settings\\Controllers\\PostingActivitySettingsController@edit', 'layout' => 'admin', 'heading' => 'Posting activity settings'],
            ['name' => 'Notification settings', 'uri' => 'admin/settings/notifications', 'key' => 'admin.settings.notifications.edit', 'resource' => 'Nova\\Settings\\Controllers\\NotificationSettingsController@edit', 'layout' => 'admin', 'heading' => 'Notification settings'],
            ['name' => 'Application settings', 'uri' => 'admin/settings/applications', 'key' => 'admin.settings.applications.edit', 'resource' => 'Nova\\Settings\\Controllers\\ApplicationSettingsController@edit', 'layout' => 'admin', 'heading' => 'Applications settings'],
            ['name' => 'Update application settings', 'uri' => 'admin/settings/applications', 'key' => 'admin.settings.applications.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\ApplicationSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Dashboard settings', 'uri' => 'admin/settings/dashboard', 'key' => 'admin.settings.dashboard.edit', 'resource' => 'Nova\\Settings\\Controllers\\DashboardSettingsController@edit', 'layout' => 'admin', 'heading' => 'Dashboard settings'],
            ['name' => 'Update dashboard settings', 'uri' => 'admin/settings/dashboard', 'key' => 'admin.settings.dashboard.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\DashboardSettingsController@update', 'layout' => 'admin'],

            ['name' => 'List rank groups', 'uri' => 'admin/ranks/groups', 'key' => 'admin.ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@index', 'layout' => 'admin', 'heading' => 'Rank groups', 'subheading' => 'Collections of related rank items for simpler searching and selecting'],
            ['name' => 'View rank group', 'uri' => 'admin/ranks/groups/{group}/show', 'key' => 'admin.ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@show', 'layout' => 'admin', 'heading' => 'View rank group'],
            ['name' => 'Create rank group', 'uri' => 'admin/ranks/groups/create', 'key' => 'admin.ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@create', 'layout' => 'admin', 'heading' => 'Add a new rank group'],
            ['name' => 'Store rank group', 'uri' => 'admin/ranks/groups', 'key' => 'admin.ranks.groups.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank group', 'uri' => 'admin/ranks/groups/{group}/edit', 'key' => 'admin.ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@edit', 'layout' => 'admin', 'heading' => 'Edit rank group'],
            ['name' => 'Update rank group', 'uri' => 'admin/ranks/groups/{group}', 'key' => 'admin.ranks.groups.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@update', 'layout' => 'admin'],

            ['name' => 'List rank names', 'uri' => 'admin/ranks/names', 'key' => 'admin.ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@index', 'layout' => 'admin', 'heading' => 'Rank names', 'subheading' => 'Re-use basic rank information across all of your rank items'],
            ['name' => 'View rank name', 'uri' => 'admin/ranks/names/{name}/show', 'key' => 'admin.ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@show', 'layout' => 'admin', 'heading' => 'View rank name'],
            ['name' => 'Create rank name', 'uri' => 'admin/ranks/names/create', 'key' => 'admin.ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@create', 'layout' => 'admin', 'heading' => 'Add a new rank name'],
            ['name' => 'Store rank nane', 'uri' => 'admin/ranks/names', 'key' => 'admin.ranks.names.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank name', 'uri' => 'admin/ranks/names/{name}/edit', 'key' => 'admin.ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@edit', 'layout' => 'admin', 'heading' => 'Edit rank name'],
            ['name' => 'Update rank name', 'uri' => 'admin/ranks/names/{name}', 'key' => 'admin.ranks.names.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@update', 'layout' => 'admin'],

            ['name' => 'List rank items', 'uri' => 'admin/ranks/items', 'key' => 'admin.ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@index', 'layout' => 'admin', 'heading' => 'Rank items', 'subheading' => 'Combine a rank group, name, and images to define your game’s ranks'],
            ['name' => 'View rank item', 'uri' => 'admin/ranks/items/{item}/show', 'key' => 'admin.ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@show', 'layout' => 'admin', 'heading' => 'View rank item'],
            ['name' => 'Create rank item', 'uri' => 'admin/ranks/items/create', 'key' => 'admin.ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@create', 'layout' => 'admin', 'heading' => 'Add a new rank item'],
            ['name' => 'Store rank item', 'uri' => 'admin/ranks/items', 'key' => 'admin.ranks.items.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank item', 'uri' => 'admin/ranks/items/{item}/edit', 'key' => 'admin.ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@edit', 'layout' => 'admin', 'heading' => 'Edit rank item'],
            ['name' => 'Update rank item', 'uri' => 'admin/ranks/items/{item}', 'key' => 'admin.ranks.items.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@update', 'layout' => 'admin'],

            ['name' => 'List departments', 'uri' => 'admin/departments', 'key' => 'admin.departments.index', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@index', 'layout' => 'admin', 'heading' => 'Departments', 'subheading' => 'Organize character positions into logical groups that you can display on your manifests'],
            ['name' => 'View department', 'uri' => 'admin/departments/{department}/show', 'key' => 'admin.departments.show', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@show', 'layout' => 'admin', 'heading' => 'View department'],
            ['name' => 'Create department', 'uri' => 'admin/departments/create', 'key' => 'admin.departments.create', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@create', 'layout' => 'admin', 'heading' => 'Add a new department'],
            ['name' => 'Store department', 'uri' => 'admin/departments', 'key' => 'admin.departments.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@store', 'layout' => 'admin'],
            ['name' => 'Edit department', 'uri' => 'admin/departments/{department}/edit', 'key' => 'admin.departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@edit', 'layout' => 'admin', 'heading' => 'Edit department'],
            ['name' => 'Update department', 'uri' => 'admin/departments/{department}', 'key' => 'admin.departments.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@update', 'layout' => 'admin'],

            ['name' => 'List positions', 'uri' => 'admin/positions', 'key' => 'admin.positions.index', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@index', 'layout' => 'admin', 'heading' => 'Positions', 'subheading' => 'The jobs or stations characters are assigned to for display on your manifests'],
            ['name' => 'View position', 'uri' => 'admin/positions/{position}/show', 'key' => 'admin.positions.show', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@show', 'layout' => 'admin', 'heading' => 'View position'],
            ['name' => 'Create position', 'uri' => 'admin/positions/create', 'key' => 'admin.positions.create', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@create', 'layout' => 'admin', 'heading' => 'Add a new position'],
            ['name' => 'Store position', 'uri' => 'admin/positions', 'key' => 'admin.positions.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@store', 'layout' => 'admin'],
            ['name' => 'Edit position', 'uri' => 'admin/positions/{position}/edit', 'key' => 'admin.positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@edit', 'layout' => 'admin', 'heading' => 'Edit position'],
            ['name' => 'Update position', 'uri' => 'admin/positions/{position}', 'key' => 'admin.positions.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@update', 'layout' => 'admin'],

            ['name' => 'List characters', 'uri' => 'admin/characters', 'key' => 'admin.characters.index', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@index', 'layout' => 'admin', 'heading' => 'Characters', 'subheading' => 'Manage all of the game’s characters'],
            ['name' => 'View character', 'uri' => 'admin/characters/{character}/show', 'key' => 'admin.characters.show', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@show', 'layout' => 'admin', 'heading' => 'View character'],
            ['name' => 'Create character', 'uri' => 'admin/characters/create', 'key' => 'admin.characters.create', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@create', 'layout' => 'admin', 'heading' => 'Add a new character'],
            ['name' => 'Store character', 'uri' => 'admin/characters', 'key' => 'admin.characters.store', 'verb' => 'post', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@store', 'layout' => 'admin'],
            ['name' => 'Edit character', 'uri' => 'admin/characters/{character}/edit', 'key' => 'admin.characters.edit', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@edit', 'layout' => 'admin', 'heading' => 'Edit character'],
            ['name' => 'Update character', 'uri' => 'admin/characters/{character}', 'key' => 'admin.characters.update', 'verb' => 'put', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@update', 'layout' => 'admin'],
            ['name' => 'Migrate character ranks', 'uri' => 'admin/characters/migrate-ranks', 'key' => 'admin.characters.migrate-ranks', 'resource' => 'Nova\\Characters\\Controllers\\MigrateCharacterRanksController', 'layout' => 'admin', 'heading' => 'Migrate character ranks'],

            ['name' => 'List post types', 'uri' => 'admin/post-types', 'key' => 'admin.post-types.index', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@index', 'layout' => 'admin', 'heading' => 'Post types', 'subheading' => 'Control the content users can post into stories'],
            ['name' => 'View post type', 'uri' => 'admin/post-types/{postType}/show', 'key' => 'admin.post-types.show', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@show', 'layout' => 'admin', 'heading' => 'View post type'],
            ['name' => 'Create post type', 'uri' => 'admin/post-types/create', 'key' => 'admin.post-types.create', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@create', 'layout' => 'admin', 'heading' => 'Add a post type'],
            ['name' => 'Store post type', 'uri' => 'admin/post-types', 'key' => 'admin.post-types.store', 'verb' => 'post', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@store', 'layout' => 'admin'],
            ['name' => 'Edit post type', 'uri' => 'admin/post-types/{postType}/edit', 'key' => 'admin.post-types.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@edit', 'layout' => 'admin', 'heading' => 'Edit post type'],
            ['name' => 'Update post type', 'uri' => 'admin/post-types/{postType}', 'key' => 'admin.post-types.update', 'verb' => 'put', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@update', 'layout' => 'admin'],

            ['name' => 'List stories', 'uri' => 'admin/stories', 'key' => 'admin.stories.index', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@index', 'layout' => 'admin', 'heading' => 'Stories', 'subheading' => 'Manage the stories and timeline of your game'],
            ['name' => 'View story', 'uri' => 'admin/stories/{story}/show', 'key' => 'admin.stories.show', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@show', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create story', 'uri' => 'admin/stories/create', 'key' => 'admin.stories.create', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@create', 'layout' => 'admin', 'heading' => 'Add a new story'],
            ['name' => 'Store story', 'uri' => 'admin/stories', 'key' => 'admin.stories.store', 'verb' => 'post', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@store', 'layout' => 'admin'],
            ['name' => 'Edit story', 'uri' => 'admin/stories/{story}/edit', 'key' => 'admin.stories.edit', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@edit', 'layout' => 'admin', 'heading' => 'Edit story'],
            ['name' => 'Update story', 'uri' => 'admin/stories/{story}', 'key' => 'admin.stories.update', 'verb' => 'put', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@update', 'layout' => 'admin'],
            ['name' => 'Delete stories', 'uri' => 'admin/stories/{id}/delete', 'key' => 'admin.stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@delete', 'layout' => 'admin', 'heading' => 'Delete stories', 'subheading' => 'Manage story deletion and how nested stories and story posts should be handled'],
            ['name' => 'Destroy stories', 'uri' => 'admin/stories', 'key' => 'admin.stories.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@destroy', 'layout' => 'admin'],
            ['name' => 'Stories timeline', 'uri' => 'admin/timeline/stories', 'key' => 'admin.stories.stories-timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoriesTimelineController', 'layout' => 'admin', 'heading' => 'Stories timeline', 'subheading' => 'Stories live on a timeline and provide important historical context'],
            ['name' => 'Story timeline', 'uri' => 'admin/timeline/posts', 'key' => 'admin.stories.posts-timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowPostsTimelineController', 'layout' => 'admin', 'heading' => 'Posts timeline', 'subheading' => 'Posts follow a linear path that helps organize your story chronologically'],

            ['name' => 'List posts', 'uri' => 'admin/posts', 'key' => 'admin.posts.index', 'resource' => 'Nova\\Stories\\Controllers\\PostController@index', 'layout' => 'admin', 'heading' => 'Posts', 'subheading' => 'Manage the chapters and entries in your game’s stories'],
            ['name' => 'View story post', 'uri' => 'admin/stories/{story}/posts/{post}/show', 'key' => 'admin.posts.show', 'resource' => 'Nova\\Stories\\Controllers\\PostController@show', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create story post', 'uri' => 'admin/posts/create/{neighbor?}/{direction?}', 'key' => 'admin.posts.create', 'resource' => 'Nova\\Stories\\Controllers\\PostController@create', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Edit story post', 'uri' => 'admin/posts/{post}/edit', 'key' => 'admin.posts.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostController@edit', 'layout' => 'admin', 'content_can_be_edited' => false],

            ['name' => 'List forms', 'uri' => 'admin/forms', 'key' => 'admin.forms.index', 'resource' => 'Nova\\Forms\\Controllers\\FormController@index', 'layout' => 'admin', 'heading' => 'Forms', 'subheading' => 'Manage all of Nova’s forms'],
            ['name' => 'View form', 'uri' => 'admin/forms/{form}/show', 'key' => 'admin.forms.show', 'resource' => 'Nova\\Forms\\Controllers\\FormController@show', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create form', 'uri' => 'admin/forms/create', 'key' => 'admin.forms.create', 'resource' => 'Nova\\Forms\\Controllers\\FormController@create', 'layout' => 'admin', 'heading' => 'Add a new form'],
            ['name' => 'Store form', 'uri' => 'admin/forms', 'key' => 'admin.forms.store', 'verb' => 'post', 'resource' => 'Nova\\Forms\\Controllers\\FormController@store', 'layout' => 'admin'],
            ['name' => 'Edit form', 'uri' => 'admin/forms/{form}/edit', 'key' => 'admin.forms.edit', 'resource' => 'Nova\\Forms\\Controllers\\FormController@edit', 'layout' => 'admin', 'heading' => 'Edit form'],
            ['name' => 'Update form', 'uri' => 'admin/forms/{form}', 'key' => 'admin.forms.update', 'verb' => 'put', 'resource' => 'Nova\\Forms\\Controllers\\FormController@update', 'layout' => 'admin'],
            ['name' => 'Design form', 'uri' => 'admin/forms/{form}/design', 'key' => 'admin.forms.design', 'resource' => 'Nova\\Forms\\Controllers\\DesignFormController', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Preview form', 'uri' => 'admin/forms/{form}/preview/{theme?}', 'key' => 'admin.forms.preview', 'resource' => 'Nova\\Forms\\Controllers\\PreviewFormController', 'layout' => 'admin', 'heading' => 'Preview form'],

            ['name' => 'List form submissions', 'uri' => 'admin/form-submissions', 'key' => 'admin.form-submissions.index', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@index', 'layout' => 'admin', 'heading' => 'Form submissions', 'subheading' => 'Manage all of Nova’s form submissions'],
            ['name' => 'View form submission', 'uri' => 'admin/forms-submissions/{submission}/show', 'key' => 'admin.form-submissions.show', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@show', 'layout' => 'admin', 'heading' => 'View form submission'],
            ['name' => 'Create form submission', 'uri' => 'admin/form-submissions/create/{form?}', 'key' => 'admin.form-submissions.create', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@create', 'layout' => 'admin', 'heading' => 'Submit a form', 'subheading' => 'Get started by picking a form to submit'],

            ['name' => 'List pages', 'uri' => 'admin/pages', 'key' => 'admin.pages.index', 'resource' => 'Nova\\Pages\\Controllers\\PageController@index', 'layout' => 'admin', 'heading' => 'Pages', 'subheading' => 'Manage all of Nova’s pages'],
            ['name' => 'View page', 'uri' => 'admin/pages/{page}/show', 'key' => 'admin.pages.show', 'resource' => 'Nova\\Pages\\Controllers\\PageController@show', 'layout' => 'admin', 'heading' => 'View page'],
            ['name' => 'Design page', 'uri' => 'admin/pages/{page}/design', 'key' => 'admin.pages.design', 'resource' => 'Nova\\Pages\\Controllers\\DesignPageController', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create page', 'uri' => 'admin/pages/create', 'key' => 'admin.pages.create', 'resource' => 'Nova\\Pages\\Controllers\\PageController@create', 'layout' => 'admin', 'heading' => 'Add a new page'],
            ['name' => 'Store page', 'uri' => 'admin/pages', 'key' => 'admin.pages.store', 'verb' => 'post', 'resource' => 'Nova\\Pages\\Controllers\\PageController@store', 'layout' => 'admin'],
            ['name' => 'Edit page', 'uri' => 'admin/pages/{page}/edit', 'key' => 'admin.pages.edit', 'resource' => 'Nova\\Pages\\Controllers\\PageController@edit', 'layout' => 'admin', 'heading' => 'Edit page'],
            ['name' => 'Update page', 'uri' => 'admin/pages/{page}', 'key' => 'admin.pages.update', 'verb' => 'put', 'resource' => 'Nova\\Pages\\Controllers\\PageController@update', 'layout' => 'admin'],

            ['name' => 'Messages', 'uri' => 'admin/messages/{discussion:prefixed_id?}', 'key' => 'admin.messages.index', 'resource' => 'Nova\\Discussions\\Controllers\\DiscussionController@index', 'layout' => 'admin', 'heading' => 'Messages'],

            ['name' => 'List applications', 'uri' => 'admin/applications', 'key' => 'admin.applications.index', 'resource' => 'Nova\\Applications\\Controllers\\ApplicationController@index', 'layout' => 'admin', 'heading' => 'Applications', 'subheading' => 'Review applications and accept or reject new players and characters'],
            ['name' => 'Show application', 'uri' => 'admin/applications/{application}/show', 'key' => 'admin.applications.show', 'resource' => 'Nova\\Applications\\Controllers\\ApplicationController@show', 'layout' => 'admin', 'content_can_be_edited' => false],

            ['name' => 'List menu items', 'uri' => 'admin/menu-items', 'key' => 'admin.menu-items.index', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@index', 'layout' => 'admin', 'heading' => 'Menu items', 'subheading' => 'Manage the individual menu items for the public site'],
            ['name' => 'Create menu item', 'uri' => 'admin/menu-items/create', 'key' => 'admin.menu-items.create', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@create', 'layout' => 'admin', 'heading' => 'Add a new menu item'],
            ['name' => 'Store menu item', 'uri' => 'admin/menu-items', 'key' => 'admin.menu-items.store', 'verb' => 'post', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@store', 'layout' => 'admin'],
            ['name' => 'Edit menu item', 'uri' => 'admin/menu-items/{menuItem}/edit', 'key' => 'admin.menu-items.edit', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@edit', 'layout' => 'admin', 'heading' => 'Edit menu item'],
            ['name' => 'Update menu item', 'uri' => 'admin/menu-items/{menuItem}', 'key' => 'admin.menu-items.update', 'verb' => 'put', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@update', 'layout' => 'admin'],

            ['name' => 'List announcements', 'uri' => 'admin/announcements', 'key' => 'admin.announcements.index', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@index', 'layout' => 'admin', 'heading' => 'Announcements'],
            ['name' => 'Show announcment', 'uri' => 'admin/announcements/{announcement}/show', 'key' => 'admin.announcements.show', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@show', 'layout' => 'admin', 'content_can_be_edited' => false],
            ['name' => 'Create announcement', 'uri' => 'admin/announcements/create', 'key' => 'admin.announcements.create', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@create', 'layout' => 'admin', 'heading' => 'Add a new announcement'],
            ['name' => 'Store announcement', 'uri' => 'admin/announcements', 'key' => 'admin.announcements.store', 'verb' => 'post', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@store', 'layout' => 'admin'],
            ['name' => 'Edit announcement', 'uri' => 'admin/announcements/{announcement}/edit', 'key' => 'admin.announcements.edit', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@edit', 'layout' => 'admin', 'heading' => 'Edit announcement'],
            ['name' => 'Update announcement', 'uri' => 'admin/announcements/{announcement}', 'key' => 'admin.announcements.update', 'verb' => 'put', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@update', 'layout' => 'admin'],

            ['name' => 'List add-ons', 'uri' => 'admin/addons', 'key' => 'admin.addons.index', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@index', 'layout' => 'admin', 'heading' => 'Add-ons', 'subheading' => 'Personalize and extend Nova with add-ons'],
            ['name' => 'Show add-on', 'uri' => 'admin/addons/{addon}/show', 'key' => 'admin.addons.show', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@show', 'layout' => 'admin', 'heading' => 'View add-on'],
            ['name' => 'Create add-on', 'uri' => 'admin/addons/create', 'key' => 'admin.addons.create', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@create', 'layout' => 'admin', 'heading' => 'Add a new add-on'],
            ['name' => 'Store add-on', 'uri' => 'admin/addons', 'key' => 'admin.addons.store', 'verb' => 'post', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@store', 'layout' => 'admin'],
            ['name' => 'Edit add-on', 'uri' => 'admin/addons/{addon}/edit', 'key' => 'admin.addons.edit', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@edit', 'layout' => 'admin', 'heading' => 'Edit add-on'],
            ['name' => 'Update add-on', 'uri' => 'admin/addons/{addon}', 'key' => 'admin.addons.update', 'verb' => 'put', 'resource' => 'Nova\\Addons\\Controllers\\AddonController@update', 'layout' => 'admin'],

            ['name' => 'Game overview dashboard', 'uri' => 'admin/reporting/game-overview', 'key' => 'admin.reporting.game-overview', 'resource' => 'Nova\\Reporting\\Controllers\\GameOverviewController', 'layout' => 'admin', 'heading' => 'Game overview'],
            ['name' => 'Game stats report', 'uri' => 'admin/reporting/game-stats', 'key' => 'admin.reporting.game-stats', 'resource' => 'Nova\\Reporting\\Controllers\\GameStatsController', 'layout' => 'admin', 'heading' => 'Game stats'],
            ['name' => 'Player participation report', 'uri' => 'admin/reporting/player-participation', 'key' => 'admin.reporting.player-participation', 'resource' => 'Nova\\Reporting\\Controllers\\PlayerParticipationController', 'layout' => 'admin', 'heading' => 'Player participation report'],
            ['name' => 'Player activity report', 'uri' => 'admin/reporting/player-activity', 'key' => 'admin.reporting.player-activity', 'resource' => 'Nova\\Reporting\\Controllers\\PlayerActivityController', 'layout' => 'admin', 'heading' => 'Player activity report'],
            ['name' => 'Post types report', 'uri' => 'admin/reporting/post-types', 'key' => 'admin.reporting.post-types', 'resource' => 'Nova\\Reporting\\Controllers\\PostTypesController', 'layout' => 'admin', 'heading' => 'Post types report'],

            ['name' => 'List bans', 'uri' => 'admin/bans', 'key' => 'admin.bans.index', 'resource' => 'Nova\\Users\\Controllers\\BanController@index', 'layout' => 'admin', 'heading' => 'Bans', 'subheading' => 'Manage any banned users or IP addresses for your site'],
            ['name' => 'Create ban', 'uri' => 'admin/bans/create', 'key' => 'admin.bans.create', 'resource' => 'Nova\\Users\\Controllers\\BanController@create', 'layout' => 'admin', 'heading' => 'Add a new ban'],
            ['name' => 'Store ban', 'uri' => 'admin/bans', 'key' => 'admin.bans.store', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\BanController@store', 'layout' => 'admin'],
        ];
    }

    /** @return list<array<string, mixed>> */
    protected function publicPages(): array
    {
        return [
            [
                'name' => 'Homepage',
                'uri' => '/',
                'key' => 'home',
                'layout' => 'public',
                'blocks' => '[{"type":"hero.stacked","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"lg"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"lg","vertical":"xl"},"bg":{"option":"mesh-dark-014","intensity":"intense"},"border":{"enabled":"no"},"shadow":"lg","radius":"xl","orientation":"left","heading":{"text":"Welcome to Nova 3!","color":"#ffffff","shadow":"sm"},"message":{"text":"Occaecat Lorem deserunt ad pariatur aliquip ut eu nulla occaecat qui in mollit irure deserunt. Mollit ea mollit cillum velit sint tempor veniam aliquip voluptate anim excepteur dolore ullamco. Dolore tempor eiusmod voluptate quis voluptate Lorem deserunt esse ut eiusmod sint.","color":"#ffffff","shadow":"none"},"callout":{"text":"Welcome to the next generation","decoration":"none","url":"http:\/\/google.com","type":"badge","color":"rgba(47, 163, 142, 1)","bg":{"color":"rgba(230, 255, 250, 1)"},"border":{"color":"rgba(194, 255, 238, 1)"},"shadow":"none","radius":"full"}},"block":{"buttons":[],"media":{"type":"none"}}}},{"type":"stats.simple","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"lg"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"center","heading":{"text":"Stats","color":"#228567","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"appearance":{"stat-color":"rgba(0, 0, 0, 1)","label-color":"rgba(140, 140, 140, 1)"},"stats":[{"stat":"current-user-count","heading":"Total active users"},{"stat":"current-character-count","heading":"Total active characters"},{"stat":"all-time-posts","heading":"All-time posts"},{"stat":"all-time-post-words","heading":"All-time post words"}]}}},{"type":"hero.stacked","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"md"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"xl","vertical":"lg"},"bg":{"option":"mesh-dark-003","intensity":"intense"},"border":{"enabled":"no"},"shadow":"lg","radius":"xl","orientation":"center","heading":{"text":"Join today","color":"rgba(255, 255, 255, 1)","shadow":"none"},"message":{"text":"Proident labore reprehenderit et ea eu. Minim amet enim ad. Quis cillum ullamco ullamco incididunt. Mollit officia do dolor exercitation mollit reprehenderit incididunt reprehenderit labore. Irure sunt laboris adipisicing veniam irure dolore quis pariatur est ullamco duis cillum. Consectetur fugiat in exercitation adipisicing cupidatat deserunt.","color":"rgba(255, 255, 255, 0.7)","shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"buttons":[{"text":"Join","decoration":"arrow","url":"https:\/\/nova3.test\/join","url-target":"_self","bg-color":"rgba(255, 255, 255, 1)","text-color":"rgba(0, 0, 0, 1)","border-style":"none","shadow":"lg","radius":"lg","size":"lg"}],"media":{"type":"none"}}}}]',
                'published_blocks' => '[{"type":"hero.stacked","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"lg"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"lg","vertical":"xl"},"bg":{"option":"mesh-dark-014","intensity":"intense"},"border":{"enabled":"no"},"shadow":"lg","radius":"xl","orientation":"left","heading":{"text":"Welcome to Nova 3!","color":"#ffffff","shadow":"sm"},"message":{"text":"Occaecat Lorem deserunt ad pariatur aliquip ut eu nulla occaecat qui in mollit irure deserunt. Mollit ea mollit cillum velit sint tempor veniam aliquip voluptate anim excepteur dolore ullamco. Dolore tempor eiusmod voluptate quis voluptate Lorem deserunt esse ut eiusmod sint.","color":"#ffffff","shadow":"none"},"callout":{"text":"Welcome to the next generation","decoration":"none","url":"http:\/\/google.com","type":"badge","color":"rgba(47, 163, 142, 1)","bg":{"color":"rgba(230, 255, 250, 1)"},"border":{"color":"rgba(194, 255, 238, 1)"},"shadow":"none","radius":"full"}},"block":{"buttons":[],"media":{"type":"none"}}}},{"type":"stats.simple","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"lg"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"center","heading":{"text":"Stats","color":"#228567","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"appearance":{"stat-color":"rgba(0, 0, 0, 1)","label-color":"rgba(140, 140, 140, 1)"},"stats":[{"stat":"current-user-count","heading":"Total active users"},{"stat":"current-character-count","heading":"Total active characters"},{"stat":"all-time-posts","heading":"All-time posts"},{"stat":"all-time-post-words","heading":"All-time post words"}]}}},{"type":"hero.stacked","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"md"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"xl","vertical":"lg"},"bg":{"option":"mesh-dark-003","intensity":"intense"},"border":{"enabled":"no"},"shadow":"lg","radius":"xl","orientation":"center","heading":{"text":"Join today","color":"rgba(255, 255, 255, 1)","shadow":"none"},"message":{"text":"Proident labore reprehenderit et ea eu. Minim amet enim ad. Quis cillum ullamco ullamco incididunt. Mollit officia do dolor exercitation mollit reprehenderit incididunt reprehenderit labore. Irure sunt laboris adipisicing veniam irure dolore quis pariatur est ullamco duis cillum. Consectetur fugiat in exercitation adipisicing cupidatat deserunt.","color":"rgba(255, 255, 255, 0.7)","shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"buttons":[{"text":"Join","decoration":"arrow","url":"https:\/\/nova3.test\/join","url-target":"_self","bg-color":"rgba(255, 255, 255, 1)","text-color":"rgba(0, 0, 0, 1)","border-style":"none","shadow":"lg","radius":"lg","size":"lg"}],"media":{"type":"none"}}}}]',
            ],
            [
                'name' => 'Characters',
                'uri' => 'characters',
                'key' => 'public.characters',
                'layout' => 'public',
                'blocks' => '[{"type":"manifest.index","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"left","heading":{"text":"Characters","color":"rgba(0, 0, 0, 1)","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"layout":"cards","characterOptions":["avatar","position","rank-image","rank-name"],"cardOrientation":"center","showDepartments":true,"departmentStatus":"active","positionStatus":"active","showAvailablePositions":false,"showCharacters":true,"characterStatus":"active","characterType":"all"}}}]',
                'published_blocks' => '[{"type":"manifest.index","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"left","heading":{"text":"Characters","color":"rgba(0, 0, 0, 1)","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"layout":"cards","characterOptions":["avatar","position","rank-image","rank-name"],"cardOrientation":"center","showDepartments":true,"departmentStatus":"active","positionStatus":"active","showAvailablePositions":false,"showCharacters":true,"characterStatus":"active","characterType":"all"}}}]',
            ],
            [
                'name' => 'Stories',
                'uri' => 'stories',
                'key' => 'public.stories',
                'layout' => 'public',
                'blocks' => '[{"type":"stories.timeline","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"left","heading":{"text":"Stories","color":"rgba(0, 0, 0, 1)","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"timelineSorting":"asc"}}}]',
                'published_blocks' => '[{"type":"stories.timeline","data":{"container":{"width":"full","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"}},"content":{"width":"6xl","spacing":{"horizontal":"none","vertical":"none"},"bg":{"option":"transparent"},"border":{"enabled":"no"},"shadow":"none","radius":"none","orientation":"left","heading":{"text":"Stories","color":"rgba(0, 0, 0, 1)","shadow":"none"},"message":{"text":null,"color":null,"shadow":"none"},"callout":{"text":null,"decoration":"none","url":null,"type":"text","color":null,"bg":[],"border":[]}},"block":{"timelineSorting":"asc"}}}]',
            ],
            ['name' => 'Join page', 'uri' => 'join/{position?}', 'key' => 'public.join', 'resource' => 'Nova\\PublicSite\\Controllers\\ShowJoinFormController', 'layout' => 'public', 'seo_title' => 'Join the game', 'heading' => 'Join'],
            ['name' => 'Process join form', 'uri' => 'join', 'key' => 'public.join.process', 'resource' => 'Nova\\PublicSite\\Controllers\\ProcessJoinFormController', 'layout' => 'public', 'middleware' => ['throttle:join'], 'verb' => 'post'],
            ['name' => 'Contact page', 'uri' => 'contact', 'key' => 'public.contact', 'resource' => 'Nova\\PublicSite\\Controllers\\ShowContactFormController', 'layout' => 'public', 'seo_title' => 'Contact us', 'heading' => 'Contact us'],
            ['name' => 'Process contact form', 'uri' => 'contact', 'key' => 'public.contact.process', 'resource' => 'Nova\\PublicSite\\Controllers\\ProcessContactFormController', 'layout' => 'public', 'middleware' => ['throttle:contact'], 'verb' => 'post'],
            ['name' => 'View character bio', 'uri' => 'character/{character}', 'key' => 'public.character-bio', 'resource' => 'Nova\\PublicSite\\Controllers\\ShowCharacterBioController', 'layout' => 'public', 'content_can_be_edited' => false],
            ['name' => 'View story', 'uri' => 'story/{story}', 'key' => 'public.story', 'resource' => 'Nova\\PublicSite\\Controllers\\ShowStoryController', 'layout' => 'public', 'content_can_be_edited' => false],
            ['name' => 'View story post', 'uri' => 'story/{story}/post/{post}', 'key' => 'public.story-post', 'resource' => 'Nova\\PublicSite\\Controllers\\ShowStoryPostController', 'layout' => 'public', 'content_can_be_edited' => false],
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     * @param  array<string, mixed>  $template
     * @return list<array<string, mixed>>
     */
    protected function conformRows(array $rows, array $template): array
    {
        foreach ($rows as &$row) {
            foreach (['middleware'] as $jsonish) {
                if (array_key_exists($jsonish, $row) && is_array($row[$jsonish])) {
                    $row[$jsonish] = json_encode($row[$jsonish], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
            }

            $row = array_replace($template, $row);
        }

        unset($row);

        return $rows;
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     * @return list<array<string, mixed>>
     */
    protected function prepareRows(array $rows, CarbonInterface $now, bool $setPublished): array
    {
        foreach ($rows as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;

            if ($setPublished) {
                $row['published_at'] = $now;
            }

            $verb = data_get($row, 'verb');
            if (in_array($verb, ['delete', 'post', 'put'], true)) {
                $row['content_can_be_edited'] = false;
            }
        }

        unset($row);

        return $rows;
    }

    /** @return array<string, mixed> */
    private function pageTemplate(CarbonInterface $now): array
    {
        return [
            'name' => null,
            'uri' => null,
            'key' => null,
            'verb' => 'get',
            'resource' => null,
            'layout' => null,
            'middleware' => null,
            'blocks' => null,
            'published_blocks' => null,
            'seo_title' => null,
            'seo_description' => null,
            'seo_keywords' => null,
            'published_at' => null,
            'content_can_be_edited' => true,
            'heading' => null,
            'subheading' => null,
            'intro' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
};
