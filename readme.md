# Nova 3

[![Actions Status](https://img.shields.io/badge/Tests-passing-green?logo=github)](https://github.com/anodyne/nova3/actions)
[![Laravel](https://img.shields.io/badge/Laravel-v11.x-FF2D20?logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-v3.x-FB70A9)](https://livewire.laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)](https://php.net)

## Installation

```bash
cp .env.example .env
```

Start by updating the `.env` file with the correct database credentials. At a minimum, you'll need to update the `DB_CONNECTION`, `DB_USER`, and `DB_PASSWORD` items. **This step must be done first!**

Next, run the following sets of commands:

```bash
composer install

php artisan key:generate --ansi
php artisan migrate:fresh --seed

npm ci && npm dev
```

## Staying In Sync

```bash
git pull origin dev

composer install

npm ci && npm dev

php artisan migrate:refresh --seed
```
