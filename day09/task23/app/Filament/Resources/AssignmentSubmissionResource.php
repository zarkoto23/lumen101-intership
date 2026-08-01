<?php

namespace App\Filament\Resources;


use App\Filament\Resources\AssignmentSubmissionResource\Pages;

use App\Models\AssignmentSubmission;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;



class AssignmentSubmissionResource extends Resource
{

    protected static ?string $model = AssignmentSubmission::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-check';


    protected static ?string $navigationGroup = 'Academy Management';




    public static function form(Form $form): Form
    {

        return $form->schema([



            Forms\Components\Select::make('assignment_id')

                ->relationship(
                    'assignment',
                    'title'
                )

                ->required(),





            Forms\Components\Select::make('student_id')

                ->relationship(
                    'student',
                    'name'
                )

                ->required(),





            Forms\Components\FileUpload::make('file_path'),





            Forms\Components\Textarea::make('comment'),




            Forms\Components\Select::make('status')

                ->options([

                    'submitted'=>'Submitted',

                    'late'=>'Late',

                    'reviewed'=>'Reviewed',

                    'returned'=>'Returned',

                ])

                ->required(),




            Forms\Components\TextInput::make('points')

                ->numeric(),





            Forms\Components\Textarea::make('instructor_feedback'),




            Forms\Components\DateTimePicker::make('graded_at'),



        ]);

    }






    public static function table(Table $table): Table
    {

        return $table

            ->columns([



                Tables\Columns\TextColumn::make('assignment.title')

                    ->label('Assignment'),




                Tables\Columns\TextColumn::make('student.name')

                    ->label('Student'),




                Tables\Columns\TextColumn::make('status')

                    ->badge(),




                Tables\Columns\TextColumn::make('points'),




                Tables\Columns\TextColumn::make('graded_at')

                    ->dateTime(),



            ])




            ->filters([


                Tables\Filters\SelectFilter::make('status')

                    ->options([

                        'submitted'=>'Submitted',

                        'late'=>'Late',

                        'reviewed'=>'Reviewed',

                        'returned'=>'Returned',

                    ]),


            ])





            ->actions([

                Tables\Actions\EditAction::make(),

            ]);

    }





    public static function getPages(): array
    {

        return [

            'index'=>Pages\ListAssignmentSubmissions::route('/'),

            'create'=>Pages\CreateAssignmentSubmission::route('/create'),

            'edit'=>Pages\EditAssignmentSubmission::route('/{record}/edit'),

        ];

    }

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();


    if (
        auth()->check()
        &&
        auth()->user()->isInstructor()
    ) {

        $query->whereHas(
            'assignment.course',
            function (Builder $query) {

                $query->where(
                    'instructor_id',
                    auth()->id()
                );

            }
        );

    }


    return $query;
}

}