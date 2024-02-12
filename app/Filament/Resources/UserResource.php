<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Name')
                            ->placeholder('Enter name')
                            ->inlineLabel(),
                        TextInput::make('email')
                            ->required()
                            ->label('Email')
                            ->placeholder('Enter email')
                            ->unique()
                            ->inlineLabel(),
                        TextInput::make('username')
                            ->required()
                            ->label('Username')
                            ->placeholder('Enter username')
                            ->unique()
                            ->inlineLabel(),
                        Radio::make('type')
                            ->label('User Type')
                            ->inline()
                            ->inlineLabel()
                            ->default(UserType::USER())
                            ->options(UserType::get()),
                        TextInput::make('password')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->label('Password')
                            ->placeholder('Enter password')
                            ->inlineLabel()
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_suspended')
                    ->boolean(),
                TextColumn::make('suspendedBy.name'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Action::make('suspend')
                    ->label('')
                    ->size('md')
                    ->tooltip('Suspend')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-lock-closed')
                    ->modalHeading('Are you sure ?')
                    ->hidden(fn (User $user) => $user->isSuspended())
                    ->action(fn (User $user) => $user->makeSuspend(true)),
                Action::make('unsuspend')
                    ->label('')
                    ->size('md')
                    ->tooltip('Unsuspend')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-lock-open')
                    ->modalHeading('Are you sure ?')
                    ->action(fn (User $user) => $user->makeSuspend(false))
                    ->visible(fn (User $user) => $user->isSuspended()),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->size('md')
                    ->tooltip('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
