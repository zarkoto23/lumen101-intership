<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Tables;
use Filament\Tables\Table;


class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';



    public function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Select::make('student_id')
                    ->relationship(
                        'student',
                        'name'
                    )
                    ->required(),



                Forms\Components\Select::make('status')
                    ->options([

                        'pending' => 'Pending',

                        'active' => 'Active',

                        'completed' => 'Completed',

                        'cancelled' => 'Cancelled',

                    ])
                    ->required(),



                Forms\Components\DateTimePicker::make('enrolled_at'),



                Forms\Components\TextInput::make('final_grade')
                    ->numeric(),

            ]);
    }




    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('student.name')


            ->columns([


                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable(),



                Tables\Columns\TextColumn::make('status')
                    ->badge(),



                Tables\Columns\TextColumn::make('final_grade'),



                Tables\Columns\TextColumn::make('enrolled_at')
                    ->dateTime(),


            ])



            ->filters([

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