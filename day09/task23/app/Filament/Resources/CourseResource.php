<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Course;
use App\Models\User;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;


class CourseResource extends Resource
{

    protected static ?string $model = Course::class;


    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';


    protected static ?string $navigationGroup = 'Academy Management';


    protected static ?string $navigationLabel = 'Courses';



    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Forms\Components\Select::make('category_id')
                    ->relationship(
                        'category',
                        'name'
                    )
                    ->required(),


                Forms\Components\Select::make('instructor_id')
                    ->label('Instructor')
                    ->options(
                        User::where(
                            'role',
                            'instructor'
                        )
                            ->pluck(
                                'name',
                                'id'
                            )
                    )
                    ->required(),


                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),


                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(
                        ignoreRecord: true
                    ),


                Forms\Components\Textarea::make('short_description')
                    ->rows(3),


                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),


                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->minValue(0)
                    ->required(),


                Forms\Components\Select::make('level')
                    ->options([

                        'beginner' => 'Beginner',

                        'intermediate' => 'Intermediate',

                        'advanced' => 'Advanced',

                    ])
                    ->required(),


                Forms\Components\FileUpload::make('image')
                    ->image(),


                Forms\Components\Select::make('status')
                    ->options([

                        'draft' => 'Draft',

                        'pending' => 'Pending',

                        'published' => 'Published',

                        'completed' => 'Completed',

                        'rejected' => 'Rejected',

                    ])
                    ->required(),


                Forms\Components\DatePicker::make('start_date'),


                Forms\Components\DatePicker::make('end_date')
                    ->after('start_date'),


                Forms\Components\TextInput::make('maximum_students')
                    ->numeric()
                    ->minValue(1),

            ]);
    }




    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                Tables\Columns\ImageColumn::make('image'),


                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),


                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor'),


                Tables\Columns\TextColumn::make('price')
                    ->money('EUR'),


                Tables\Columns\TextColumn::make('status')
                    ->badge(),


                Tables\Columns\TextColumn::make('start_date')
                    ->date(),


                Tables\Columns\TextColumn::make('enrollments_count')
                    ->counts('enrollments')
                    ->label('Students'),

            ])


            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([

                        'draft' => 'Draft',

                        'pending' => 'Pending',

                        'published' => 'Published',

                        'completed' => 'Completed',

                        'rejected' => 'Rejected',

                    ]),

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




    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();


        if (
            auth()->check()
            &&
            auth()->user()->isInstructor()
        ) {

            $query->where(
                'instructor_id',
                auth()->id()
            );
        }


        return $query;
    }




    public static function getRelations(): array
    {
        return [

            RelationManagers\SectionsRelationManager::class,

            RelationManagers\AssignmentsRelationManager::class,

            RelationManagers\EnrollmentsRelationManager::class,

        ];
    }




    public static function getPages(): array
    {
        return [

            'index' => Pages\ListCourses::route('/'),

            'create' => Pages\CreateCourse::route('/create'),

            'edit' => Pages\EditCourse::route('/{record}/edit'),

        ];
    }
}
