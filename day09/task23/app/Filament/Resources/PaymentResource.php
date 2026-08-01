<?php

namespace App\Filament\Resources;


use App\Filament\Resources\PaymentResource\Pages;

use App\Models\Payment;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;



class PaymentResource extends Resource
{

    protected static ?string $model = Payment::class;


    protected static ?string $navigationIcon = 'heroicon-o-banknotes';


    protected static ?string $navigationGroup = 'Academy Management';





    public static function form(Form $form): Form
    {

        return $form->schema([



            Forms\Components\Select::make('enrollment_id')

                ->relationship(
                    'enrollment',
                    'id'
                )

                ->required(),





            Forms\Components\TextInput::make('amount')

                ->numeric()

                ->required(),




            Forms\Components\Select::make('payment_method')

                ->options([

                    'cash' => 'Cash',

                    'card' => 'Card',

                    'bank' => 'Bank',

                ]),




            Forms\Components\Select::make('status')

                ->options([

                    'pending' => 'Pending',

                    'paid' => 'Paid',

                    'failed' => 'Failed',

                    'refunded' => 'Refunded',

                ])

                ->required(),





            Forms\Components\TextInput::make('transaction_number'),




            Forms\Components\DateTimePicker::make('paid_at'),


        ]);
    }





    public static function table(Table $table): Table
    {

        return $table

            ->columns([



                Tables\Columns\TextColumn::make('enrollment.student.name')

                    ->label('Student'),




                Tables\Columns\TextColumn::make('amount')

                    ->money('EUR'),




                Tables\Columns\TextColumn::make('status')

                    ->badge(),




                Tables\Columns\TextColumn::make('paid_at')

                    ->dateTime(),



            ])




            ->filters([


                Tables\Filters\SelectFilter::make('status')

                    ->options([

                        'pending' => 'Pending',

                        'paid' => 'Paid',

                        'failed' => 'Failed',

                        'refunded' => 'Refunded',

                    ]),


            ])





            ->actions([

                Tables\Actions\EditAction::make()
                    ->after(function ($record) {

                        if ($record->status === 'paid') {

                            $record->enrollment()->update([
                                'status' => 'active',
                                'enrolled_at' => now(),
                            ]);
                        }
                    }),

                Tables\Actions\DeleteAction::make(),

            ]);
    }





    public static function getPages(): array
    {

        return [

            'index' => Pages\ListPayments::route('/'),

            'create' => Pages\CreatePayment::route('/create'),

            'edit' => Pages\EditPayment::route('/{record}/edit'),

        ];
    }
}
