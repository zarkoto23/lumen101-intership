<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables;
use Filament\Tables\Table;


class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';



    public function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\TextInput::make('title')
                    ->required(),



                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),



                Forms\Components\DateTimePicker::make('deadline'),



                Forms\Components\TextInput::make('maximum_points')
                    ->numeric()
                    ->default(100),



                Forms\Components\Toggle::make('is_required')
                    ->default(true),

            ]);
    }





    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('title')

            ->columns([


                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),



                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime(),



                Tables\Columns\TextColumn::make('maximum_points'),



                Tables\Columns\IconColumn::make('is_required')
                    ->boolean(),

            ])



            ->headerActions([


                Tables\Actions\CreateAction::make(),


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
}