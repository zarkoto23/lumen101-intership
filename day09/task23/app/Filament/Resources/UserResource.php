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

        return $form->schema([




            Forms\Components\TextInput::make('name')

                ->required(),




            Forms\Components\TextInput::make('email')

                ->email()

                ->required(),




            Forms\Components\TextInput::make('password')

                ->password()

                ->dehydrated(
                    fn($state)=>filled($state)
                ),





            Forms\Components\Select::make('role')

                ->options([

                    'admin'=>'Admin',

                    'instructor'=>'Instructor',

                    'student'=>'Student',

                ])

                ->required(),





            Forms\Components\TextInput::make('phone'),





            Forms\Components\Toggle::make('is_active'),

        ]);

    }






    public static function table(Table $table): Table
    {

        return $table

            ->columns([



                Tables\Columns\TextColumn::make('name')

                    ->searchable(),




                Tables\Columns\TextColumn::make('email')

                    ->searchable(),




                Tables\Columns\TextColumn::make('role')

                    ->badge(),




                Tables\Columns\IconColumn::make('is_active')

                    ->boolean(),



            ])





            ->filters([


                Tables\Filters\SelectFilter::make('role')

                    ->options([

                        'admin'=>'Admin',

                        'instructor'=>'Instructor',

                        'student'=>'Student',

                    ]),


            ])





            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);

    }





    public static function getPages(): array
    {

        return [

            'index'=>Pages\ListUsers::route('/'),

            'create'=>Pages\CreateUser::route('/create'),

            'edit'=>Pages\EditUser::route('/{record}/edit'),

        ];

    }

}