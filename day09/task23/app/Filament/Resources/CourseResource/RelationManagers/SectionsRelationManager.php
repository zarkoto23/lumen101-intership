<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables;
use Filament\Tables\Table;


class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';



    public function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\TextInput::make('title')
                    ->required(),



                Forms\Components\TextInput::make('position')
                    ->numeric()
                    ->required()
                    ->default(1),

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



                Tables\Columns\TextColumn::make('position')
                    ->sortable(),


            ])



            ->defaultSort(
                'position'
            )



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