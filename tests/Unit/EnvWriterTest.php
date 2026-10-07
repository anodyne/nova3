<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Illuminate\Support\Facades\File;
use Nova\Foundation\EnvWriter;

beforeEach(function () {
    $this->originalEnvironmentPath = app()->environmentPath();
    $this->temporaryDirectory = sys_get_temp_dir().'/nova-env-writer-'.bin2hex(random_bytes(12));
    File::makeDirectory($this->temporaryDirectory);
    app()->useEnvironmentPath($this->temporaryDirectory);

    $this->testEnvPath = $this->temporaryDirectory.'/.env.writer-testing';
    File::put($this->testEnvPath, "APP_ENV=local\n");
    $this->writer = new EnvWriter('.env.writer-testing');
});

afterEach(function () {
    app()->useEnvironmentPath($this->originalEnvironmentPath);
    File::deleteDirectory($this->temporaryDirectory);
});

it('correctly formats boolean values', function () {
    $this->writer->set('APP_DEBUG', true);
    $this->writer->set('FEATURE_FLAG', false);

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('APP_DEBUG=true');
    expect($envContents)->toContain('FEATURE_FLAG=false');
});

it('correctly formats integer values', function () {
    $this->writer->set('APP_PORT', 8080);
    $this->writer->set('CACHE_TTL', 3600);

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('APP_PORT=8080');
    expect($envContents)->toContain('CACHE_TTL=3600');
});

it('correctly formats strings without unnecessary quotes', function () {
    $this->writer->set('APP_ENV', 'production');
    $this->writer->set('LOG_LEVEL', 'debug');
    $this->writer->set('SIMPLE_VALUE', 'HelloWorld');
    $this->writer->set('SECRET_KEY', 'sk_test_123456');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('APP_ENV=production');
    expect($envContents)->toContain('LOG_LEVEL=debug');
    expect($envContents)->toContain('SIMPLE_VALUE=HelloWorld');
    expect($envContents)->toContain('SECRET_KEY="sk_test_123456"');
});

it('correctly quotes strings with spaces or special characters', function () {
    $this->writer->set('APP_NAME', 'My Awesome App');
    $this->writer->set('GREETING', 'Hello, World!');
    $this->writer->set('PASSWORD_1', 'abc#123');
    $this->writer->set('PASSWORD_2', 'abc@123');
    $this->writer->set('PASSWORD_3', 'abc!123');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('APP_NAME="My Awesome App"');
    expect($envContents)->toContain('GREETING="Hello, World!"');
    expect($envContents)->toContain('PASSWORD_1="abc#123"');
    expect($envContents)->toContain('PASSWORD_2="abc@123"');
    expect($envContents)->toContain('PASSWORD_3="abc!123"');
});

it('correctly handles IP addresses and URLs', function () {
    $this->writer->set('SERVER_IP', '192.168.1.1');
    $this->writer->set('DATABASE_URL_1', 'mysql://user:password@127.0.0.1:3306/db');
    $this->writer->set('DATABASE_URL_2', 'mysql=user:password@host/db');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('SERVER_IP="192.168.1.1"');
    expect($envContents)->toContain('DATABASE_URL_1="mysql://user:password@127.0.0.1:3306/db"');
    expect($envContents)->toContain('DATABASE_URL_2="mysql=user:password@host/db"');
});

it('correctly handles base64 strings', function () {
    $this->writer->set('ENCODED_STRING_1', 'base64:4JX3j5dB+wZG6F0fgxV2dQ==');
    $this->writer->set('ENCODED_STRING_2', 'base64:Xv2Gj#jk9OQ==');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('ENCODED_STRING_1="base64:4JX3j5dB+wZG6F0fgxV2dQ=="');
    expect($envContents)->toContain('ENCODED_STRING_2="base64:Xv2Gj#jk9OQ=="');
});

it('updates existing values instead of duplicating', function () {
    // Initial value in .env file: APP_ENV=local
    $this->writer->set('APP_ENV', 'staging');

    $envContents = File::get($this->testEnvPath);

    // Ensure the old value is replaced
    expect($envContents)->toContain('APP_ENV=staging');
    expect(substr_count($envContents, 'APP_ENV'))->toBe(1);
});

it('appends new keys if not present', function () {
    $this->writer->set('NEW_KEY', 'new_value');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('NEW_KEY="new_value"');
});

it('writes multiple values with explicit boolean and empty values', function () {
    expect($this->writer->set([
        'APP_ENV' => 'production',
        'APP_DEBUG' => false,
        'EMPTY_VALUE' => null,
        'ENABLED' => true,
    ]))->toBeTrue();

    expect(Dotenv::parse(File::get($this->testEnvPath)))->toBe([
        'APP_ENV' => 'production',
        'APP_DEBUG' => 'false',
        'EMPTY_VALUE' => '',
        'ENABLED' => 'true',
    ]);
});

it('preserves literal replacement sequences and backslashes', function () {
    File::put($this->testEnvPath, "PASSWORD=old\n");
    $password = 'secret$1\\folder';

    expect($this->writer->set('PASSWORD', $password))->toBeTrue();
    expect(Dotenv::parse(File::get($this->testEnvPath))['PASSWORD'])->toBe($password);
});

it('uses fresh contents after another writer changes the file', function () {
    $otherWriter = new EnvWriter('.env.writer-testing');
    $otherWriter->set('OTHER_KEY', 'preserved');

    $this->writer->set('APP_ENV', 'production');

    expect(Dotenv::parse(File::get($this->testEnvPath)))->toBe([
        'APP_ENV' => 'production',
        'OTHER_KEY' => 'preserved',
    ]);
});

it('switches files without copying contents from the previous file', function () {
    $otherPath = $this->temporaryDirectory.'/.env.other';
    File::put($otherPath, "OTHER_KEY=preserved\n");

    expect($this->writer->setEnvFile('.env.other')->set('NEW_KEY', 'added'))->toBeTrue();

    expect(Dotenv::parse(File::get($otherPath)))->toBe([
        'OTHER_KEY' => 'preserved',
        'NEW_KEY' => 'added',
    ]);
    expect(File::get($this->testEnvPath))->toBe("APP_ENV=local\n");
});

it('creates missing files from the Nova template in the isolated environment path', function () {
    $writer = new EnvWriter;

    expect($writer->envFilePath())->toBe($this->temporaryDirectory.'/.env');
    expect($writer->isEnvWritable())->toBeTrue();
    expect(File::get($writer->envFilePath()))->toBe(File::get(nova_path('.env.example')));
    expect($writer->set('APP_ENV', 'production'))->toBeTrue();
    expect(Dotenv::parse(File::get($writer->envFilePath()))['APP_ENV'])->toBe('production');
});

it('returns false without writing when the destination is a directory', function () {
    File::makeDirectory($this->temporaryDirectory.'/.env.directory');
    $writer = new EnvWriter('.env.directory');

    expect($writer->isEnvWritable())->toBeFalse();
    expect($writer->set('APP_ENV', 'production'))->toBeFalse();
    expect(File::get($this->testEnvPath))->toBe("APP_ENV=local\n");
});

it('returns false when a missing file cannot be created', function () {
    $writer = new EnvWriter('missing-directory/.env');

    expect($writer->isEnvWritable())->toBeFalse();
    expect($writer->set('APP_ENV', 'production'))->toBeFalse();
    expect(File::exists($this->temporaryDirectory.'/missing-directory'))->toBeFalse();
});

it('returns false for a read-only file without changing its contents', function () {
    chmod($this->testEnvPath, 0444);
    clearstatcache();

    try {
        expect($this->writer->set('APP_ENV', 'production'))->toBeFalse();
        expect(File::get($this->testEnvPath))->toBe("APP_ENV=local\n");
    } finally {
        chmod($this->testEnvPath, 0644);
    }
});

it('returns false and restores the error handler when writing fails after the writable check', function () {
    File::makeDirectory($this->temporaryDirectory.'/.env.failed');
    $writer = new class('.env.failed') extends EnvWriter
    {
        public function isEnvWritable(): bool
        {
            return true;
        }
    };
    $handler = static fn (): bool => false;
    set_error_handler($handler);

    try {
        expect($writer->set('APP_ENV', 'production'))->toBeFalse();
        $previousHandler = set_error_handler($handler);
        restore_error_handler();
        expect($previousHandler)->toBe($handler);
    } finally {
        restore_error_handler();
    }
});
