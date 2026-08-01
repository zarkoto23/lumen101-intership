<?php

namespace App\Filament\Widgets;


use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Builder;

use Filament\Tables;

use Filament\Widgets\TableWidget as BaseWidget;



class LatestEnrollments extends BaseWidget
{


    protected function getTableQuery(): Builder|null
    {

        return Enrollment::query()

            ->latest()

            ->limit(10);

    }





    protected function getTableColumns(): array
    {

        return [

            Tables\Columns\TextColumn::make('student.name')
                ->label('Student')
                ->searchable(),



            Tables\Columns\TextColumn::make('course.title')
                ->label('Course')
                ->searchable(),



            Tables\Columns\TextColumn::make('status')
                ->badge(),



            Tables\Columns\TextColumn::make('enrolled_at')
                ->dateTime(),


        ];

    }


}