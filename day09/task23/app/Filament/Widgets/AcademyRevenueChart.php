<?php

namespace App\Filament\Widgets;


use App\Models\Payment;


use Filament\Widgets\ChartWidget;



class AcademyRevenueChart extends ChartWidget
{

    protected static ?string $heading = 'Academy Revenue';



    protected function getData(): array
    {


        $payments = Payment::query()

            ->where('status','paid')

            ->selectRaw(
                'MONTH(paid_at) as month, SUM(amount) as total'
            )

            ->groupBy('month')

            ->orderBy('month')

            ->get();



        return [


            'datasets' => [

                [

                    'label'=>'Revenue',

                    'data'=>$payments

                        ->pluck('total')

                        ->toArray(),

                ],

            ],




            'labels'=>$payments

                ->map(

                    fn($payment)=>

                    'Month '.$payment->month

                )

                ->toArray(),

        ];

    }




    protected function getType(): string
    {

        return 'line';

    }

}