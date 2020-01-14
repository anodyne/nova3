# Nova NextGen

[![Actions Status](https://github.com/anodyne/nova3/workflows/CI/badge.svg)](https://github.com/anodyne/nova3/actions)

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

yarn install && yarn dev
```

*Note:* You should be able to use `npm` in place of `yarn`.

## Staying In Sync

```bash
git pull origin dev

composer dump
composer install

yarn install && yarn dev

php artisan nova:refresh
```
