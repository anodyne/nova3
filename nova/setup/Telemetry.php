<?php

declare(strict_types=1);

namespace Nova\Setup;

use Illuminate\Support\Facades\Http;
use Nova\Addons\Models\Addon;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class Telemetry
{
    protected SystemInfo $systemInfo;

    public function __construct()
    {
        $this->systemInfo = SystemInfo::first();
    }

    public function sendSimpleHeartbeat(): void
    {
        $this->send($this->gatherSimpleHeartbeatData());
    }

    public function sendFullHeartbeat(): void
    {
        $this->send($this->gatherFullHeartbeatData());
    }

    public function gatherSimpleHeartbeatData(): array
    {
        return [
            ...$this->gameInfo(),
            ...$this->stats(),
        ];
    }

    public function gatherFullHeartbeatData(): array
    {
        $data = [
            ...$this->gameInfo(),
            ...$this->stats(),
            ...$this->serverInfo(),
        ];

        if (filled($this->systemInfo->anodyne_game_id)) {
            $data['game_id'] = $this->systemInfo->anodyne_game_id;
        }

        return $data;
    }

    public function gameInfo(): array
    {
        return [
            'name' => settings('general.gameName'),
            'url' => url('/'),
            'version' => Nova::filesVersion(),
            'genre' => Addon::active()->genre()->first()->location ?? 'blank',
            'install_date' => $this->systemInfo->install_date?->format('Y-m-d h:i:s'),
        ];
    }

    public function serverInfo(): array
    {
        $environment = Nova::environment();

        return [
            'php_version' => $environment->php->version,
            'db_driver' => $environment->database->driver,
            'db_version' => $environment->database->version,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'previous_version' => $this->systemInfo->version,
        ];
    }

    public function stats(): array
    {
        return [
            'active_users' => User::active()->count(),
            'active_primary_characters' => Character::active()->primary()->count(),
            'active_secondary_characters' => Character::active()->secondary()->count(),
            'active_support_characters' => Character::active()->support()->count(),
            'total_stories' => Story::count(),
            'total_posts' => Post::published()->count(),
            'total_post_words' => (int) Post::published()->sum('word_count'),
            'last_published_post' => Post::latest('published_at')->first()?->published_at?->format('Y-m-d h:i:s'),
        ];
    }

    protected function send(array $data): void
    {
        $response = Http::post(config('services.anodyne.api.register'), $data);

        $this->systemInfo->update(['anodyne_game_id' => $response->json('game_id')]);
    }
}
