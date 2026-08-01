<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;


class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;


    protected static ?string $navigationIcon = 'heroicon-o-user-plus';


    protected static ?string $navigationGroup = 'Academy Management';



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



                Forms\Components\DateTimePicker::make('completed_at'),



                Forms\Components\TextInput::make('final_grade')
                    ->numeric(),

            ]);
    }





    public static function table(Table $table): Table
    {
        return $table

            ->columns([


                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable(),



                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course'),



                Tables\Columns\TextColumn::make('status')
                    ->badge(),



                Tables\Columns\TextColumn::make('final_grade'),



                Tables\Columns\TextColumn::make('enrolled_at')
                    ->dateTime(),

            ])



            ->filters([


                Tables\Filters\SelectFilter::make('status')
                    ->options([

                        'pending' => 'Pending',

                        'active' => 'Active',

                        'completed' => 'Completed',

                        'cancelled' => 'Cancelled',

                    ]),


            ])

            ->headerActions([

    Tables\Actions\CreateAction::make(),

])

            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);
    }





    public static function getPages(): array
    {
        return [

            'index' => Pages\ListEnrollments::route('/'),

            'create' => Pages\CreateEnrollment::route('/create'),

            'edit' => Pages\EditEnrollment::route('/{record}/edit'),

        ];
    }
    public static function canAccess(): bool
{
    return auth()->user()?->isAdmin();
}
}