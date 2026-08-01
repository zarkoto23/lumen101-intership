<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;


class UserResource extends Resource
{
    protected static ?string $model = User::class;


    protected static ?string $navigationIcon = 'heroicon-o-users';


    protected static ?string $navigationGroup = 'Academy Management';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\TextInput::make('name')
                    ->required(),



                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),



                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(
                        fn ($state) => filled($state)
                    ),



                Forms\Components\Select::make('role')
                    ->options([

                        'admin' => 'Admin',

                        'instructor' => 'Instructor',

                        'student' => 'Student',

                    ])
                    ->required(),



                Forms\Components\TextInput::make('phone'),



                Forms\Components\FileUpload::make('profile_image')
                    ->image(),



                Forms\Components\Toggle::make('is_active')
                    ->default(true),

            ]);
    }





    public static function table(Table $table): Table
    {
        return $table

            ->columns([


                Tables\Columns\ImageColumn::make('profile_image'),



                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),



                Tables\Columns\TextColumn::make('email')
                    ->searchable(),



                Tables\Columns\TextColumn::make('role')
                    ->badge(),



                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),



                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])

            ->filters([


                Tables\Filters\SelectFilter::make('role')
                    ->options([

                        'admin' => 'Admin',

                        'instructor' => 'Instructor',

                        'student' => 'Student',

                    ]),


            ])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ])

            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([

                    Tables\Actions\DeleteBulkAction::make(),

                ]),

            ]);
    }





    public static function getPages(): array
    {
        return [

            'index' => Pages\ListUsers::route('/'),

            'create' => Pages\CreateUser::route('/create'),

            'edit' => Pages\EditUser::route('/{record}/edit'),

        ];
    }

    public static function canAccess(): bool
{
    return auth()->user()?->isAdmin();
}
}