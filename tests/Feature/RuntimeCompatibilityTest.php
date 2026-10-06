<?php

declare(strict_types=1);

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Responses\Responsable;
use Nova\Foundation\Support\IdeHelper\BagCastModelHook;
use Nova\Setup\Actions\Migration\MigrateUser;
use Nova\Setup\Livewire\Migrations\MigrateUsers;
use Nova\Setup\Telemetry;
use Nova\Themes\BaseTheme;
use Nova\Themes\Concerns\RendersTheme;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserModerations;
use Nova\Users\Data\UserPreferences;
use Nova\Users\Models\User;

it('resolves dynamic theme views and passes their data through', function () {
    $theme = new class
    {
        use RendersTheme;
    };
    $theme->structure = new Fluent;

    $theme->layout('compatibility', ['message' => 'Layout'])
        ->template('compatibility', ['message' => 'Template'])
        ->page('compatibility', ['message' => 'Page']);

    expect($theme->structure->layout->render())->toBe("Layout\n");
    expect($theme->structure->layout->template->render())->toBe("Template\n");
    expect($theme->structure->layout->template->content->render())->toBe("Page\n");
});

it('rejects missing dynamic theme views', function (string $method) {
    $theme = new class
    {
        use RendersTheme;
    };
    $theme->structure = new Fluent;
    $theme->layout('compatibility')->template('compatibility');

    expect(fn () => $theme->{$method}('missing-compatibility-view'))
        ->toThrow(InvalidArgumentException::class);
})->with(['layout', 'template', 'page']);

it('renders a dynamic response view with merged response and theme data', function () {
    app()->instance('nova.theme', new class extends BaseTheme
    {
        public function prepareData(): array
        {
            return ['themeValue' => 'Theme data'];
        }
    });
    $response = new class(null) extends Responsable
    {
        public string $view = 'compatibility';

        protected function setSEOValues(): void {}
    };
    $response->with('message', 'Response');

    $view = $response->render();

    expect($view->render())->toBe("Response\n");
    expect($view->getData()['themeValue'])->toBe('Theme data');
    expect($view->getData()['meta'])->toBe(app('nova.meta'));
});

it('generates IDE properties for bag casts while ignoring ordinary casts', function () {
    $user = User::factory()->create();
    $command = Mockery::mock(ModelsCommand::class);
    foreach ([
        'moderations' => UserModerations::class,
        'preferences' => UserPreferences::class,
        'pronouns' => PronounsData::class,
    ] as $attribute => $class) {
        $command->shouldReceive('setProperty')
            ->once()
            ->withArgs(fn (string $name, string $type): bool => $name === $attribute && $type === '\\'.$class);
    }

    (new BagCastModelHook)->run($command, $user);
});

it('builds batch jobs for legacy user migration with the new action runner', function () {
    $this->app['config']->set('database.connections.nova2', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);
    $connection = DB::connection('nova2');
    $connection->statement('CREATE TABLE users (userid INTEGER PRIMARY KEY, name TEXT)');
    $connection->table('users')->insert(['userid' => 42, 'name' => 'Legacy user']);
    $step = new class extends MigrateUsers
    {
        public function jobs(): Collection
        {
            return $this->getBatchJobs();
        }
    };

    $jobs = $step->jobs();

    expect($jobs)->toHaveCount(1);
    expect($jobs->first())->toBeInstanceOf(JobDecorator::class);
    expect($jobs->first()->getAction())->toBeInstanceOf(MigrateUser::class);
    expect($jobs->first()->getParameters()[0]->userid)->toBe(42);
    DB::purge('nova2');
});

it('formats the nonnullable installation date for telemetry', function () {
    $systemInfo = SystemInfo::firstOrFail();
    $systemInfo->forceFill(['install_date' => '2026-01-02 03:04:05'])->save();

    $data = (new Telemetry)->gameInfo();

    expect($data['install_date'])->toBe('2026-01-02 03:04:05');
});

it('limits the local manifest positions list to active positions', function () {
    $department = Department::factory()->create();
    Position::factory()->active()->create(['department_id' => $department->id, 'name' => 'Active test position']);
    Position::factory()->inactive()->create(['department_id' => $department->id, 'name' => 'Inactive test position']);
    Route::prefix('compatibility')->group(nova_path('routes/local.php'));
    $route = Route::getRoutes()->match(Request::create('/compatibility/manifest-test'));

    ob_start();
    try {
        $result = $route->run();
        $output = ob_get_contents();
    } finally {
        ob_end_clean();
    }

    expect($result)->toBe('done');
    expect($output)->toContain('Active test position')->not->toContain('Inactive test position');
});
