<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Nova\Pages\Actions\PublishPage;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Page;

class PopulatePagesTable extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $this->populateAdminPages();

        $this->populatePublicPages();

        $pages = Page::whereNull('prefixed_id')->get();

        $reflectedMethod = new ReflectionMethod(Page::class, 'generatePrefixedId');

        foreach ($pages as $page) {
            $page->forceFill(['prefixed_id' => $reflectedMethod->invoke($page)]);
            $page->save();
        }

        activity()->enableLogging();
    }

    public function down()
    {
        Page::truncate();
    }

    protected function populateAdminPages(): void
    {
        $pages = [
            ['name' => 'Dashboard', 'uri' => 'admin/dashboard', 'key' => 'admin.dashboard', 'resource' => 'Nova\\Dashboards\\Controllers\\DashboardController', 'layout' => 'admin', 'content_can_be_edited' => true],
            ['name' => 'System overview dashboard', 'uri' => 'admin/system-overview', 'key' => 'admin.system-overview', 'resource' => 'Nova\\Dashboards\\Controllers\\SystemOverviewController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'System overview'],
            ['name' => 'Writing dashboard', 'uri' => 'admin/writing-overview', 'key' => 'admin.writing-overview', 'resource' => 'Nova\\Stories\\Controllers\\WritingOverviewController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'My draft posts', 'subheading' => 'Drafts are posts in progress that have not been published'],
            ['name' => 'List activity logs', 'uri' => 'admin/activity-log', 'key' => 'admin.activity-log.index', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Activity log', 'subheading' => 'Track all user activity in Nova'],
            ['name' => 'View activity log', 'uri' => 'admin/activity-log/{activity}/show', 'key' => 'admin.activity-log.show', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Activity log detail'],

            ['name' => 'List themes', 'uri' => 'admin/themes', 'key' => 'admin.themes.index', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@index', 'layout' => 'admin'],
            ['name' => 'View theme', 'uri' => 'admin/themes/{theme}/show', 'key' => 'admin.themes.show', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@show', 'layout' => 'admin'],
            ['name' => 'Create theme', 'uri' => 'admin/themes/create', 'key' => 'admin.themes.create', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@create', 'layout' => 'admin'],
            ['name' => 'Store theme', 'uri' => 'admin/themes', 'key' => 'admin.themes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['name' => 'Edit theme', 'uri' => 'admin/themes/{theme}/edit', 'key' => 'admin.themes.edit', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@edit', 'layout' => 'admin'],
            ['name' => 'Update theme', 'uri' => 'admin/themes/{theme}', 'key' => 'admin.themes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@update', 'layout' => 'admin'],

            ['name' => 'List roles', 'uri' => 'admin/roles', 'key' => 'admin.roles.index', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Roles', 'subheading' => 'Control what users can do throughout Nova'],
            ['name' => 'View role', 'uri' => 'admin/roles/{role}/show', 'key' => 'admin.roles.show', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View role'],
            ['name' => 'Create role', 'uri' => 'admin/roles/create', 'key' => 'admin.roles.create', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new role'],
            ['name' => 'Store role', 'uri' => 'admin/roles', 'key' => 'admin.roles.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['name' => 'Edit role', 'uri' => 'admin/roles/{role}/edit', 'key' => 'admin.roles.edit', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit role'],
            ['name' => 'Update role', 'uri' => 'admin/roles/{role}', 'key' => 'admin.roles.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@update', 'layout' => 'admin'],

            ['name' => 'List permissions', 'uri' => 'admin/permissions', 'key' => 'admin.permissions.index', 'resource' => 'Nova\\Roles\\Controllers\\PermissionController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Permissions', 'subheading' => 'View all of the available permissions in Nova'],

            ['name' => 'List users', 'uri' => 'admin/users', 'key' => 'admin.users.index', 'resource' => 'Nova\\Users\\Controllers\\UserController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Users', 'subheading' => 'Manage all of the game’s users'],
            ['name' => 'View user', 'uri' => 'admin/users/{user}/show', 'key' => 'admin.users.show', 'resource' => 'Nova\\Users\\Controllers\\UserController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View user'],
            ['name' => 'Create user', 'uri' => 'admin/users/create', 'key' => 'admin.users.create', 'resource' => 'Nova\\Users\\Controllers\\UserController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new user'],
            ['name' => 'Store user', 'uri' => 'admin/users', 'key' => 'admin.users.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Users\\Controllers\\UserController@store', 'layout' => 'admin'],
            ['name' => 'Edit user', 'uri' => 'admin/users/{user}/edit', 'key' => 'admin.users.edit', 'resource' => 'Nova\\Users\\Controllers\\UserController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit user'],
            ['name' => 'Update user', 'uri' => 'admin/users/{user}', 'key' => 'admin.users.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Users\\Controllers\\UserController@update', 'layout' => 'admin'],

            ['name' => 'My account', 'uri' => 'admin/account', 'key' => 'admin.account.edit', 'resource' => 'Nova\\Users\\Controllers\\EditAccountController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Account settings'],
            ['name' => 'Notification preferences', 'uri' => 'admin/account/notifications', 'key' => 'admin.account.notifications', 'resource' => 'Nova\\Users\\Controllers\\NotificationPreferencesController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'My notification preferences'],
            ['name' => 'Delete my account', 'uri' => 'admin/account/delete', 'key' => 'admin.account.delete', 'resource' => 'Nova\\Users\\Controllers\\DeleteAccountController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Delete my account'],

            ['name' => 'List all my notes', 'uri' => 'admin/notes', 'key' => 'admin.notes.index', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'My notes'],
            ['name' => 'View my note', 'uri' => 'admin/notes/{note}/show', 'key' => 'admin.notes.show', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View note'],
            ['name' => 'Create note', 'uri' => 'admin/notes/create', 'key' => 'admin.notes.create', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new note'],
            ['name' => 'Store note', 'uri' => 'admin/notes', 'key' => 'admin.notes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@store', 'layout' => 'admin'],
            ['name' => 'Edit note', 'uri' => 'admin/notes/{note}/edit', 'key' => 'admin.notes.edit', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit note'],
            ['name' => 'Update note', 'uri' => 'admin/notes/{note}', 'key' => 'admin.notes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@update', 'layout' => 'admin'],

            ['name' => 'Appearance settings', 'uri' => 'admin/settings/appearance', 'key' => 'admin.settings.appearance.edit', 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Appearance settings'],
            ['name' => 'Update appearance settings', 'uri' => 'admin/settings/appearance', 'key' => 'admin.settings.appearance.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Character settings', 'uri' => 'admin/settings/characters', 'key' => 'admin.settings.characters.edit', 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Character settings'],
            ['name' => 'Update character settings', 'uri' => 'admin/settings/characters', 'key' => 'admin.settings.characters.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Content ratings settings', 'uri' => 'admin/settings/content-ratings', 'key' => 'admin.settings.content-ratings.edit', 'resource' => 'Nova\\Settings\\Controllers\\ContentRatingSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Content ratings settings'],
            ['name' => 'Update content settings ratings', 'uri' => 'admin/settings/content-ratings', 'key' => 'admin.settings.content-ratings.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\ContentRatingSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Email settings', 'uri' => 'admin/settings/email', 'key' => 'admin.settings.email.edit', 'resource' => 'Nova\\Settings\\Controllers\\EmailSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Email settings'],
            ['name' => 'Update email settings', 'uri' => 'admin/settings/email', 'key' => 'admin.settings.email.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\EmailSettingsController@update', 'layout' => 'admin'],
            ['name' => 'General settings', 'uri' => 'admin/settings/general', 'key' => 'admin.settings.general.edit', 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'General settings'],
            ['name' => 'Update general settings', 'uri' => 'admin/settings/general', 'key' => 'admin.settings.general.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Posting activity settings', 'uri' => 'admin/settings/posting-activity', 'key' => 'admin.settings.posting-activity.edit', 'resource' => 'Nova\\Settings\\Controllers\\PostingActivitySettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Posting activity settings'],
            ['name' => 'Update posting activity settings', 'uri' => 'admin/settings/posting-activity', 'key' => 'admin.settings.posting-activity.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\PostingActivitySettingsController@update', 'layout' => 'admin'],
            ['name' => 'Notification settings', 'uri' => 'admin/settings/notifications', 'key' => 'admin.settings.notifications.edit', 'resource' => 'Nova\\Settings\\Controllers\\NotificationSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Notification settings'],
            ['name' => 'Environment settings', 'uri' => 'admin/settings/environment', 'key' => 'admin.settings.environment.edit', 'resource' => 'Nova\\Settings\\Controllers\\EnvironmentSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Environment settings'],
            ['name' => 'Update environment settings', 'uri' => 'admin/settings/environment', 'key' => 'admin.settings.environment.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\EnvironmentSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Application settings', 'uri' => 'admin/settings/applications', 'key' => 'admin.settings.applications.edit', 'resource' => 'Nova\\Settings\\Controllers\\ApplicationSettingsController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Applications settings'],
            ['name' => 'Update application settings', 'uri' => 'admin/settings/applications', 'key' => 'admin.settings.applications.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\ApplicationSettingsController@update', 'layout' => 'admin'],

            ['name' => 'List rank groups', 'uri' => 'admin/ranks/groups', 'key' => 'admin.ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Rank groups', 'subheading' => 'Collections of related rank items for simpler searching and selecting'],
            ['name' => 'View rank group', 'uri' => 'admin/ranks/groups/{group}/show', 'key' => 'admin.ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View rank group'],
            ['name' => 'Create rank group', 'uri' => 'admin/ranks/groups/create', 'key' => 'admin.ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new rank group'],
            ['name' => 'Store rank group', 'uri' => 'admin/ranks/groups', 'key' => 'admin.ranks.groups.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank group', 'uri' => 'admin/ranks/groups/{group}/edit', 'key' => 'admin.ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit rank group'],
            ['name' => 'Update rank group', 'uri' => 'admin/ranks/groups/{group}', 'key' => 'admin.ranks.groups.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@update', 'layout' => 'admin'],

            ['name' => 'List rank names', 'uri' => 'admin/ranks/names', 'key' => 'admin.ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Rank names', 'subheading' => 'Re-use basic rank information across all of your rank items'],
            ['name' => 'View rank name', 'uri' => 'admin/ranks/names/{name}/show', 'key' => 'admin.ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View rank name'],
            ['name' => 'Create rank name', 'uri' => 'admin/ranks/names/create', 'key' => 'admin.ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new rank name'],
            ['name' => 'Store rank nane', 'uri' => 'admin/ranks/names', 'key' => 'admin.ranks.names.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank name', 'uri' => 'admin/ranks/names/{name}/edit', 'key' => 'admin.ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit rank name'],
            ['name' => 'Update rank name', 'uri' => 'admin/ranks/names/{name}', 'key' => 'admin.ranks.names.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@update', 'layout' => 'admin'],

            ['name' => 'List rank items', 'uri' => 'admin/ranks/items', 'key' => 'admin.ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Rank items', 'subheading' => 'Combine a rank group, name, and images to define your game’s ranks'],
            ['name' => 'View rank item', 'uri' => 'admin/ranks/items/{item}/show', 'key' => 'admin.ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View rank item'],
            ['name' => 'Create rank item', 'uri' => 'admin/ranks/items/create', 'key' => 'admin.ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new rank item'],
            ['name' => 'Store rank item', 'uri' => 'admin/ranks/items', 'key' => 'admin.ranks.items.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank item', 'uri' => 'admin/ranks/items/{item}/edit', 'key' => 'admin.ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit rank item'],
            ['name' => 'Update rank item', 'uri' => 'admin/ranks/items/{item}', 'key' => 'admin.ranks.items.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@update', 'layout' => 'admin'],

            ['name' => 'List departments', 'uri' => 'admin/departments', 'key' => 'admin.departments.index', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Departments', 'subheading' => 'Organize character positions into logical groups that you can display on your manifests'],
            ['name' => 'View department', 'uri' => 'admin/departments/{department}/show', 'key' => 'admin.departments.show', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View department'],
            ['name' => 'Create department', 'uri' => 'admin/departments/create', 'key' => 'admin.departments.create', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new department'],
            ['name' => 'Store department', 'uri' => 'admin/departments', 'key' => 'admin.departments.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@store', 'layout' => 'admin'],
            ['name' => 'Edit department', 'uri' => 'admin/departments/{department}/edit', 'key' => 'admin.departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit department'],
            ['name' => 'Update department', 'uri' => 'admin/departments/{department}', 'key' => 'admin.departments.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@update', 'layout' => 'admin'],

            ['name' => 'List positions', 'uri' => 'admin/positions', 'key' => 'admin.positions.index', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Positions', 'subheading' => 'The jobs or stations characters are assigned to for display on your manifests'],
            ['name' => 'View position', 'uri' => 'admin/positions/{position}/show', 'key' => 'admin.positions.show', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View position'],
            ['name' => 'Create position', 'uri' => 'admin/positions/create', 'key' => 'admin.positions.create', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new position'],
            ['name' => 'Store position', 'uri' => 'admin/positions', 'key' => 'admin.positions.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@store', 'layout' => 'admin'],
            ['name' => 'Edit position', 'uri' => 'admin/positions/{position}/edit', 'key' => 'admin.positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit position'],
            ['name' => 'Update position', 'uri' => 'admin/positions/{position}', 'key' => 'admin.positions.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@update', 'layout' => 'admin'],

            ['name' => 'List characters', 'uri' => 'admin/characters', 'key' => 'admin.characters.index', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Characters', 'subheading' => 'Manage all of the game’s characters'],
            ['name' => 'View character', 'uri' => 'admin/characters/{character}/show', 'key' => 'admin.characters.show', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View character'],
            ['name' => 'Create character', 'uri' => 'admin/characters/create', 'key' => 'admin.characters.create', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new character'],
            ['name' => 'Store character', 'uri' => 'admin/characters', 'key' => 'admin.characters.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@store', 'layout' => 'admin'],
            ['name' => 'Edit character', 'uri' => 'admin/characters/{character}/edit', 'key' => 'admin.characters.edit', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit character'],
            ['name' => 'Update character', 'uri' => 'admin/characters/{character}', 'key' => 'admin.characters.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@update', 'layout' => 'admin'],

            ['name' => 'List post types', 'uri' => 'admin/post-types', 'key' => 'admin.post-types.index', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Post types', 'subheading' => 'Control the content users can post into stories'],
            ['name' => 'View post type', 'uri' => 'admin/post-types/{postType}/show', 'key' => 'admin.post-types.show', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View post type'],
            ['name' => 'Create post type', 'uri' => 'admin/post-types/create', 'key' => 'admin.post-types.create', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a post type'],
            ['name' => 'Store post type', 'uri' => 'admin/post-types', 'key' => 'admin.post-types.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@store', 'layout' => 'admin'],
            ['name' => 'Edit post type', 'uri' => 'admin/post-types/{postType}/edit', 'key' => 'admin.post-types.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit post type'],
            ['name' => 'Update post type', 'uri' => 'admin/post-types/{postType}', 'key' => 'admin.post-types.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@update', 'layout' => 'admin'],

            ['name' => 'List stories', 'uri' => 'admin/stories', 'key' => 'admin.stories.index', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Stories', 'subheading' => 'Manage the stories and timeline of your game'],
            ['name' => 'View story', 'uri' => 'admin/stories/{story}/show', 'key' => 'admin.stories.show', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@show', 'layout' => 'admin'],
            ['name' => 'Create story', 'uri' => 'admin/stories/create', 'key' => 'admin.stories.create', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new story'],
            ['name' => 'Store story', 'uri' => 'admin/stories', 'key' => 'admin.stories.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@store', 'layout' => 'admin'],
            ['name' => 'Edit story', 'uri' => 'admin/stories/{story}/edit', 'key' => 'admin.stories.edit', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit story'],
            ['name' => 'Update story', 'uri' => 'admin/stories/{story}', 'key' => 'admin.stories.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@update', 'layout' => 'admin'],
            ['name' => 'Delete stories', 'uri' => 'admin/stories/{id}/delete', 'key' => 'admin.stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@delete', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Delete stories', 'subheading' => 'Manage story deletion and how nested stories and story posts should be handled'],
            ['name' => 'Destroy stories', 'uri' => 'admin/stories', 'key' => 'admin.stories.destroy', 'verb' => PageVerb::delete, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@destroy', 'layout' => 'admin'],
            ['name' => 'Stories timeline', 'uri' => 'admin/timeline/stories', 'key' => 'admin.stories.stories-timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoriesTimelineController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Stories timeline', 'subheading' => 'Stories live on a timeline and provide important historical context'],
            ['name' => 'Story timeline', 'uri' => 'admin/timeline/posts', 'key' => 'admin.stories.posts-timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowPostsTimelineController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Posts timeline', 'subheading' => 'Posts follow a linear path that helps organize your story chronologically'],

            ['name' => 'List posts', 'uri' => 'admin/posts', 'key' => 'admin.posts.index', 'resource' => 'Nova\\Stories\\Controllers\\PostController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Posts', 'subheading' => 'Manage the chapters and entries in your game’s stories'],
            ['name' => 'View story post', 'uri' => 'admin/stories/{story}/posts/{post}/show', 'key' => 'admin.posts.show', 'resource' => 'Nova\\Stories\\Controllers\\PostController@show', 'layout' => 'admin'],
            ['name' => 'Create story post', 'uri' => 'admin/posts/create/{neighbor?}/{direction?}', 'key' => 'admin.posts.create', 'resource' => 'Nova\\Stories\\Controllers\\PostController@create', 'layout' => 'admin'],
            ['name' => 'Edit story post', 'uri' => 'admin/posts/{post}/edit', 'key' => 'admin.posts.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostController@edit', 'layout' => 'admin'],

            ['name' => 'List forms', 'uri' => 'admin/forms', 'key' => 'admin.forms.index', 'resource' => 'Nova\\Forms\\Controllers\\FormController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Forms', 'subheading' => 'Manage all of Nova’s forms'],
            ['name' => 'View form', 'uri' => 'admin/forms/{form}/show', 'key' => 'admin.forms.show', 'resource' => 'Nova\\Forms\\Controllers\\FormController@show', 'layout' => 'admin'],
            ['name' => 'Create form', 'uri' => 'admin/forms/create', 'key' => 'admin.forms.create', 'resource' => 'Nova\\Forms\\Controllers\\FormController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new form'],
            ['name' => 'Store form', 'uri' => 'admin/forms', 'key' => 'admin.forms.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Forms\\Controllers\\FormController@store', 'layout' => 'admin'],
            ['name' => 'Edit form', 'uri' => 'admin/forms/{form}/edit', 'key' => 'admin.forms.edit', 'resource' => 'Nova\\Forms\\Controllers\\FormController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit form'],
            ['name' => 'Update form', 'uri' => 'admin/forms/{form}', 'key' => 'admin.forms.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Forms\\Controllers\\FormController@update', 'layout' => 'admin'],
            ['name' => 'Design form', 'uri' => 'admin/forms/{form}/design', 'key' => 'admin.forms.design', 'resource' => 'Nova\\Forms\\Controllers\\DesignFormController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Design form'],
            ['name' => 'Preview form', 'uri' => 'admin/forms/{form}/preview/{theme?}', 'key' => 'admin.forms.preview', 'resource' => 'Nova\\Forms\\Controllers\\PreviewFormController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Preview form'],

            ['name' => 'List form submissions', 'uri' => 'admin/form-submissions', 'key' => 'admin.form-submissions.index', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Form submissions', 'subheading' => 'Manage all of Nova’s form submissions'],
            ['name' => 'View form submission', 'uri' => 'admin/forms-submissions/{submission}/show', 'key' => 'admin.form-submissions.show', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View form submission'],
            ['name' => 'Create form submission', 'uri' => 'admin/form-submissions/create/{form?}', 'key' => 'admin.form-submissions.create', 'resource' => 'Nova\\Forms\\Controllers\\FormSubmissionController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Submit a form', 'subheading' => 'Get started by picking a form to submit'],

            ['name' => 'List pages', 'uri' => 'admin/pages', 'key' => 'admin.pages.index', 'resource' => 'Nova\\Pages\\Controllers\\PageController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Pages', 'subheading' => 'Manage all of Nova’s pages'],
            ['name' => 'View page', 'uri' => 'admin/pages/{page}/show', 'key' => 'admin.pages.show', 'resource' => 'Nova\\Pages\\Controllers\\PageController@show', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'View page'],
            ['name' => 'Design page', 'uri' => 'admin/pages/{page}/design', 'key' => 'admin.pages.design', 'resource' => 'Nova\\Pages\\Controllers\\DesignPageController', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Design page'],
            ['name' => 'Create page', 'uri' => 'admin/pages/create', 'key' => 'admin.pages.create', 'resource' => 'Nova\\Pages\\Controllers\\PageController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new page'],
            ['name' => 'Store page', 'uri' => 'admin/pages', 'key' => 'admin.pages.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Pages\\Controllers\\PageController@store', 'layout' => 'admin'],
            ['name' => 'Edit page', 'uri' => 'admin/pages/{page}/edit', 'key' => 'admin.pages.edit', 'resource' => 'Nova\\Pages\\Controllers\\PageController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit page'],
            ['name' => 'Update page', 'uri' => 'admin/pages/{page}', 'key' => 'admin.pages.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Pages\\Controllers\\PageController@update', 'layout' => 'admin'],

            ['name' => 'Messages', 'uri' => 'admin/messages/{discussion:prefixed_id?}', 'key' => 'admin.messages.index', 'resource' => 'Nova\\Discussions\\Controllers\\DiscussionController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Messages'],

            ['name' => 'List applications', 'uri' => 'admin/applications', 'key' => 'admin.applications.index', 'resource' => 'Nova\\Applications\\Controllers\\ApplicationController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Applications', 'subheading' => 'Review applications and accept or reject new players and characters'],
            ['name' => 'Show application', 'uri' => 'admin/applications/{application}/show', 'key' => 'admin.applications.show', 'resource' => 'Nova\\Applications\\Controllers\\ApplicationController@show', 'layout' => 'admin'],

            ['name' => 'List menu items', 'uri' => 'admin/menu-items', 'key' => 'admin.menu-items.index', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Menu items', 'subheading' => 'Manage the individual menu items for the public site'],
            ['name' => 'Create menu item', 'uri' => 'admin/menu-items/create', 'key' => 'admin.menu-items.create', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new menu item'],
            ['name' => 'Store menu item', 'uri' => 'admin/menu-items', 'key' => 'admin.menu-items.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@store', 'layout' => 'admin'],
            ['name' => 'Edit menu item', 'uri' => 'admin/menu-items/{menuItem}/edit', 'key' => 'admin.menu-items.edit', 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit menu item'],
            ['name' => 'Update menu item', 'uri' => 'admin/menu-items/{menuItem}', 'key' => 'admin.menu-items.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Menus\\Controllers\\MenuItemController@update', 'layout' => 'admin'],

            ['name' => 'List announcements', 'uri' => 'admin/announcements', 'key' => 'admin.announcements.index', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@index', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Announcements'],
            ['name' => 'Show announcment', 'uri' => 'admin/announcements/{announcement}/show', 'key' => 'admin.announcements.show', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@show', 'layout' => 'admin'],
            ['name' => 'Create announcement', 'uri' => 'admin/announcements/create', 'key' => 'admin.announcements.create', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@create', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Add a new announcement'],
            ['name' => 'Store announcement', 'uri' => 'admin/announcements', 'key' => 'admin.announcements.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@store', 'layout' => 'admin'],
            ['name' => 'Edit announcement', 'uri' => 'admin/announcements/{announcement}/edit', 'key' => 'admin.announcements.edit', 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@edit', 'layout' => 'admin', 'content_can_be_edited' => true, 'heading' => 'Edit announcement'],
            ['name' => 'Update announcement', 'uri' => 'admin/announcements/{announcement}', 'key' => 'admin.announcements.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Announcements\\Controllers\\AnnouncementController@update', 'layout' => 'admin'],
        ];

        Page::unguarded(fn () => collect($pages)->each([Page::class, 'create']));
    }

    protected function populatePublicPages(): void
    {
        $basicPages = [
            [
                'name' => 'Homepage',
                'uri' => '/',
                'key' => 'home',
                'layout' => 'public',
                'blocks' => '{"type":"doc","content":[{"type":"scribbleBlock","attrs":{"id":"6185fa55-d67c-42bd-9bb2-52e4e488116f","type":"block","identifier":"hero-stacked","values":{"heading":"Welcome to Nova 3!","description":"Occaecat Lorem deserunt ad pariatur aliquip ut eu nulla occaecat qui in mollit irure deserunt. Mollit ea mollit cillum velit sint tempor veniam aliquip voluptate anim excepteur dolore ullamco. Dolore tempor eiusmod voluptate quis voluptate Lorem deserunt esse ut eiusmod sint.","primaryButtonLabel":null,"primaryButtonUrl":null,"primaryButtonBgColor":null,"primaryButtonTextColor":null,"secondaryButtonLabel":null,"secondaryButtonUrl":null,"calloutText":"Welcome to the next generation","calloutUrl":null,"calloutColor":"Teal","bgOption":"mesh-dark-014","bgImageIntensity":"intense","dark":true,"spacingHorizontal":null,"spacingVertical":"extra-large","mediaType":"none"}}},{"type":"scribbleBlock","attrs":{"id":"9e442768-6892-449b-bc86-c8764ea53f98","type":"block","identifier":"stats-simple","values":{"heading":"Stats","description":null,"headerOrientation":"center","bgOption":"transparent","dark":false,"spacingHorizontal":null,"spacingVertical":"medium","stats":[{"stat":"current-user-count","heading":"Total active users"},{"stat":"current-character-count","heading":"Total active characters"},{"stat":"all-time-posts","heading":"All-time posts"},{"stat":"all-time-post-words","heading":"All-time post words"}]}}},{"type":"scribbleBlock","attrs":{"id":"96919305-58b0-4339-8652-b3f67679f2ae","type":"block","identifier":"cta-simple","values":{"heading":"Join today","description":"Proident labore reprehenderit et ea eu. Minim amet enim ad. Quis cillum ullamco ullamco incididunt. Mollit officia do dolor exercitation mollit reprehenderit incididunt reprehenderit labore. Irure sunt laboris adipisicing veniam irure dolore quis pariatur est ullamco duis cillum. Consectetur fugiat in exercitation adipisicing cupidatat deserunt.","headerOrientation":"center","primaryButtonLabel":"Join","primaryButtonUrl":"https:\/\/nova3.test\/join","primaryButtonBgColor":"#ffffff","primaryButtonTextColor":"#000000","secondaryButtonLabel":null,"secondaryButtonUrl":null,"bgOption":"mesh-dark-003","bgImageIntensity":"intense","dark":true,"spacingHorizontal":null,"spacingVertical":"medium","card":false}}}]}',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Characters',
                'uri' => 'characters',
                'key' => 'public.characters',
                'layout' => 'public',
                'blocks' => '{"type":"doc","content":[{"type":"scribbleBlock","attrs":{"id":"b98eacc0-199f-48f7-a0a6-95dcbe887a01","type":"block","identifier":"manifest","values":{"heading":"Characters","description":null,"headerOrientation":"left","bgOption":"transparent","dark":false,"spacingHorizontal":null,"spacingVertical":"none","layout":"cards","characterOptions":["avatar","position","rank-name","rank-image"],"cardOrientation":"center","showDepartments":false,"showAvailablePositions":false,"showCharacters":true,"characterStatus":"active","characterType":"primary-secondary"}}}]}',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stories',
                'uri' => 'stories',
                'key' => 'public.stories',
                'layout' => 'public',
                'blocks' => '{"type":"doc","content":[{"type":"scribbleBlock","attrs":{"id":"edf32b82-0680-4476-8480-d859c06db467","type":"block","identifier":"stories-timeline-block","values":{"heading":"Stories","description":null,"headerOrientation":"left","bgOption":"transparent","dark":false,"spacingHorizontal":null,"spacingVertical":"none","timelineSorting":"asc"}}}]}',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($basicPages as $page) {
            DB::table('pages')->insert($page);

            PublishPage::run(Page::key($page['key'])->first());
        }

        $advancedPages = [
            [
                'name' => 'Join page',
                'uri' => 'join/{position?}',
                'key' => 'public.join',
                'resource' => 'Nova\\PublicSite\\Controllers\\ShowJoinFormController',
                'layout' => 'public',
                'seo_title' => 'Join the game',
                'content_can_be_edited' => true,
                'heading' => 'Join',
            ],
            [
                'name' => 'Process join form',
                'uri' => 'join',
                'key' => 'public.join.process',
                'resource' => 'Nova\\PublicSite\\Controllers\\ProcessJoinFormController',
                'layout' => 'public',
                'middleware' => ['throttle:join'],
                'verb' => PageVerb::post,
            ],
            [
                'name' => 'Contact page',
                'uri' => 'contact',
                'key' => 'public.contact',
                'resource' => 'Nova\\PublicSite\\Controllers\\ShowContactFormController',
                'layout' => 'public',
                'seo_title' => 'Contact us',
                'content_can_be_edited' => true,
                'heading' => 'Contact us',
            ],
            [
                'name' => 'Process contact form',
                'uri' => 'contact',
                'key' => 'public.contact.process',
                'resource' => 'Nova\\PublicSite\\Controllers\\ProcessContactFormController',
                'layout' => 'public',
                'middleware' => ['throttle:contact'],
                'verb' => PageVerb::post,
            ],
            [
                'name' => 'View character bio',
                'uri' => 'character/{character}',
                'key' => 'public.character-bio',
                'resource' => 'Nova\\PublicSite\\Controllers\\ShowCharacterBioController',
                'layout' => 'public',
            ],
            [
                'name' => 'View story',
                'uri' => 'story/{story}',
                'key' => 'public.story',
                'resource' => 'Nova\\PublicSite\\Controllers\\ShowStoryController',
                'layout' => 'public',
            ],
            [
                'name' => 'View story post',
                'uri' => 'story/{story}/post/{post}',
                'key' => 'public.story-post',
                'resource' => 'Nova\\PublicSite\\Controllers\\ShowStoryPostController',
                'layout' => 'public',
            ],
        ];

        Page::unguarded(fn () => collect($advancedPages)->each([Page::class, 'create']));
    }
}
