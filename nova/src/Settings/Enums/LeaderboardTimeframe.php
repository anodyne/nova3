<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Nova\Stories\Models\Post;

enum LeaderboardTimeframe: string implements HasLabel
{
    case AllTime = 'all-time';
    case Days14 = '14-days';
    case Days30 = '30-days';
    case Days7 = '7-days';
    case LastMonth = 'last-month';
    case LastYear = 'last-year';
    case ThisMonth = 'this-month';
    case ThisYear = 'this-year';

    public function getLabel(): string
    {
        return match ($this) {
            self::AllTime => 'All-Time',
            self::ThisYear => 'This year',
            self::LastYear => 'Last year',
            self::ThisMonth => 'This month',
            self::LastMonth => 'Last month',
            self::Days7 => 'Last 7 days',
            self::Days14 => 'Last 14 days',
            self::Days30 => 'Last 30 days',
        };
    }

    public function query(Builder $query): Builder
    {
        return match ($this) {
            self::ThisYear => $query->where(Post::column('updated_at'), '>=', Date::now()->startOfYear()),
            self::LastYear => $query->where(fn (Builder $q): Builder => $q->where(Post::column('updated_at'), '>=', Date::now()->subYear()->startOfYear())
                ->where(Post::column('updated_at'), '<=', Date::now()->subYear()->endOfYear())),
            self::ThisMonth => $query->where(Post::column('updated_at'), '>=', Date::now()->startOfMonth()),
            self::LastMonth => $query->where(fn (Builder $q): Builder => $q->where(Post::column('updated_at'), '>=', Date::now()->subMonth()->startOfMonth())
                ->where(Post::column('updated_at'), '<=', Date::now()->subMonth()->endOfMonth())),
            self::Days7 => $query->where(Post::column('updated_at'), '>=', Date::now()->subDays(7)->startOfDay()),
            self::Days14 => $query->where(Post::column('updated_at'), '>=', Date::now()->subDays(14)->startOfDay()),
            self::Days30 => $query->where(Post::column('updated_at'), '>=', Date::now()->subDays(30)->startOfDay()),
            default => $query,
        };
    }
}
