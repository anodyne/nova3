<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\EnvWriter;
use Nova\Foundation\Models\SystemInfo;
use Nova\Settings\Models\Settings;
use Nova\Setup\Livewire\Concerns\HandlesDates;

class MigrateGameSettings
{
    use AsAction;
    use HandlesDates;

    public function handle(): void
    {
        DB::transaction(function () {
            Settings::unguard();

            DB::connection('nova2')
                ->table('settings')
                ->whereIn('setting_key', [
                    'contact_form_enabled',
                    'email_subject',
                    'default_email_name',
                    'default_email_address',
                ])
                ->get()
                ->each(function ($setting) {
                    match ($setting->setting_key) {
                        'contact_form_enabled' => $this->updateContactFormEnabled($setting->setting_value),
                        'email_subject' => $this->updateEmailSubject($setting->setting_value),
                        'default_email_name' => $this->updateDefaultEmailName($setting->setting_value),
                        'default_email_address' => $this->updateDefaultEmailAddress($setting->setting_value),
                    };
                });

            $this->updateSystemInfo();

            Settings::reguard();
        });
    }

    public function asJob(): void
    {
        $this->handle();
    }

    protected function updateContactFormEnabled(string $value): void
    {
        settings()->update([
            'general->contactFormEnabled' => (bool) $value === 'y',
        ]);
    }

    protected function updateEmailSubject(string $value): void
    {
        settings()->update([
            'email->subjectPrefix' => $value,
        ]);
    }

    protected function updateDefaultEmailName(string $value): void
    {
        app(EnvWriter::class)->set('MAIL_FROM_NAME', $value);
    }

    protected function updateDefaultEmailAddress(string $value): void
    {
        app(EnvWriter::class)->set('MAIL_FROM_ADDRESS', $value);
    }

    protected function updateSystemInfo(): void
    {
        $systemInfo = DB::connection('nova2')
            ->table('system_info')
            ->where('sys_id', 1)
            ->first();

        SystemInfo::where('id', 1)->update([
            'anodyne_game_id' => $systemInfo->sys_anodyne_game_id,
            'install_date' => $this->convertDate($systemInfo->sys_install_date, now('UTC')),
            'last_update' => now('UTC'),
        ]);
    }
}
