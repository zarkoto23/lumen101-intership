@extends('layouts.app')

@section('content')
    <h1>Регистрация за курс</h1>

    <form method="POST" action="/courses/register">

        @csrf

        <div>
            <label>Име:</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}">

            @error('first_name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Фамилия:</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}">

            @error('last_name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Имейл:</label>
            <input type="email" name="email" value="{{ old('email') }}">

            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Възраст:</label>
            <input type="number" name="age" value="{{ old('age') }}">

            @error('age')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Специалност:</label>
            <input type="text" name="specialty" value="{{ old('specialty') }}">

            @error('specialty')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Курс:</label>
            <input type="text" name="course" value="{{ old('course') }}">

            @error('course')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Форма на обучение:</label>

            <select name="study_form">

                <option value="onsite" {{ old('study_form') == 'onsite' ? 'selected' : '' }}>
                    Присъствено
                </option>

                <option value="online" {{ old('study_form') == 'online' ? 'selected' : '' }}>
                    Онлайн
                </option>

            </select>

            @error('study_form')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">
            Регистрация
        </button>

    </form>
@endsection
