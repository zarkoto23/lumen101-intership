<?php

namespace App\Filament\Resources;


use App\Filament\Resources\AssignmentResource\Pages;

use App\Models\Assignment;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;



class AssignmentResource extends Resource
{

    protected static ?string $model = Assignment::class;


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';


    protected static ?string $navigationGroup = 'Academy Management';




    public static function form(Form $form): Form
    {

        return $form->schema([



            Forms\Components\Select::make('course_id')

                ->relationship(
                    'course',
                    'title'
                )

                ->required(),





            Forms\Components\TextInput::make('title')

                ->required(),





            Forms\Components\Textarea::make('description'),





            Forms\Components\DateTimePicker::make('deadline'),





            Forms\Components\TextInput::make('maximum_points')

                ->numeric()

                ->required(),




            Forms\Components\FileUpload::make('attachment_path'),





            Forms\Components\Toggle::make('is_required'),



        ]);

    }






    public static function table(Table $table): Table
    {

        return $table

            ->columns([



                Tables\Columns\TextColumn::make('title')

                    ->searchable(),




                Tables\Columns\TextColumn::make('course.title')

                    ->label('Course'),




                Tables\Columns\TextColumn::make('deadline')

                    ->dateTime(),




                Tables\Columns\TextColumn::make('maximum_points'),



            ])




            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);

    }






    public static function getPages(): array
    {

        return [

            'index'=>Pages\ListAssignments::route('/'),

            'create'=>Pages\CreateAssignment::route('/create'),

            'edit'=>Pages\EditAssignment::route('/{record}/edit'),

        ];

    }


}