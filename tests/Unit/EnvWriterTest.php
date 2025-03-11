<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Nova\Foundation\EnvWriter;

beforeEach(function () {
    // Define a test environment file path
    $this->testEnvPath = base_path('.env.writer-testing');

    // Ensure we start with a clean environment file
    File::put($this->testEnvPath, "APP_ENV=local\n");

    // Create an instance of EnvWriter using the test file path
    $this->writer = new EnvWriter('.env.writer-testing');
});

afterEach(function () {
    // Clean up test environment file
    File::delete($this->testEnvPath);
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
    expect($envContents)->toContain('SECRET_KEY=sk_test_123456');
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

    expect($envContents)->toContain('SERVER_IP=192.168.1.1');
    expect($envContents)->toContain('DATABASE_URL_1=mysql://user:password@127.0.0.1:3306/db');
    expect($envContents)->toContain('DATABASE_URL_2="mysql=user:password@host/db"');
});

it('correctly handles base64 strings', function () {
    $this->writer->set('ENCODED_STRING_1', 'base64:4JX3j5dB+wZG6F0fgxV2dQ==');
    $this->writer->set('ENCODED_STRING_2', 'base64:Xv2Gj#jk9OQ==');

    $envContents = File::get($this->testEnvPath);

    expect($envContents)->toContain('ENCODED_STRING_1=base64:4JX3j5dB+wZG6F0fgxV2dQ==');
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

    expect($envContents)->toContain('NEW_KEY=new_value');
});
