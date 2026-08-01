<?php

namespace App\Filament\Resources\CourseSectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';



    public function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\TextInput::make('title')
                    ->required(),


                Forms\Components\Textarea::make('description'),


                Forms\Components\TextInput::make('video_url')
                    ->url(),


                Forms\Components\FileUpload::make('file_path'),


                Forms\Components\TextInput::make('duration_minutes')
                    ->numeric(),


                Forms\Components\TextInput::make('position')
                    ->numeric()
                    ->required(),


                Forms\Components\Toggle::make('is_preview'),

            ]);
    }



    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('position')
            ->columns([


                Tables\Columns\TextColumn::make('title'),


                Tables\Columns\TextColumn::make('position'),


                Tables\Columns\IconColumn::make('is_preview')
                    ->boolean(),

            ])
            ->headerActions([

                Tables\Actions\CreateAction::make(),

            ])
            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);
    }
}