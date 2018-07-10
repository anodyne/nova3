<?php

use Nova\Settings\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
			['key' => 'mail_default_address', 'value' => '', 'protected' => (int)true],
			['key' => 'mail_default_name', 'value' => '', 'protected' => (int)true],
			['key' => 'mail_subject_prefix', 'value' => '', 'protected' => (int)true],
			['key' => 'manifest_layout', 'value' => 'list', 'protected' => (int)true],
			['key' => 'manifest_show_assigned', 'value' => 'true', 'protected' => (int)true],
			['key' => 'manifest_show_available', 'value' => 'true', 'protected' => (int)true],
			['key' => 'manifest_show_inactive', 'value' => 'false', 'protected' => (int)true],
			['key' => 'manifest_show_npcs', 'value' => 'true', 'protected' => (int)true],
			['key' => 'rank', 'value' => 'duty', 'protected' => (int)true],
			['key' => 'theme', 'value' => 'pulsar', 'protected' => (int)true],
		];

		Model::unguard();

		Settings::insert($settings);

		Model::reguard();

		cache()->rememberForever('nova.settings', function () {
			return (object) Settings::get()->pluck('value', 'key')->all();
		});
    }
}
