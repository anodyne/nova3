<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityLogList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('log_name')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'impersonation' => 'info',
                        'admin' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('event')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'deleted' => 'danger',
                        'updated' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('subject_type')
                    ->label('Subject')
                    ->formatStateUsing(function ($state, Model $record) {
                        if (! $state) {
                            return '-';
                        }

                        return str($state)->headline().' #'.$record->subject_id;
                    })
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('created_at')
                    ->label('Logged')
                    ->since()
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                Action::make('view')
                    ->icon(iconName('arrow-right'))
                    ->iconButton()
                    ->color('gray')
                    ->size('md')
                    ->url(fn (Model $record): string => route('activity-log.show', $record)),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->options(fn () => Activity::groupBy('log_name')->orderBy('log_name')->pluck('log_name'))
                    ->multiple()
                    ->label('Type'),
                SelectFilter::make('causer_id')
                    ->options(fn () => User::pluck('name', 'id'))
                    ->multiple()
                    ->searchable()
                    ->label('User'),
                SelectFilter::make('subject_type')
                    ->options(fn () => Activity::whereNotNull('subject_type')->groupBy('subject_type')->orderBy('subject_type')->pluck('subject_type'))
                    ->multiple()
                    ->searchable()
                    ->label('Subject'),
                SelectFilter::make('event')
                    ->options(fn () => Activity::whereNotNull('event')->groupBy('event')->orderBy('event')->pluck('event'))
                    ->multiple()
                    ->searchable(),
            ])
            ->heading('Activity log')
            ->description('Track all user activity in Nova');
    }
}
