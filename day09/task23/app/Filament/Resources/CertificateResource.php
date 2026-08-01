<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CertificateResource\Pages;

use App\Models\Certificate;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;


class CertificateResource extends Resource
{

    protected static ?string $model = Certificate::class;


    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';


    protected static ?string $navigationGroup = 'Academy Management';




    public static function form(Form $form): Form
    {

        return $form->schema([



            Forms\Components\Select::make('enrollment_id')

                ->relationship(
                    'enrollment',
                    'id'
                )

                ->required()

                ->unique(
                    table: 'certificates',
                    column: 'enrollment_id',
                    ignoreRecord: true
                ),





            Forms\Components\TextInput::make('certificate_number')

                ->required(),





            Forms\Components\DateTimePicker::make('issued_at'),





            Forms\Components\FileUpload::make('file_path'),



        ]);
    }





    public static function table(Table $table): Table
    {

        return $table

            ->columns([



                Tables\Columns\TextColumn::make('certificate_number')

                    ->searchable(),




                Tables\Columns\TextColumn::make('enrollment.student.name')

                    ->label('Student'),




                Tables\Columns\TextColumn::make('enrollment.course.title')

                    ->label('Course'),




                Tables\Columns\TextColumn::make('issued_at')

                    ->dateTime(),



            ])





            ->actions([

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

            ]);
    }


    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin();
    }




    public static function getPages(): array
    {

        return [

            'index' => Pages\ListCertificates::route('/'),

            'create' => Pages\CreateCertificate::route('/create'),

            'edit' => Pages\EditCertificate::route('/{record}/edit'),

        ];
    }
}
