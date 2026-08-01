<?php

namespace App\Filament\Resources;

use App\Models\CourseSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\CourseSectionResource\Pages;
use App\Filament\Resources\CourseSectionResource\RelationManagers\LessonsRelationManager;


class CourseSectionResource extends Resource
{
    protected static ?string $model = CourseSection::class;


    protected static ?string $navigationGroup = 'Academy Management';


    protected static ?string $navigationIcon = 'heroicon-o-bars-3';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('course_id')
                    ->relationship(
                        'course',
                        'title'
                    )
                    ->required(),


                Forms\Components\TextInput::make('title')
                    ->required(),


                Forms\Components\TextInput::make('position')
                    ->numeric()
                    ->required(),

            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course'),


                Tables\Columns\TextColumn::make('title')
                    ->searchable(),


                Tables\Columns\TextColumn::make('position')
                    ->sortable(),

            ])
            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);
    }



public static function getRelations(): array
{
    return [
        LessonsRelationManager::class,
    ];
}


    public static function getPages(): array
    {
        return [

            'index'=>Pages\ListCourseSections::route('/'),

            'create'=>Pages\CreateCourseSection::route('/create'),

            'edit'=>Pages\EditCourseSection::route('/{record}/edit'),

        ];
    }
}