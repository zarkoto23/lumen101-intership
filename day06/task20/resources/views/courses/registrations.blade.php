@extends('layouts.app')

@section('content')
    <h1>Регистрирани студенти</h1>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>

        <tr>
            <th>Име</th>
            <th>Фамилия</th>
            <th>Имейл</th>
            <th>Възраст</th>
            <th>Специалност</th>
            <th>Курс</th>
            <th>Форма</th>
        </tr>

        @foreach ($registrations as $registration)
            <tr>
                <td>{{ $registration->first_name }}</td>
                <td>{{ $registration->last_name }}</td>
                <td>{{ $registration->email }}</td>
                <td>{{ $registration->age }}</td>
                <td>{{ $registration->specialty }}</td>
                <td>{{ $registration->course }}</td>
                <td>{{ $registration->study_form }}</td>
            </tr>
        @endforeach

    </table>
@endsection
