<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Профил на студент</title>
    {{-- @vite(['resources/css/student.css']) --}}
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
</head>

<body>

    <div class="student-card">

    <h1>{{ $firstName }} {{ $lastName }}</h1>

    <div class="info">
        <p><strong>Възраст:</strong> {{ $age }}</p>
        <p><strong>Специалност:</strong> {{ $specialty }}</p>
        <p><strong>Курс:</strong> 
            @if($course >= 3)
                Горен курс
            @else
                Начален курс
            @endif
        </p>
        <p><strong>Имейл:</strong> {{ $email }}</p>
    </div>

</div>
</body>

</html>
