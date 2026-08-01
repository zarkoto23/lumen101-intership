<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Lesson;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;


class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;


    protected static ?string $navigationIcon = 'heroicon-o-play';


    protected static ?string $navigationGroup = 'Academy Management';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('course_section_id')
                    ->label('Section')
                    ->relationship(
                        'section',
                        'title'
                    )
                    ->required(),



                Forms\Components\TextInput::make('title')
                    ->required(),



                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),



                Forms\Components\TextInput::make('video_url')
                    ->url(),



                Forms\Components\FileUpload::make('file_path'),



                Forms\Components\TextInput::make('duration_minutes')
                    ->numeric()
                    ->minValue(1),



                Forms\Components\TextInput::make('position')
                    ->numeric()
                    ->required(),



                Forms\Components\Toggle::make('is_preview')
                    ->default(false),

            ]);
    }





    public static function table(Table $table): Table
    {
        return $table

            ->columns([


                Tables\Columns\TextColumn::make('section.title')
                    ->label('Section'),



                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),



                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Minutes'),



                Tables\Columns\TextColumn::make('position')
                    ->sortable(),



                Tables\Columns\IconColumn::make('is_preview')
                    ->boolean(),


            ])

            ->filters([

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

            'index' => Pages\ListLessons::route('/'),

            'create' => Pages\CreateLesson::route('/create'),

            'edit' => Pages\EditLesson::route('/{record}/edit'),

        ];
    }
}