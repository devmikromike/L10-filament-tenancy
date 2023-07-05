<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use Illuminate\Database\Eloquent\Factories\Relationship;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Admin Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Käyttäjän nimi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('admin oikeudet')
                    ->required(),
                Forms\Components\TextInput::make('sähköpostiosoite')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static fn(null|string $state):
                     null|string =>
                     filled($state) ? Hash::make($state): null,
                     )->required(static fn(Page $livewire): string=>
                     $livewire instanceof CreateUser
                     )->dehydrated(static fn(null|string $state): bool=>
                     filled($state),
                    )->label(static fn(Page $livewire): string =>
                     ($livewire instanceof EditUser) ? 'Uusi salasana' : 'Salasana'),

                CheckboxList::make('roles')
                ->Relationship('roles','name')
                ->columns(2)
                ->helperText('valitse vain yksi rooli')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->sortable()
                    ->searchable(),
                    Tables\Columns\TextColumn::make('roles.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime('d-M-Y')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('d-M-Y')
                    ->sortable()->searchable(),

            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
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
}
