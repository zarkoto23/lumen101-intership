<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentSubmissionResource\Pages;
use App\Models\AssignmentSubmission;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;


class AssignmentSubmissionResource extends Resource
{
    protected static ?string $model = AssignmentSubmission::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';


    protected static ?string $navigationGroup = 'Academy Management';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([


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



                Forms\Components\Textarea::make('comment')
                    ->columnSpanFull(),



                Forms\Components\Select::make('status')
                    ->options([

                        'submitted' => 'Submitted',

                        'reviewed' => 'Reviewed',

                        'accepted' => 'Accepted',

                        'rejected' => 'Rejected',

                    ])
                    ->required(),



                Forms\Components\TextInput::make('points')
                    ->numeric(),



                Forms\Components\Textarea::make('instructor_feedback')
                    ->columnSpanFull(),



                Forms\Components\DateTimePicker::make('submitted_at'),



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



                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime(),

            ])

            ->filters([


                Tables\Filters\SelectFilter::make('status')
                    ->options([

                        'submitted' => 'Submitted',

                        'reviewed' => 'Reviewed',

                        'accepted' => 'Accepted',

                        'rejected' => 'Rejected',

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

            'index' => Pages\ListAssignmentSubmissions::route('/'),

            'create' => Pages\CreateAssignmentSubmission::route('/create'),

            'edit' => Pages\EditAssignmentSubmission::route('/{record}/edit'),

        ];
    }
}